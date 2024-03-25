<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubContractFormData;
use App\Models\SubContractCompleteData;

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
}