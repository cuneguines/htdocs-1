<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Planning_tableData;
class PlanningTableData extends Controller
{
    public function getPlanningDataByProcessOrder(Request $request)
    {
        $processOrderNumber = $request->input('process_order_number');

        // Retrieve data based on the process order number to get the latest record
        $data = Planning_tableData::where('process_order_number', $processOrderNumber)
        ->orderBy('updated_at', 'desc')
        ->first();


        return response()->json(['data' => $data]);
    }
}
