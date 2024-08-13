<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function dashboard()
    {
        $totalOrders = Order::count();
        $totalAmount = Order::sum('total');

        $pendingOrders = Order::where('status', 'pending')->count();
        $pendingOrdersAmount = Order::where('status', 'pending')->sum('total');

        $deliveredOrders = Order::where('status', 'delivered')->count();
        $deliveredOrdersAmount = Order::where('status', 'delivered')->sum('total');

        $canceledOrders = Order::where('status', 'canceled')->count();
        $canceledOrdersAmount = Order::where('status', 'canceled')->sum('total');

        return view('admin.index', compact(
            'totalOrders',
            'totalAmount',
            'pendingOrders',
            'pendingOrdersAmount',
            'deliveredOrders',
            'deliveredOrdersAmount',
            'canceledOrders',
            'canceledOrdersAmount'
        ));
    }

}
