<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FabricationFromData; // Make sure to import your FabricationFitUp model

class FabricationFitUpController extends Controller
{
    public function submitFabricationFitUpForm(Request $request)
    {
        // Validate the request data if needed

       // Assuming you have an Eloquent model named FabricationFitUp
$fabricationFitUp = new FabricationFromData;
$fabricationFitUp->FitUpVisualCheck = $request->input('fit_up_visual_check');
$fabricationFitUp->DimensionalCheck = $request->input('dimensional_check') ;
$fabricationFitUp->LinkToDrawing = $request->input('link_to_drawing');
$fabricationFitUp->WeldmentQuantity = $request->input('weldment_quantity') ;
$fabricationFitUp->SignOffUser = $request->input('sign_off_fabrication_fit_up');
$fabricationFitUp->Comments = $request->input('comments_fabrication_fit_up');
$fabricationFitUp->ProcessOrder = $request->input('process_order_number');
// Add other fabrication fit-up fields accordingly

$fabricationFitUp->save();

// You can return a response or redirect as needed
return response()->json(['data' => $fabricationFitUp]);
    }
}
