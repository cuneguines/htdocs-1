<?php
// app/Http/Controllers/EngineeringController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EngineeringFormData; // Make sure to import your Eloquent model

class EngineeringController extends Controller
{
    public function submitEngineeringForm(Request $request)
    {
        // Validate the request data if needed

        
        
        // Assuming you have an Eloquent model named EngineeringFormData
        $engineeringData = new EngineeringFormData;
        $engineeringData->reference_job_master_file = $request->input('reference_job_master_file');
        $engineeringData->reference_job_master_file_document = $request->input('reference_job_master_file_document');
        $engineeringData->concept_design_engineering= $request->input('concept_design_engineering');
        $engineeringData->design_validation_sign_off = $request->input('design_validation_sign_off');
        $engineeringData->customer_submittal_package = $request->input('customer_submittal_package');
        $engineeringData->reference_approved_samples = $request->input('reference_approved_samples');
        $engineeringData->concept_design_document = $request->input('concept_design_document');
        $engineeringData->customer_approval_document = $request->input('customer_approval_document');
        $engineeringData->design_validation_document = $request->input('design_validation_document');
        $engineeringData->sample_approval_document = $request->input('sample_approval_document');
        $engineeringData->sign_off_engineering = $request->input('sign_off_engineering');
        $engineeringData->comments_engineering = $request->input('comments_engineering');
        $engineeringData->submission_date = $request->input('submission_date');
        $engineeringData->process_order_number = $request->input('process_order_number');

        // Add other fields accordingly

        $engineeringData->save();

        // You can return a response or redirect as needed
        return response()->json(['data' => $engineeringData]);

    }

    
}
