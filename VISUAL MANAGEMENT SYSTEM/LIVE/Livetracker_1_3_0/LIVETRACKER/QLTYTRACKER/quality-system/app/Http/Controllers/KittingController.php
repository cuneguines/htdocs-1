<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KittingFormData; 
use App\Models\GlobalOwnerNdt; 
use App\Models\Kitting_tableData; 
use App\Models\KittingCompleteData; 
use Illuminate\Support\Facades\DB;
class KittingController extends Controller
{
    //
    public function submitKittingForm(Request $request)
{
    // Validate the request data if needed

    // Assuming you have an Eloquent model named KittingFormData
    $kittingFormData = new KittingFormData;
    $kittingFormData->ProcessOrderID = $request->input('process_order_number');
    $kittingFormData->cut_form_mach_parts = $request->input('cut_form_mach_parts');
    $kittingFormData->bought_out_components = $request->input('bought_out_components');
    $kittingFormData->fasteners_fixings = $request->input('fasteners_fixings');
    $kittingFormData->site_pack = $request->input('site_pack');
    $kittingFormData->sign_off_kitting = $request->input('sign_off_kitting');
    $kittingFormData->comments_kitting = $request->input('comments_kitting');
    $kittingFormData->cut_form_mach_parts = $request->input('cut_form_mach_parts');
    $kittingFormData->bought_out_components = $request->input('bought_out_components');
    $kittingFormData->fasteners_fixings = $request->input('fasteners_fixings');
    $kittingFormData->site_pack = $request->input('site_pack');
    $kittingFormData->kitting_file = $request->input('kitting_file');
    // Add other kitting fields accordingly

    $kittingFormData->save();


// Validate the input data
$request->validate([
    'owners_kit' => 'required|array',
    'owners_kit.*.type' => 'required|string',
    'owners_kit.*.owner' => 'required|string',
    'owners_kit.*.ndt' => 'required|string',
    'process_order_number' => 'required|string',
]);

// Check if owners_kit is present and not null
$owners = $request->input('owners_kit', []);

if (empty($owners)) {
    return response()->json(['message' => 'No owners data provided.'], 400);
}



    $owners = $request->input('owners_kit');
    foreach ($owners as $ownerData) {
        $owner = new GlobalOwnerNdt();
        $owner->Type = $ownerData['type'];
        $owner->owner = $ownerData['owner'];
        $owner->ndta = $ownerData['ndt'];
        $owner->process_order_number = $request->input('process_order_number');
        $owner->Quality_Step = 'Kitting';
        //$owner->planning_form_data_id = $planningData->id;
        $owner->save();
    }

    // You can return a response or redirect as needed
    return response()->json(['data' => $kittingFormData]);
}




    //
    public function getKittingDataByProcessOrder(Request $request)
    {
        $processOrderNumber = $request->input('process_order_number');

        // Retrieve data based on the process order number to get the latest record
        $data = Kitting_tableData::where('ProcessOrderID', $processOrderNumber)
            ->orderBy('updated_at', 'desc')
            ->first();

        return response()->json(['data' => $data]);
    }




    //

    public function submitKittingCompleteForm(Request $request)
    {
        // Validate the request data if needed

        // Create a new instance of the KittingCompleteData model
        $kittingCompleteData = new KittingCompleteData;
        $kittingCompleteData->ProcessOrderID = $request->input('process_order_number');
        $kittingCompleteData->cut_form_mach_parts = $request->input('cut_form_mach_parts');
        $kittingCompleteData->bought_out_components = $request->input('bought_out_components') ;
        $kittingCompleteData->fasteners_fixings = $request->input('fasteners_fixings');
        $kittingCompleteData->site_pack = $request->input('site_pack');
        $kittingCompleteData->sign_off_kitting = $request->input('sign_off_kitting');
        $kittingCompleteData->comments_kitting = $request->input('comments_kitting');
        $kittingCompleteData->status = $request->input('status');
        $kittingCompleteData->quantity = $request->input('quantity');
        // Add other fields accordingly

        $kittingCompleteData->save();

        // You can return a response or redirect as needed
        return response()->json(['data' => $kittingCompleteData]);
    }

        public function viewKittingCompleteForm(Request $request)
        {
            $processOrderNumber = $request->input('process_order_number');
    
            // Retrieve data based on the process order number to get the latest record
            $data = KittingCompleteData::where('ProcessOrderID', $processOrderNumber)
                ->orderBy('updated_at', 'desc')
                ->first();
    
            return response()->json(['data' => $data]);
        }
        public function getOwnerData_kit(Request $request)
        {
            //$processOrderNumber = $request->input('process_order_number');
        
            $processOrderNumber = $request->input('process_order_number');
            $Type = $request->input('Type');
        
            // Query to fetch the latest record based on process_order_number, Quality_Step = 'Engineering', and Type
            $data = DB::select(
                'SELECT TOP 1 * FROM QUALITY_PACK.dbo.Planning_Owner_NDT WHERE process_order_number = ? AND Quality_Step = ? AND Type = ? ORDER BY updated_at DESC',
                [$processOrderNumber, 'Kitting',$Type]
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