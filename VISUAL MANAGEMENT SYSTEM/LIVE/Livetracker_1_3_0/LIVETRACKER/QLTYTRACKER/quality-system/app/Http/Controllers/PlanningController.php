<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlanningFormData; 
class PlanningController extends Controller
{
    //
    public function submitPlanningForm(Request $request)
    {
        // Validate the request data if needed

        
        // Assuming you have an Eloquent model named EngineeringFormData
        $planningData = new PlanningFormData;
        $planningData->purchase_order_received = $request->input('purchase_order_received');
        $planningData->purchase_order_document = $request->input('purchase_order_document');
        $planningData->project_schedule_agreed= $request->input('project_schedule_agreed');
        $planningData->project_schedule_document = $request->input('project_schedule_document');
        $planningData->quotation = $request->input('quotation');
        $planningData->quotation_document = $request->input('quotation_document');
        $planningData->verify_customer_expectations = $request->input('verify_customer_expectations');
        $planningData->user_requirement_specifications_document = $request->input('user_requirement_specifications_document');
        $planningData->project_risk_category_assessment = $request->input('project_risk_category_assessment');
        $planningData->pre_engineering_check_document = $request->input('pre_engineering_check_document');
        $planningData->sign_off_planning = $request->input('sign_off_planning');
        $planningData->comments_planning = $request->input('comments_planning');
       
        $planningData->process_order_number = $request->input('process_order_number');

        // Add other fields accordingly

        $planningData->save();

        // You can return a response or redirect as needed
        return response()->json(['data' => $planningData]);

}
}