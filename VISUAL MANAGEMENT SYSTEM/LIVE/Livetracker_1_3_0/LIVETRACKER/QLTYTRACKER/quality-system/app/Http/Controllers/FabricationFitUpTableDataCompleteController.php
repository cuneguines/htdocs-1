<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FabrcationCompleteData; 

class FabricationFitUpTableDataCompleteController extends Controller
{
    public function submitFabricationCompleteFitUpForm(Request $request)
    {
        // Validate the request data if needed

       // Assuming you have an Eloquent model named FabricationFitUp
$fabricationFitUp = new FabrcationCompleteData;
$fabricationFitUp->FitUpVisualCheck = $request->input('fit_up_visual_check');
$fabricationFitUp->DimensionalCheck = $request->input('dimensional_check') ;
$fabricationFitUp->LinkToDrawing = $request->input('link_to_drawing');
$fabricationFitUp->WeldmentQuantity = $request->input('weldment_quantity') ;
$fabricationFitUp->SignOffUser = $request->input('signOffUser');
$fabricationFitUp->Comments = $request->input('comments_fabrication_fit_up');
$fabricationFitUp->ProcessOrder = $request->input('process_order_number');
$fabricationFitUp->Quantity = $request->input('Quantity');
$fabricationFitUp->Status = $request->input('status');
$fabricationFitUp->fitupvisualcheck_person = $request->input('fitupvisualcheck_person');
$fabricationFitUp->dimensionalcheck_person = $request->input('dimensionalcheck_person');
$fabricationFitUp->weldcheck_person = $request->input('weldcheck_person');
// Add other fabrication fit-up fields accordingly

$fabricationFitUp->save();

// You can return a response or redirect as needed
return response()->json(['data' => $fabricationFitUp]);
    }


    public function viewFabricationFitUpCompleteForm(Request $request)
    {
        $processOrderNumber = $request->input('process_order_number');

        // Retrieve data based on the process order number to get the latest record
        $data = FabrcationCompleteData::where('ProcessOrder', $processOrderNumber)
            ->orderBy('updated_at', 'desc')
            ->first();

        return response()->json(['data' => $data]);
    }
}
