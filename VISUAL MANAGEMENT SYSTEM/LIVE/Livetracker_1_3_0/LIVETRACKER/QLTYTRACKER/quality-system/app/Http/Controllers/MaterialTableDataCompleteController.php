<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaterialPreparationCompleteData; 
class MaterialTableDataCompleteController extends Controller
{
    
    public function submitMaterialPreparationCompleteForm(Request $request)
    {
        // Validate the request data if needed

        // Assuming you have an Eloquent model named MaterialPreparation
        $materialPreparation = new MaterialPreparationCompleteData;
        $materialPreparation->process_order_number = $request->input('process_order_number');
        $materialPreparation->material_identification = $request->input('material_identification');
        $materialPreparation->material_identification_record = $request->input('material_identification_record');
        $materialPreparation->material_traceability = $request->input('material_traceability');
        $materialPreparation->cutting = $request->input('cutting');
        $materialPreparation->deburring = $request->input('deburring');
        $materialPreparation->forming = $request->input('forming');
        $materialPreparation->machining = $request->input('machining');
        $materialPreparation->cutting_person = $request->input('cutting_person');
        $materialPreparation->forming_person = $request->input('forming_person');
        $materialPreparation->machining_person = $request->input('machining_person');
        $materialPreparation->deburring_person = $request->input('deburring_person');

        $materialPreparation->sign_off_material_complete_preparation = $request->input('sign_off_material_preparation');
        $materialPreparation->sign_off_engineer = $request->input('sign_off_engineer');

        
        // Add other fields accordingly

        $materialPreparation->save();

        // You can return a response or redirect as needed
        return response()->json(['data' => $materialPreparation]);
    }
    public function viewMaterialCompletePreparationForm(Request $request)
    {
        $processOrderNumber = $request->input('po');

        // Retrieve data based on the process order number to get the latest record
        $data = MaterialPreparationCompleteData::where('process_order_number', $processOrderNumber)
            ->orderBy('updated_at', 'desc')
            ->first();
            

        return response()->json(['data' => $data]);
    }


}
