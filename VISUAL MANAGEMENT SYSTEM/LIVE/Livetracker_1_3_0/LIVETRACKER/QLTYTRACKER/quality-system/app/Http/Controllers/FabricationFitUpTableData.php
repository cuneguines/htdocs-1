<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fabrication_tableData;
class FabricationFitUpTableData extends Controller
{
    //

    public function getFabricationFitUpDataByProcessOrder(Request $request)
    {
        $processOrderNumber = $request->input('process_order_number');

        // Retrieve data based on the process order number to get the latest record
        $data = Fabrication_tableData::where('ProcessOrder', $processOrderNumber)
            ->orderBy('updated_at', 'desc')
            ->first();

        return response()->json(['data' => $data]);
    }
}
