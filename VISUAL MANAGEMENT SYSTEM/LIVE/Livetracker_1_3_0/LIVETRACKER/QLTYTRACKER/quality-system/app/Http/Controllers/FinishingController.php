<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FinishingFormData;
use App\Models\FinishingCompleteData;
use Illuminate\Support\Facades\DB;
use App\Models\GlobalOwnerNdt; 
class FinishingController extends Controller
{
    /**
     * Submit Finishing Form Data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function submitFinishingForm(Request $request)
    {
        // Validate the request data if needed

        // Create a new instance of FinishingFormData
        $finishingFormData = new FinishingFormData;
        $finishingFormData->process_order_number = $request->input('process_order_number');
        $finishingFormData->pickle_passivate_test = $request->input('pickle_passivate_test');
        $finishingFormData->pickle_passivate_document_ref = $request->input('pickle_passivate_document_ref');
        $finishingFormData->pickle_passivate_document_file = $request->input('pickle_passivate_document_file');
        $finishingFormData->select_kent_finish_test = $request->input('select_kent_finish_test');
        $finishingFormData->select_kent_finish_document_ref = $request->input('select_kent_finish_document_ref');
        $finishingFormData->select_kent_finish_document_file = $request->input('select_kent_finish_document_file');
        $finishingFormData->sign_off_finishing = $request->input('sign_off_finishing');
        $finishingFormData->comments_finishing = $request->input('comments_finishing');
        $finishingFormData->submission_date = $request->input('submission_date');
        $finishingFormData->created_at = now();
        $finishingFormData->updated_at = now();

        // Save the Finishing Form Data
        $finishingFormData->save();
        $owners_finish = $request->input('owners_finishing');
        foreach ($owners_finish as $ownerData) {
            $owner = new GlobalOwnerNdt();
            $owner->Type = $ownerData['type'];
            $owner->owner = $ownerData['owner'];
            $owner->ndta = $ownerData['ndt'];
            $owner->process_order_number = $request->input('process_order_number');
            $owner->Quality_Step = 'Finishing';
            //$owner->planning_form_data_id = $planningData->id;
            $owner->save();
        }


        // You can return a response or redirect as needed
        return response()->json(['data' => $finishingFormData]);
    }

    /**
     * Get Finishing Data By Process Order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getFinishingDataByProcessOrder(Request $request)
    {
        $processOrderNumber = $request->input('process_order_number');

        // Retrieve data based on the process order number to get the latest record
        $data = FinishingFormData::where('process_order_number', $processOrderNumber)
            ->orderBy('updated_at', 'desc')
            ->first();

        return response()->json(['data' => $data]);
    }

    /**
     * Submit Finishing Complete Form Data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function submitFinishingCompleteForm(Request $request)
    {
        // Validate the request data if needed

        // Create a new instance of FinishingCompleteData
        $finishingCompleteData = new FinishingCompleteData;
        $finishingCompleteData->process_order_number = $request->input('process_order_number');
        $finishingCompleteData->pickle_passivate_test = $request->input('pickle_passivate_test');
        $finishingCompleteData->pickle_passivate_document_ref = $request->input('pickle_passivate_document_ref');
        $finishingCompleteData->select_kent_finish_test = $request->input('select_kent_finish_test');
        $finishingCompleteData->select_kent_finish_document_ref = $request->input('select_kent_finish_document_ref');
        $finishingCompleteData->sign_off_finishing = $request->input('sign_off_finishing');
        $finishingCompleteData->comments_finishing = $request->input('comments_finishing');
        $finishingCompleteData->submission_date = $request->input('submission_date');
        $finishingCompleteData->status = $request->input('status');
        $finishingCompleteData->quantity = $request->input('quantity');
        $finishingCompleteData->created_at = now();
        $finishingCompleteData->updated_at = now();
        // Add other fields accordingly

        $finishingCompleteData->save();

        // You can return a response or redirect as needed
        return response()->json(['data' => $finishingCompleteData]);
    }

    /**
     * View Finishing Complete Form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function viewFinishingCompleteForm(Request $request)
    {
        $processOrderNumber = $request->input('process_order_number');

        // Retrieve data based on the process order number to get the latest record
        $data = FinishingCompleteData::where('process_order_number', $processOrderNumber)
            ->orderBy('updated_at', 'desc')
            ->first();

        return response()->json(['data' => $data]);
    }
    public function getOwnerData_finishing(Request $request)
{
    //$processOrderNumber = $request->input('process_order_number');

    $processOrderNumber = $request->input('process_order_number');
    $Type = $request->input('Type');

    // Query to fetch the latest record based on process_order_number, Quality_Step = 'Engineering', and Type
    $data = DB::select(
        'SELECT TOP 1 * FROM QUALITY_PACK.dbo.Planning_Owner_NDT WHERE process_order_number = ? AND Quality_Step = ? AND Type = ? ORDER BY updated_at DESC',
        [$processOrderNumber, 'Finishing',$Type]
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
