<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\LineItem;

class GetLineController extends Controller
{
    public function getLineItems_old($processOrderId)
    {
        $lineItems = LineItem::where('PrOrder', $processOrderId)->get();

        // Return the line items as JSON response
        return response()->json($lineItems);
        
    }


    public function getLineItems($processOrderId)
    {
        $processOrderNumber = $processOrderId;

        $sql="select  distinct t0.DocNum [SalesOrder],
        t0.CardName [Customer],
        t7.PrOrder[ProcessOrder],
		t7.EndProduct[EndProduct],
		t2.SlpName[Engineer],t7.Owner
from Kentstainless.dbo.iis_epc_pro_orderh t7
left join Kentstainless.dbo.ordr t0 on t0.DocNum=t7.SONum
LEFT JOIN Kentstainless.dbo.rdr1 t3 ON t3.DocEntry = t0.DocEntry
       

		 INNER JOIN Kentstainless.dbo.ohem t1 ON t1.empID = t0.OwnerCode  
        INNER JOIN Kentstainless.dbo.oslp t2 ON t2.SlpCode = t0.SlpCode
        INNER JOIN Kentstainless.dbo.ocrd t4 ON t4.CardCode = t0.CardCode
		where t7.PrOrder=?
";
        // Execute the query
$result = DB::connection('sqlsrv')->select($sql, [$processOrderNumber]);

// Check if there are any results
if (!empty($result)) {
    // Get the first item
    $data = $result[0];
} else {
    $data = null;
}

return response()->json(['data' => $data]);
        
    }
}

