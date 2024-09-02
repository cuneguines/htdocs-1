<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaterialPreparationFormData;
use App\Models\MaterialPreparationCompleteData;
use App\Models\ManufacturingFormData;
use App\Models\PlanningFormData;
use App\Models\EngineeringFormData;
use App\Models\Kitting_tableData;
use App\Models\FabricationFromData;
use App\Models\WeldingFormData;
use App\Models\TestingFormData;
use App\Models\FinishingFormData;
use App\Models\SubcontractFormData;
use App\Models\FinalAssemblyFormData;
use App\Models\DocumentationFormData;
use App\Models\PackingTransportFormData;
use App\Models\QualityFormData;
use DB;

class BatchDataController extends Controller
{
    public function getBatchDataByProcessOrders(Request $request)
    {
        $processOrderNumber = $request->input('process_order_number');

        try {
            // Fetch data for all the tables
            $materialData = MaterialPreparationFormData::where('process_order_number', $processOrderNumber)->first();
            $manufacturingData = ManufacturingFormData::where('process_order_number', $processOrderNumber)->first();
            $planningData = PlanningFormData::where('process_order_number', $processOrderNumber)->first();
            $engineeringData = EngineeringFormData::where('process_order_number', $processOrderNumber)->first();
            $kittingData = Kitting_tableData::where('ProcessOrderID', $processOrderNumber)->first();
            $fabricationFitData = FabricationFromData::where('ProcessOrder', $processOrderNumber)->first();
            $weldingData = WeldingFormData::where('ProcessOrderID', $processOrderNumber)->first();
            $testingData = TestingFormData::where('process_order_number', $processOrderNumber)->first();
            $finishingData = FinishingFormData::where('process_order_number', $processOrderNumber)->first();
            $subContractData = SubcontractFormData::where('process_order_number', $processOrderNumber)->first();
            $finalData = FinalAssemblyFormData::where('process_order_number', $processOrderNumber)->first();
            $documentationData = DocumentationFormData::where('process_order_number', $processOrderNumber)->first();
            $packingAndTransportData = PackingTransportFormData::where('process_order_number', $processOrderNumber)->first();
            $qualityData = QualityFormData::where('process_order_number', $processOrderNumber)->first();

            // Combine the results
            $result = [
                'orderNumber' => $processOrderNumber,
                'materialData' => $materialData,
                'planningData' => $planningData,
                'manufacturingData' => $manufacturingData,
                'engineeringData' => $engineeringData,
                'kittingData' => $kittingData,
                'fabricationFitData' => $fabricationFitData,
                'weldingData' => $weldingData,
                'testingData' => $testingData,
                'finishingData' => $finishingData,
                'subContractData' => $subContractData,
                'finalData' => $finalData,
                'documentationData' => $documentationData,
                'packingAndTransportData' => $packingAndTransportData,
                'qualityData' => $qualityData,
            ];

            return response()->json(['data' => $result]);

        } catch (\Exception $e) {
            \Log::error('Error fetching batch data: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function getBatchCompleteDataByProcessOrders(Request $request)
{
    $processOrderNumber = $request->input('process_order_number');

    try {
        // Check if the cutting step is "on" in MaterialPreparationFormData
        $cuttingOnInPreparation = MaterialPreparationFormData::where('process_order_number', $processOrderNumber)
        ->whereNotNull('cutting')
            ->where('cutting', 'on')
            ->exists();
    
        // Check if the cutting step is "on" in MaterialPreparationCompleteData
        $cuttingOnInCompletion = MaterialPreparationCompleteData::where('process_order_number', $processOrderNumber)
        ->whereNotNull('cutting')
            ->where('cutting', 'on')
            ->exists();
    
        // Repeat similar checks for deburring, forming, and machining steps
        $deburringOnInPreparation = MaterialPreparationFormData::where('process_order_number', $processOrderNumber)
         ->whereNotNull('cutting')
            ->where('deburring', 'on')
            ->exists();
        
        $deburringOnInCompletion = MaterialPreparationCompleteData::where('process_order_number', $processOrderNumber)
            ->where('deburring', 'on')
            ->exists();
    
            $formingOnInPreparationQuery = DB::selectOne("
            SELECT 
                CASE 
                    WHEN EXISTS (
                        SELECT forming
                        FROM MaterialPreparationFormData
                        WHERE process_order_number = ?
                        AND forming IS NOT NULL
                        AND forming = 'on'
                    ) THEN 1
                    ELSE 0
                END AS forming_on_in_preparation
        ", [$processOrderNumber]);
        
        $formingOnInCompletion = MaterialPreparationCompleteData::where('process_order_number', $processOrderNumber)
        ->whereNotNull('forming','NULL')
            ->where('forming', 'on')
            ->exists();
    
        $machiningOnInPreparation = MaterialPreparationFormData::where('process_order_number', $processOrderNumber)
            ->where('machining', 'on')
            ->exists();
        
        $machiningOnInCompletion = MaterialPreparationCompleteData::where('process_order_number', $processOrderNumber)
            ->where('machining', 'on')
            ->exists();
    
        // Determine the status of each step
        $statuses = [
            'cutting' => $this->determineStepStatus($cuttingOnInPreparation, $cuttingOnInCompletion),
            'deburring' => $this->determineStepStatus($deburringOnInPreparation, $deburringOnInCompletion),
            'forming' => $this->determineStepStatus($formingOnInPreparation, $formingOnInCompletion),
            'machining' => $this->determineStepStatus($machiningOnInPreparation, $machiningOnInCompletion),
        ];

        // Determine overall status
        $overallStatus = $this->determineOverallStatus($statuses);

        // Return JSON response
        return response()->json([
            'data' => [
                'overall_status' => $overallStatus,
                'cutting' => $statuses['cutting'],
                'deburring' => $statuses['deburring'],
                'forming' =>$statuses['forming'],
                'machining' => $statuses['machining'],
            ]
        ]);

    } catch (\Exception $e) {
        \Log::error('Error fetching batch complete data: ' . $e->getMessage());
        return response()->json(['error' => 'Internal Server Error'], 500);
    }
}

private function determineStepStatus($preparationStepOn, $completionStepOn)
{
    // Convert boolean results to integer for clarity
    $preparationStep = (int) $preparationStepOn;
    $completionStep = (int) $completionStepOn;

    if ($completionStep) {
        return 'complete';
    } elseif ($preparationStep) {
        return 'partial';
    } else {
        return 'incomplete';
    }
}



private function determineOverallStatus($statuses)
{
    // Calculate the number of completed and partial steps
    $completedSteps = count(array_filter($statuses, function($status) {
        return $status === 'complete';
    }));
    
    $partialSteps = count(array_filter($statuses, function($status) {
        return $status === 'partial';
    }));

    // Define criteria for half_complete status
    $halfCompleteSteps = 2; // Adjust this if needed based on your criteria

    if ($completedSteps === 4) {
        return 'complete';
    } elseif ($completedSteps + $partialSteps >= $halfCompleteSteps) {
        return 'half_complete';
    } else {
        return 'incomplete';
    }
}


}
