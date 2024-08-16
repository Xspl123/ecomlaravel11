<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }


    public function orders()
    {
        $orders = Order::where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'DESC')
            ->paginate(10);
        return view('user.orders', compact('orders'));
    }

    public function order_details($id)
    {
        $order = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->first();
        if ($order) {
            $order = Order::where('id', $id)->first();

            $order_items = OrderItem::where('order_id', $id)->orderBy('id')->paginate(3);
            $transactions = Transaction::where('order_id', $id)->first();
            return view('user.order_details', compact('order', 'order_items', 'transactions'));
        }

        return redirect()->route('login');
    }

    public function canceled_order(Request $request){
        $order = Order::find($request->id);
        $order->status = 'cancelled';
        $order->cancelled_date = Carbon::now();
        $order->save();
        return redirect()->route('user.order_details',$request->id)->with('success', 'Order cancelled successfully.');

    }
}
