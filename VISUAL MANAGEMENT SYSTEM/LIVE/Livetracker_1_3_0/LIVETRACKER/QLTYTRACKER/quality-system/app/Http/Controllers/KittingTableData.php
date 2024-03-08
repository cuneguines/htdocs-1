<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kitting_tableData; 
class KittingTableData extends Controller
{
    //
    public function getKittingDataByProcessOrder(Request $request)
    {
        $processOrderNumber = $request->input('process_order_number');

        // Retrieve data based on the process order number to get the latest record
        $data = Kitting_tableData::where('ProcessOrderID', $processOrderNumber)
            ->orderBy('updated_at', 'desc')
            ->first();

        return response()->json(['data' => $data]);
    }
}
