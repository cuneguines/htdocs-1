<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaterialPreparation_tableData;

class MaterialTableDataController extends Controller
{
    public function getMaterialPreparationDataByProcessOrder(Request $request)
    {
        $processOrderNumber = $request->input('process_order_number');

        // Retrieve data based on the process order number to get the latest record
        $data = MaterialPreparation_tableData::where('process_order_number', $processOrderNumber)
            ->orderBy('updated_at', 'desc')
            ->first();

        return response()->json(['data' => $data]);
    }
}
