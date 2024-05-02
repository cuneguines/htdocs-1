<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentationFormData;
use App\Models\DocumentationCompleteData;
class DocumentationController extends Controller
{
    /**
     * Submit Documentation Form Data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function submitDocumentationForm(Request $request)
    {
        // Validate the request data if needed

        // Create a new instance of Documentation
        $documentation = new DocumentationFormData;
        $documentation->process_order_number = $request->input('process_order_number');
        $documentation->engineer = $request->input('engineer');
        $documentation->technical_file =  $request->input('technical_file');
        $documentation->client_handover_documentation=$request->input('client_handover_documentation');
        
        // Save the Documentation Form Data
        $documentation->save();

        // You can return a response or redirect as needed
        return response()->json(['data' => $documentation]);
    }

    /**
     * Get Documentation Data By Process Order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getDocumentationDataByProcessOrder(Request $request)
    {
        $processOrderID = $request->input('process_order_number');

        // Retrieve data based on the process order ID to get the latest record
        $data = DocumentationFormData::where('process_order_number', $processOrderID)
            ->orderBy('updated_at', 'desc')
            ->first();

        return response()->json(['data' => $data]);
    }

    /**
     * View Documentation Form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function viewDocumentationForm(Request $request)
    {
        $processOrderID = $request->input('process_order_number');

        // Retrieve data based on the process order ID to get the latest record
        $data = Documentation::where('process_order_number', $processOrderID)
            ->orderBy('updated_at', 'desc')
            ->first();

        return response()->json(['data' => $data]);
    }
/**
     * View Documentation Form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

 public function submitDocumentationCompleteForm(Request $request)
 {
    // Validate the request data if needed

    // Create a new instance of the DocumentationCompleteData model
    $documentationCompleteData = new DocumentationCompleteData;
    $documentationCompleteData->process_order_number = $request->input('process_order_number');
    $documentationCompleteData->technical_file = $request->input('technical_file') ;
    $documentationCompleteData->client_handover_documentation = $request->input('client_handover_documentation') ;
    $documentationCompleteData->sign_off_documentation = $request->input('sign_off_documentation');
    $documentationCompleteData->comments_documentation = $request->input('comments_documentation');
    $documentationCompleteData->status = $request->input('status');
    $documentationCompleteData->quantity = $request->input('quantity');
    $documentationCompleteData->labelattached = $request->input('labels_attached') ;
    // Add other fields accordingly

    $documentationCompleteData->save();

    // You can return a response or redirect as needed
    return response()->json(['data' => $documentationCompleteData]);
 }

 public function viewDocumentationCompleteForm(Request $request)
    {
        $processOrderNumber = $request->input('process_order_number');

        // Retrieve data based on the process order number to get the latest record
        $data = DocumentationCompleteData::where('process_order_number', $processOrderNumber)
            ->orderBy('updated_at', 'desc')
            ->first();

        return response()->json(['data' => $data]);
    }
}