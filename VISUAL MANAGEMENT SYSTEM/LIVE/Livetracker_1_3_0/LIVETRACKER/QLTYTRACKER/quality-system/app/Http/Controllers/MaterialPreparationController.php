<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MaterialPreparationFormData; 
use App\Models\GlobalOwnerNdt; 

class MaterialPreparationController extends Controller
{
    public function submitMaterialPreparationForm(Request $request)
    {
        // Validate the request data if needed

        // Assuming you have an Eloquent model named MaterialPreparation
        $materialPreparation = new MaterialPreparationFormData;
        $materialPreparation->process_order_number = $request->input('process_order_number');
        $materialPreparation->material_identification = $request->input('material_identification');
        $materialPreparation->material_identification_record = $request->input('material_identification_record');
        $materialPreparation->material_traceability = $request->input('material_traceability');
        $materialPreparation->cutting = $request->input('cutting');
        $materialPreparation->deburring = $request->input('deburring');
        $materialPreparation->forming = $request->input('forming');
        $materialPreparation->machining = $request->input('machining');
        $materialPreparation->sign_off_material_preparation = $request->input('sign_off_material_preparation');
        $materialPreparation->comments_material_preparation = $request->input('comments_material_preparation');
        $materialPreparation->material_identification_record_file=$request->input('material_identification_record_file');
        $materialPreparation->material_traceability_file=$request->input('material_traceability_file');
        $materialPreparation->tube_laser_pack_file=$request->input('tube_laser_pack_file');
        $materialPreparation->laser_and_press_brake_file=$request->input('laser_and_press_brake_file');
     
        // Add other fields accordingly



        $materialPreparation->save();
        $owners_mat = $request->input('owners_mat');
        foreach ($owners_mat as $ownerData) {
            $owner = new GlobalOwnerNdt();
            $owner->Type = $ownerData['type'];
            $owner->owner = $ownerData['owner'];
            $owner->ndta = $ownerData['ndt'];
            $owner->process_order_number = $request->input('process_order_number');
            $owner->Quality_Step = 'MaterialPrep';
            //$owner->planning_form_data_id = $planningData->id;
            $owner->save();
        }


       

        // You can return a response or redirect as needed
        return response()->json(['data' => $materialPreparation]);
    }

    
}

