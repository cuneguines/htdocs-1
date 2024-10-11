<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentationFormData;
use App\Models\DocumentationCompleteData;
use App\Models\GlobalOwnerNdt; 

use Illuminate\Support\Facades\DB;
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
        $documentation->technical_file_check=$request->input('technical_file_check');
        $documentation->client_handover_check=$request->input('client_handover_check');
        $documentation->comments_documentation=$request->input('comments_documentation');


        $owners = $request->input('owners_docu');
        foreach ($owners as $ownerData) {
            $owner = new GlobalOwnerNdt();
            $owner->Type = $ownerData['type'];
            $owner->owner = $ownerData['owner'];
            $owner->ndta = $ownerData['ndt'];
            $owner->process_order_number = $request->input('process_order_number');
            $owner->Quality_Step = 'Documentation';
            //$owner->planning_form_data_id = $planningData->id;
            $owner->save();
        }
        
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


    public function getOwnerData_docu(Request $request)
{
    //$processOrderNumber = $request->input('process_order_number');

    $processOrderNumber = $request->input('process_order_number');
    $Type = $request->input('Type');

    // Query to fetch the latest record based on process_order_number, Quality_Step = 'Engineering', and Type
    $data = DB::select(
        'SELECT TOP 1 * FROM QUALITY_PACK.dbo.Planning_Owner_NDT WHERE process_order_number = ? AND Quality_Step = ? AND Type = ? ORDER BY updated_at DESC',
        [$processOrderNumber, 'Documentation',$Type]
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