<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KittingFormData; 
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

}
