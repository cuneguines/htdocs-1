<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WeldingFormData;
class WeldingController extends Controller
{
   /**
     * Submit Welding Form Data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function submitWeldingForm(Request $request)
    {
        // Validate the request data if needed

        // Create a new instance of WeldingFormData
        $weldingFormData = new WeldingFormData;
        $weldingFormData->weld_map_issued = $request->input('weld_map_issued');
        $weldingFormData->link_to_weld_map = $request->input('link_to_weld_map');
        $weldingFormData->weld_procedure_qualification = $request->input('weld_procedure_qualification');
        $weldingFormData->link_to_pqr = $request->input('link_to_pqr');
        $weldingFormData->weld_procedure_specifications = $request->input('weld_procedure_specifications');
        $weldingFormData->link_to_wps = $request->input('link_to_wps');
        $weldingFormData->welder_performance_qualification = $request->input('welder_performance_qualification');
        $weldingFormData->link_to_wpq = $request->input('link_to_wpq');
        $weldingFormData->welding_wire = $request->input('welding_wire');
        $weldingFormData->link_to_wire_certificate = $request->input('link_to_wire_certificate');
        $weldingFormData->shielding_gas = $request->input('shielding_gas');
        $weldingFormData->link_to_gas_data_sheet = $request->input('link_to_gas_data_sheet');
        $weldingFormData->link_to_plant_cert = $request->input('link_to_plant_cert');
        $weldingFormData->pre_weld_inspection = $request->input('pre_weld_inspection');
        $weldingFormData->inspection_during_welding = $request->input('inspection_during_welding');
        $weldingFormData->post_weld_inspection = $request->input('post_weld_inspection');
        $weldingFormData->sign_off_welding_complete = $request->input('sign_off_welding_complete');
        $weldingFormData->comments_welding_complete = $request->input('comments_welding_complete');
        $weldingFormData->status = $request->input('status');
        $weldingFormData->submission_date = $request->input('submission_date');

        // Save the Welding Form Data
        $weldingFormData->save();

        // You can return a response or redirect as needed
        return response()->json(['data' => $weldingFormData]);
    }
}