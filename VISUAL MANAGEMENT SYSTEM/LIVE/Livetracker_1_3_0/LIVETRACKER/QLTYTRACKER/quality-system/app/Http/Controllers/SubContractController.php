<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubContractFormData;
use App\Models\SubContractCompleteData;
use App\Models\GlobalOwnerNdt; 
use Illuminate\Support\Facades\DB;
class SubContractController extends Controller
{
    /**
     * Submit Subcontract Form Data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function submitSubcontractForm(Request $request)
    {
        // Validate the request data if needed

        // Create a new instance of SubcontractFormData
        $subcontractFormData = new SubcontractFormData;
        $subcontractFormData->sub_contract_action = $request->input('sub_contract_action');
        $subcontractFormData->sign_off_sub_contract = $request->input('sign_off_sub_contract');
        $subcontractFormData->comments_sub_contract = $request->input('comments_sub_contract');
        $subcontractFormData->submission_date = $request->input('submission_date');
        $subcontractFormData->process_order_number = $request->input('process_order_number');
        $subcontractFormData->sub_contract_file = $request->input('sub_contract_file');
        // Add other fields accordingly

        // Save the Subcontract Form Data
        $subcontractFormData->save();

        $owners = $request->input('owners_sub');
        foreach ($owners as $ownerData) {
            $owner = new GlobalOwnerNdt();
            $owner->Type = $ownerData['type'];
            $owner->owner = $ownerData['owner'];
            $owner->ndta = $ownerData['ndt'];
            $owner->process_order_number = $request->input('process_order_number');
            $owner->Quality_Step = 'SubContract';
            //$owner->planning_form_data_id = $planningData->id;
            $owner->save();
        }



        // You can return a response or redirect as needed
        return response()->json(['data' => $subcontractFormData]);
    }

    /**
     * Get Subcontract Data By Process Order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getSubcontractDataByProcessOrder(Request $request)
    {
        $processOrderNumber = $request->input('process_order_number');

        // Retrieve data based on the process order number to get the latest record
        $data = SubcontractFormData::where('process_order_number', $processOrderNumber)
            ->orderBy('updated_at', 'desc')
            ->first();

        return response()->json(['data' => $data]);
    }

    /**
     * View Subcontract Form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function viewSubcontractForm(Request $request)
    {
        $processOrderNumber = $request->input('process_order_number');

        // Retrieve data based on the process order number to get the latest record
        $data = SubcontractFormData::where('process_order_number', $processOrderNumber)
            ->orderBy('updated_at', 'desc')
            ->first();

        return response()->json(['data' => $data]);
    }


public function submitSubContractCompleteForm(Request $request)
{
   // Validate the request data if needed

   // Create a new instance of SubcontractCompleteData
   $subcontractCompleteData = new SubContractCompleteData;
   $subcontractCompleteData->process_order_number = $request->input('process_order_number');
   $subcontractCompleteData->sub_contract_action = $request->input('sub_contract_action');
   $subcontractCompleteData->sign_off_sub_contract = $request->input('sign_off_sub_contract');
   $subcontractCompleteData->comments_sub_contract = $request->input('comments_sub_contract');
   $subcontractCompleteData->submission_date = $request->input('submission_date');
   //$subcontractCompleteData->sub_contract_file = $request->input('sub_contract_file');
   $subcontractCompleteData->status = $request->input('status');
   $subcontractCompleteData->quantity = $request->input('quantity');
   // Add other fields accordingly

   // Save the Subcontract Complete Data
   $subcontractCompleteData->save();

   // You can return a response or redirect as needed
   return response()->json(['data' => $subcontractCompleteData]);
}

/**
* View Subcontract Complete Data By Process Order.
*
* @param  \Illuminate\Http\Request  $request
* @return \Illuminate\Http\Response
*/
public function viewSubContractCompleteForm(Request $request)
{
   $processOrderNumber = $request->input('process_order_number');

   // Retrieve data based on the process order number to get the latest record
   $data = SubcontractCompleteData::where('process_order_number', $processOrderNumber)
       ->orderBy('updated_at', 'desc')
       ->first();

   return response()->json(['data' => $data]);
}


public function getOwnerData_subcontract(Request $request)
{
    //$processOrderNumber = $request->input('process_order_number');

    $processOrderNumber = $request->input('process_order_number');
    $Type = $request->input('Type');

    // Query to fetch the latest record based on process_order_number, Quality_Step = 'Engineering', and Type
    $data = DB::select(
        'SELECT TOP 1 * FROM QUALITY_PACK.dbo.Planning_Owner_NDT WHERE process_order_number = ? AND Quality_Step = ? AND Type = ? ORDER BY updated_at DESC',
        [$processOrderNumber, 'SubContract',$Type]
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