<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Coupan;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function index()
    {
        $items = Cart::instance('cart')->content();
        return view('cart', compact('items'));
    }


    public function add(Request $request)
    {
        Cart::instance('cart')->add(
            $request->id,
            $request->name,
            $request->quantity,
            $request->price,
        )->associate('App\Models\Product');

        return redirect()->back();
    }

    public function increase_cart_quantity(Request $request, $rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty + 1;
        Cart::instance('cart')->update($rowId, $qty);
        return redirect()->back();
    }

    public function decrease_cart_quantity(Request $request, $rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty - 1;
        if ($qty < 1) {
            Cart::instance('cart')->remove($rowId);
        } else {
            Cart::instance('cart')->update($rowId, $qty);
        }
        return redirect()->back();
    }

    public function remove_cart_item(Request $request, $rowId)
    {
        Cart::instance('cart')->remove($rowId);
        return redirect()->back()->with('success', 'Item removed from cart');
    }

    public function clear_cart()
    {
        Cart::instance('cart')->destroy();
        return redirect()->back()->with('success', 'Cart cleared successfully');
    }

    public function apply_coupon(Request $request)
    {
        $coupon_code = $request->coupon_code;

        if (isset($coupon_code)) {

            // Find the coupon
            $coupan = Coupan::where('code', $coupon_code)
                ->where('expiry_date', '>=', Carbon::today())
                ->where('cart_value', '<=', Cart::instance('cart')->subtotal())
                ->first();

            if ($coupan) {
            } else {
            }

            if (!$coupan) {
                return redirect()->back()->with('error', 'Invalid coupon code or expired date');
            } else {
                Session::put('coupan', [
                    'code' => $coupan->code,
                    'type' => $coupan->type,
                    'value' => $coupan->value,
                    'cart_value' => $coupan->cart_value,
                ]);

                $this->calculateDiscount();

                return redirect()->back()->with('success', 'Coupon applied successfully');
            }
        } else {
            return redirect()->back()->with('error', 'Please enter a coupon code');
        }
    }

    public function calculateDiscount()
    {
        $discount = 0;
        if (Session::has('coupan')) {
            if (Session::get('coupan')['type'] == 'fixed') {
                $discount = Session::get('coupan')['value'];
            } else {
                $discount = (Cart::instance('cart')->subtotal() * Session::get('coupan')['value']) / 100;
            }

            $subtotalAfterDiscount = Cart::instance('cart')->subtotal() - $discount;
            $taxAfterDiscount = ($subtotalAfterDiscount * config('cart.tax')) / 100;
            $totalAfterDiscount = $subtotalAfterDiscount + $taxAfterDiscount;

            Session::put('discounts', [
                'discount' => $discount,
                'subtotal' => $subtotalAfterDiscount,
                'tax' => $taxAfterDiscount,
                'total' => $totalAfterDiscount,
            ]);
        }
    }

    public function remove_coupon()
    {
        Session::forget('coupan');
        Session::forget('discounts');
        return redirect()->back()->with('success', 'Coupon removed successfully');
    }


    public function checkout()
    {

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $address = Address::where('user_id', Auth::user()->id)->where('is_default', 1)->first();

        return view('checkout', compact('address'));
    }

    public function place_order(Request $request)
    {
        $user_id = Auth::user()->id;

        Log::info('Placing order for user ID: ' . $user_id);

        // Fetch default address for user
        $address = Address::where('user_id', $user_id)->where('is_default', true)->first();

        if (!$address) {
            Log::info('No default address found. Validating and creating new address.');

            // Validate address fields if not present in database


            // Create a new address
            $address = new Address();
            $address->user_id = $user_id;
            $address->name = $request->name;
            $address->phone = $request->phone;
            $address->zip = $request->zip;
            $address->city = $request->city;
            $address->state = $request->state;
            $address->country = 'India';
            $address->address = $request->address;
            $address->landmark = $request->landmark;
            $address->locality = $request->locality;
            $address->is_default = true;
            $address->save();

            Log::info('New Address Created: ' . json_encode($address));
        } else {
            Log::info('Default address found: ' . json_encode($address));
        }

        // Set amount for checkout
        $this->setAmountForCheckout();

        // Create new order
        $order = new Order();
        $order->user_id = $user_id;
        $order->subtotal = $this->parseDecimal(Session::get('checkout')['subtotal'] ?? 0);
        $order->discount = $this->parseDecimal(Session::get('checkout')['discount'] ?? 0);
        $order->tax = $this->parseDecimal(Session::get('checkout')['tax'] ?? 0);
        $order->total = $this->parseDecimal(Session::get('checkout')['total'] ?? 0);
        $order->name = $address->name;
        $order->phone = $address->phone;
        $order->locality = $address->locality;
        $order->address = $address->address;
        $order->city = $address->city;
        $order->state = $address->state;
        $order->country = $address->country;
        $order->landmark = $address->landmark;
        $order->zip = $address->zip;
        $order->save();


        Log::info('New Order Created: ' . json_encode($order));

        // Create order items
        foreach (Cart::instance('cart')->content() as $item) {
            $order_item = new \App\Models\OrderItem();
            $order_item->order_id = $order->id;
            $order_item->product_id = $item->id;
            $order_item->quantity = $item->qty;
            $order_item->price = $item->price;
            $order_item->save();

            Log::info('Order Item Created: ' . json_encode($order_item));
        }

        // Handle payment method
        if ($request->mode == "card") {
            Log::info('Card payment selected, but not implemented yet.');
            // Implement card payment processing here
        } elseif ($request->mode == "paypal") {
            Log::info('PayPal payment selected, but not implemented yet.');
            // Implement PayPal payment processing here
        } elseif ($request->mode == "cod") {
            $transaction = new Transaction();
            $transaction->order_id = $order->id;
            $transaction->user_id = $user_id;
            $transaction->mode = $request->mode;
            $transaction->status = 'Pending';
            $transaction->save();

            Log::info('New Transaction Created: ' . json_encode($transaction));
        }

        // Clear cart and session data
        Cart::instance('cart')->destroy();
        Session::forget('checkout');
        Session::forget('coupan');
        Session::forget('discounts');
        Session::put('order_id', $order->id);

        Log::info('Cart and session cleared, redirecting to confirmation.');

        return redirect()->route('cart.order_confirmation');
    }
    private function parseDecimal($value)
    {
        // Remove any commas and convert to a float
        return (float)str_replace(',', '', $value);
    }



    public function setAmountForCheckout()
    {
        if (!Cart::instance('cart')->content()->count() > 0) {
            Session::forget('checkout');
            return;
        }

        if (Session::has('coupan')) {
            Session::put('checkout', [
                'discount' => Session::get('discounts')['discount'],
                'subtotal' => Session::get('discounts')['subtotal'],
                'tax' => Session::get('discounts')['tax'],
                'total' => Session::get('discounts')['total'],
            ]);
        } else {
            Session::put('checkout', [
                'discount' => 0,
                'subtotal' => Cart::instance('cart')->subtotal(),
                'tax' => Cart::instance('cart')->tax(),
                'total' => Cart::instance('cart')->total(),
            ]);
        }
    }

    public function order_confirmation()
    {

        if (Session::has('order_id')) {
            $id = Session::get('order_id');
            $order = Order::find($id);
            return view('order_confirmation', compact('order'));
        }

        return redirect()->route('cart.index');
    }
}
