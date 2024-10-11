<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
    use App\Models\FinalAssemblyFormData;
    use App\Models\FinalAssemblyCompleteData;
    use App\Models\GlobalOwnerNdt; 
    class FinalAssemblyController extends Controller
    {
        /**
         * Submit Final Assembly Form Data.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function submitFinalAssemblyForm(Request $request)
        {
            // Validate the request data if needed
    
            // Create a new instance of FinalAssemblyFormData
            $finalAssemblyFormData = new FinalAssemblyFormData;
            $finalAssemblyFormData->process_order_number = $request->input('process_order_number');
            $finalAssemblyFormData->walk_down_inspection = $request->input('walk_down_inspection');
            $finalAssemblyFormData->identification = $request->input('identification');
            $finalAssemblyFormData->sign_off_final_assembly = $request->input('sign_off_final_assembly');
            $finalAssemblyFormData->comments_final_assembly = $request->input('comments_final_assembly');
            //$finalAssemblyFormData->submission_date = $request->input('submission_date');
    
            // Upload files and store filenames
            
            $finalAssemblyFormData->final_assembly_file_1 =  $request->input('final_assembly_file_1');
            $finalAssemblyFormData->final_assembly_file_2 =  $request->input('final_assembly_file_2');
            $finalAssemblyFormData->final_assembly_file_3 = $request->input ('final_assembly_file_3');
    
            // Save the Final Assembly Form Data
            $finalAssemblyFormData->save();

            $owners = $request->input('owners_final');
            foreach ($owners as $ownerData) {
                $owner = new GlobalOwnerNdt();
                $owner->Type = $ownerData['type'];
                $owner->owner = $ownerData['owner'];
                $owner->ndta = $ownerData['ndt'];
                $owner->process_order_number = $request->input('process_order_number');
                $owner->Quality_Step = 'Final';
                //$owner->planning_form_data_id = $planningData->id;
                $owner->save();
            }

    
            // You can return a response or redirect as needed
            return response()->json(['data' => $finalAssemblyFormData]);
        }
    
        
    
        /**
         * Get Final Assembly Data By Process Order.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function getFinalAssemblyDataByProcessOrder(Request $request)
        {
            $processOrderID = $request->input('process_order_number');
    
            // Retrieve data based on the process order ID to get the latest record
            $data = FinalAssemblyFormData::where('process_order_number', $processOrderID)
                ->orderBy('updated_at', 'desc')
                ->first();
    
            return response()->json(['data' => $data]);
        }
    
        /**
         * View Final Assembly Form.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function viewFinalAssemblyCompleteForm(Request $request)
        {
            $processOrderID = $request->input('process_order_number');
    
            // Retrieve data based on the process order ID to get the latest record
            $data = FinalAssemblyCompleteData::where('process_order_number', $processOrderID)
                ->orderBy('updated_at', 'desc')
                ->first();
    
            return response()->json(['data' => $data]);
        }
    
    public function submitFinalAssemblyCompleteForm(Request $request)
    {
        // Validate the request data if needed
    
        // Create a new instance of the FinalAssemblyCompleteData model
        $finalAssemblyCompleteData = new FinalAssemblyCompleteData;
        $finalAssemblyCompleteData->process_order_number = $request->input('process_order_number');
        $finalAssemblyCompleteData->walk_down_inspection = $request->input('walk_down_inspection');
        $finalAssemblyCompleteData->identification = $request->input('identification');
        $finalAssemblyCompleteData->final_assembly_file_1 = $request->input('final_assembly_file_1');
        $finalAssemblyCompleteData->final_assembly_file_2 = $request->input('final_assembly_file_2');
        $finalAssemblyCompleteData->final_assembly_file_3 = $request->input('final_assembly_file_3');
        $finalAssemblyCompleteData->sign_off_final_assembly = $request->input('sign_off_final_assembly');
        $finalAssemblyCompleteData->comments_final_assembly = $request->input('comments_final_assembly');
        $finalAssemblyCompleteData->status = $request->input('status');
        $finalAssemblyCompleteData->quantity = $request->input('quantity');
        // Add other fields accordingly
    
        $finalAssemblyCompleteData->save();
    
        // You can return a response or redirect as needed
        return response()->json(['data' => $finalAssemblyCompleteData]);
    }


    public function getOwnerData_final(Request $request)
{
    //$processOrderNumber = $request->input('process_order_number');

    $processOrderNumber = $request->input('process_order_number');
    $Type = $request->input('Type');

    // Query to fetch the latest record based on process_order_number, Quality_Step = 'Engineering', and Type
    $data = DB::select(
        'SELECT TOP 1 * FROM QUALITY_PACK.dbo.Planning_Owner_NDT WHERE process_order_number = ? AND Quality_Step = ? AND Type = ? ORDER BY updated_at DESC',
        [$processOrderNumber, 'Final',$Type]
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