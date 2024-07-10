<?php

namespace App\Http\Controllers;

use App\Models\PlanningFormData; 
use App\Models\Planning_tableData; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\GlobalOwnerNdt; 

class PlanningTableData extends Controller
{
    public function getPlanningDataByProcessOrder_old(Request $request)
    {
        $processOrderNumber = $request->input('process_order_number');

        // SQL query with common table expression (CTE)
        $sql = "
            SELECT TOP 1
                p.*,
                (
                    SELECT user_requirement_specifications_document
                    FROM (
                        SELECT 
                            user_requirement_specifications_document,
                            ROW_NUMBER() OVER (ORDER BY created_at DESC) AS rn
                        FROM [QUALITY_PACK].[dbo].[PlanningFormData]
                        WHERE user_requirement_specifications_document IS NOT NULL 
                        AND process_order_number = ?
                    ) AS sub1
                    WHERE rn = 1
                ) AS user_requirement_specifications_document,
                (
                    SELECT pre_engineering_check_document
                    FROM (
                        SELECT 
                            pre_engineering_check_document,
                            ROW_NUMBER() OVER (ORDER BY created_at DESC) AS rn
                        FROM [QUALITY_PACK].[dbo].[PlanningFormData]
                        WHERE pre_engineering_check_document IS NOT NULL 
                        AND process_order_number = ?
                    ) AS sub2
                    WHERE rn = 1
                ) AS pre_engineering_check_document,
                (
                    SELECT purchase_order_document
                    FROM (
                        SELECT 
                            purchase_order_document,
                            ROW_NUMBER() OVER (ORDER BY created_at DESC) AS rn
                        FROM [QUALITY_PACK].[dbo].[PlanningFormData]
                        WHERE purchase_order_document IS NOT NULL 
                        AND process_order_number = ?
                    ) AS sub3
                    WHERE rn = 1
                ) AS purchase_order_document
            FROM [QUALITY_PACK].[dbo].[PlanningFormData] p
            WHERE p.process_order_number = ?
            ORDER BY p.created_at DESC;
        ";

        // Execute the query
        $result = DB::connection('sqlsrv')->select($sql, [$processOrderNumber, $processOrderNumber, $processOrderNumber, $processOrderNumber]);

        // Check if there are any results
        if (!empty($result)) {
            // Get the first item
            $data = $result[0];
        } else {
            $data = null;
        }

        return response()->json(['data' => $data]);
    }

    public function getPlanningDataByProcessOrder(Request $request)
    {

        $processOrderNumber = $request->input('process_order_number');
    
            // Retrieve data based on the process order number to get the latest record
            $data = Planning_tableData::where('process_order_number', $processOrderNumber)
                ->orderBy('updated_at', 'desc')
                ->first();
    
            return response()->json(['data' => $data]);
    }


    public function getOwnerData_Planning(Request $request)
       {
           //$processOrderNumber = $request->input('process_order_number');
       
           $processOrderNumber = $request->input('process_order_number');
           $Type = $request->input('Type');
       
           // Query to fetch the latest record based on process_order_number, Quality_Step = 'Engineering', and Type
           $data = DB::select(
               'SELECT  TOP 1 * FROM QUALITY_PACK.dbo.Planning_Owner_NDT WHERE process_order_number = ? AND Quality_Step = ? AND Type = ? ORDER BY updated_at DESC',
               [$processOrderNumber, 'Planning',$Type]
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
