<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProcessOrder; // Adjust the namespace as needed
use App\Models\Orders;

use Illuminate\Support\Facades\Session;
class HomeController extends Controller
{
    //use App\Models\ProcessOrder; // Import the ProcessOrder model

public function showProcessOrdersForm()
{
    $userId = Session::get('user');
    $processOrders = Orders::where('PrOrder', '>', 30000)
    ->select('PrOrder')
    ->distinct()
    ->get();
    // You can pass any additional data to the view here

    return view('processorders', compact('processOrders'));
   
}
}

