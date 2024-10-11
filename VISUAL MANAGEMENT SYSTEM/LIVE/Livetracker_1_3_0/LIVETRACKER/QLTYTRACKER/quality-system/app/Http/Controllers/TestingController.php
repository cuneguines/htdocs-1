<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TestingFormData;
use App\Models\TestingCompleteData;
use App\Models\GlobalOwnerNdt;
use Illuminate\Support\Facades\DB; 

class TestingController extends Controller
{
    /**
     * Submit Testing Form Data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function submitTestingForm(Request $request)
    {
        // Validate the request data if needed

        // Create a new instance of TestingFormData
        $testingFormData = new TestingFormData;
        $testingFormData->dye_pen_document_ref = $request->input('dye_pen_document_ref');
        $testingFormData->hydrostatic_test_document_ref = $request->input('hydrostatic_test_document_ref');
        $testingFormData->pneumatic_test_document_ref = $request->input('pneumatic_test_document_ref');
        $testingFormData->fat_protocol_document_ref = $request->input('fat_protocol_document_ref');
        $testingFormData->sign_off_testing = $request->input('sign_off_testing');
        $testingFormData->comments_testing = $request->input('comments_testing');
        $testingFormData->submission_date = $request->input('submission_date');
        $testingFormData->process_order_number = $request->input('process_order_number');
        $testingFormData->dye_pen_test = $request->input('dye_pen_test');
        $testingFormData->hydrostatic_test = $request->input('hydrostatic_test');
        $testingFormData->pneumatic_test = $request->input('pneumatic_test');
        $testingFormData->fat_protocol = $request->input('fat_protocol');
        $testingFormData->testing_document_file_name = $request->input('testing_document_file_name');
        // Assuming 'testing_documents' is the field to store the uploaded file name

        // Save the Testing Form Data
        $testingFormData->save();



        $owners = $request->input('owners_test');
        foreach ($owners as $ownerData) {
            $owner = new GlobalOwnerNdt();
            $owner->Type = $ownerData['type'];
            $owner->owner = $ownerData['owner'];
            $owner->ndta = $ownerData['ndt'];
            $owner->process_order_number = $request->input('process_order_number');
            $owner->Quality_Step = 'Testing';
            //$owner->planning_form_data_id = $planningData->id;
            $owner->save();
        }

        // You can return a response or redirect as needed
        return response()->json(['data' => $testingFormData]);
    }

    /**
     * Get Testing Data By Process Order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getTestingDataByProcessOrder(Request $request)
    {
        $processOrderID = $request->input('process_order_number');

        // Retrieve data based on the process order ID to get the latest record
        $data = TestingFormData::where('process_order_number', $processOrderID)
            ->orderBy('updated_at', 'desc')
            ->first();

        return response()->json(['data' => $data]);
    }

    /**
     * View Testing Form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function viewTestingForm(Request $request)
    {
        $processOrderID = $request->input('process_order_number');

        // Retrieve data based on the process order ID to get the latest record
        $data = TestingFormData::where('process_order_number', $processOrderID)
            ->orderBy('updated_at', 'desc')
            ->first();

        return response()->json(['data' => $data]);
    }
    
    public function submitTestingCompleteForm(Request $request)
    {
        // Validate the request data if needed

        // Create a new instance of the TestingData model
        $testingData = new TestingCompleteData;
        $testingData->process_order_number = $request->input('process_order_number');
        $testingData->dye_pen_testing = $request->input('dye_pen_testing');
        //$testingData->dye_pen_document_ref = $request->input('dye_pen_document_ref');
        $testingData->hydrostatic_testing = $request->input('hydrostatic_testing');
        //$testingData->hydrostatic_test_document_ref = $request->input('hydrostatic_test_document_ref');
        $testingData->pneumatic_testing= $request->input('pneumatic_testing');
       // $testingData->pneumatic_test_document_ref = $request->input('pneumatic_test_document_ref');
        $testingData->fat_protocoll = $request->input('fat_protocoll');
//$testingData->fat_protocol_document_ref = $request->input('fat_protocol_document_ref');
        $testingData->testing_document_file_name = $request->input('testing_document_file_name');
        $testingData->sign_off = $request->input('sign_off');
        $testingData->comments_testing = $request->input('comments_testing');
        $testingData->submission_date = $request->input('submission_date');
        $testingData->status = $request->input('status');
        $testingData->quantity = $request->input('quantity');
        // Add other fields accordingly

        $testingData->save();





        // You can return a response or redirect as needed
        return response()->json(['data' => $testingData]);
    }

    /**
     * View Testing Data By Process Order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function viewTestingCompleteForm(Request $request)
    {
        $processOrderNumber = $request->input('process_order_number');

        // Retrieve data based on the process order number to get the latest record
        $data = TestingCompleteData::where('process_order_number', $processOrderNumber)
            ->orderBy('updated_at', 'desc')
            ->first();

        return response()->json(['data' => $data]);
    }


    public function getOwnerData_testing(Request $request)
    {
        //$processOrderNumber = $request->input('process_order_number');
    
        $processOrderNumber = $request->input('process_order_number');
        $Type = $request->input('Type');
    
        // Query to fetch the latest record based on process_order_number, Quality_Step = 'Engineering', and Type
        $data = DB::select(
            'SELECT TOP 1 * FROM QUALITY_PACK.dbo.Planning_Owner_NDT WHERE process_order_number = ? AND Quality_Step = ? AND Type = ? ORDER BY updated_at DESC',
            [$processOrderNumber, 'Testing',$Type]
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
