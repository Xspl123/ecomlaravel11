<?php

namespace App\Http\Controllers;

use App\Models\Coupan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
        \Log::info("Applying Coupon: $coupon_code");
        \Log::info("Cart Subtotal: " . Cart::instance('cart')->subtotal());

        // Find the coupon
        $coupan = Coupan::where('code', $coupon_code)
        ->where('expiry_date', '>=', Carbon::today())
        ->where('cart_value', '<=', Cart::instance('cart')->subtotal())
        ->first();

    if ($coupan) {
        \Log::info('Coupon Found: ', ['coupan' => $coupan]);
    } else {
        \Log::info('No Coupon Found');
    }



        // Additional Debugging Logs
        \Log::info("Checking conditions - Expiry Date: " . Carbon::today()->toDateString());
        \Log::info("Database Query Result: ", $coupan ? $coupan->toArray() : ['No Coupon Found']);

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

    }

