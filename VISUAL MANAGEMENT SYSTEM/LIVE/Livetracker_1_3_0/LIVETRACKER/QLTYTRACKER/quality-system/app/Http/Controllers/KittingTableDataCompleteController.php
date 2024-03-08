<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KittingCompleteData; 

class KittingTableDataCompleteController extends Controller
{
    //

    public function submitKittingCompleteForm(Request $request)
    {
        // Validate the request data if needed

        // Create a new instance of the KittingCompleteData model
        $kittingCompleteData = new KittingCompleteData;
        $kittingCompleteData->ProcessOrderID = $request->input('process_order_number');
        $kittingCompleteData->cut_form_mach_parts = $request->input('cut_form_mach_parts') === 'on' ? 'Completed' : 'Not Completed';
        $kittingCompleteData->bought_out_components = $request->input('bought_out_components') === 'on' ? 'Completed' : 'Not Completed';
        $kittingCompleteData->fasteners_fixings = $request->input('fasteners_fixings') === 'on' ? 'Completed' : 'Not Completed';
        $kittingCompleteData->site_pack = $request->input('site_pack') === 'on' ? 'Completed' : 'Not Completed';
        $kittingCompleteData->sign_off_kitting = $request->input('sign_off_kitting');
        $kittingCompleteData->comments_kitting = $request->input('comments_kitting');
        $kittingCompleteData->status = $request->input('status');
        $kittingCompleteData->quantity = $request->input('quantity');
        // Add other fields accordingly

        $kittingCompleteData->save();

        // You can return a response or redirect as needed
        return response()->json(['data' => $kittingCompleteData]);
    
}
}
