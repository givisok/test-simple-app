<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrdersController extends Controller
{
    public function getOrdersList(Order $order)
    {
        $orders = $order::with('products')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('orders.index', ['orders' => $orders]);
    }
}