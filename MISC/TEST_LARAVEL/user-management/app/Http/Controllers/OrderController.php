<?php

// app/Http/Controllers/OrderController.php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function showTopTenOrders()
    {
        #$topTenOrders = Order::getTopTenOrders();
        return view('orders.index');
    }
}
