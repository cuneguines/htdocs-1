<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LineItem;

class GetLineController extends Controller
{
    public function getLineItems($processOrderId)
    {
        $lineItems = LineItem::where('PrOrder', $processOrderId)->get();

        // Return the line items as JSON response
        return response()->json($lineItems);
    }
}
