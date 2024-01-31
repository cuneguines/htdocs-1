<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Engineer_tableData;
class EngineerTaableData extends Controller
{
    //// app/Http/Controllers/EngineerController.php





    public function getDataByProcessOrder(Request $request)
    {
        $processOrderNumber = $request->input('process_order_number');

        // Retrieve data based on the process order number to get the latest record
        $data = Engineer_tableData::where('process_order_number', $processOrderNumber)
        ->orderBy('updated_at', 'desc')
        ->first();


        return response()->json(['data' => $data]);
    }
}


