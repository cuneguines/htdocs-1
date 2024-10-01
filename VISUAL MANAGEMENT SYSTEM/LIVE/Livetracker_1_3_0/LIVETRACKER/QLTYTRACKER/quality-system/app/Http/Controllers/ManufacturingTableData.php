<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Manufacturing_tableData;
use App\Models\GlobalOwnerNdt;
class  ManufacturingTableData extends Controller
{
    public function getManufacturingDataByProcessOrder(Request $request)
    {
        $processOrderNumber = $request->input('process_order_number');

        // Retrieve data based on the process order number to get the latest record
        $data = Manufacturing_tableData::where('process_order_number', $processOrderNumber)
            ->orderBy('updated_at', 'desc')
            ->first();

        return response()->json(['data' => $data]);
    }



    public function getOwnerData_Manufacturing(Request $request)
    {
        //$processOrderNumber = $request->input('process_order_number');
    
        $processOrderNumber = $request->input('process_order_number');
        $Type = $request->input('Type');
    
        // Query to fetch the latest record based on process_order_number, Quality_Step = 'Engineering', and Type
        $data = DB::select(
            'SELECT TOP 1 * FROM QUALITY_PACK.dbo.Planning_Owner_NDT WHERE process_order_number = ? AND Quality_Step = ? AND Type = ? ORDER BY updated_at DESC',
            [$processOrderNumber, 'Manufacturing',$Type]
        );
    
        // Check if data is found
        if (empty($data)) {
            // Return an appropriate response if no data found
            return response()->json(['error' => 'No data found for the given parameters.'], 404);
        }
    
        // Return JSON response with the fetched data
        return response()->json(['data' => $data]);
    }
    
}
