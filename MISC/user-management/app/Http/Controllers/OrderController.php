<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        try {
            $orders = Order::query()->take(10)->get();
            return view('orders.index', compact('orders'));
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            return "An error occurred: " . $e->getMessage();
        }
    }
}
