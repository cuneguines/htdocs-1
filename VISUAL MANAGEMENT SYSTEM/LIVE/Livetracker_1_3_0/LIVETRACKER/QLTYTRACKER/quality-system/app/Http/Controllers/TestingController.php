<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TestingFormData;
use App\Models\TestingCompleteData;


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
        $testingData->dye_pen_test = $request->input('dye_pen_test');
        $testingData->dye_pen_document_ref = $request->input('dye_pen_document_ref');
        $testingData->hydrostatic_test = $request->input('hydrostatic_test');
        $testingData->hydrostatic_test_document_ref = $request->input('hydrostatic_test_document_ref');
        $testingData->pneumatic_test = $request->input('pneumatic_test');
        $testingData->pneumatic_test_document_ref = $request->input('pneumatic_test_document_ref');
        $testingData->fat_protocol = $request->input('fat_protocol');
        $testingData->fat_protocol_document_ref = $request->input('fat_protocol_document_ref');
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

}
