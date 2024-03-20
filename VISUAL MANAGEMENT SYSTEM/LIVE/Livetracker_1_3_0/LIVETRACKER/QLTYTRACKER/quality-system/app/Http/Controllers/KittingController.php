<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KittingFormData; 
use App\Models\Kitting_tableData; 
use App\Models\KittingCompleteData; 
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
    

}