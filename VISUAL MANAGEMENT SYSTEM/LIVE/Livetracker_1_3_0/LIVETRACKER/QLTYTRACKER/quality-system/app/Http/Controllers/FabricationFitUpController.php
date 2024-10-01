<?php



namespace App\Http\Controllers;
use App\Models\GlobalOwnerNdt; 
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

$owners_fab = $request->input('owners_fab');
$processOrderNumber = $request->input('process_order_number');

foreach ($owners_fab as $ownerData) {
    $owner = GlobalOwnerNdt::where('process_order_number', $processOrderNumber)
                            ->where('Type', $ownerData['type'])
                            ->first();

    if ($owner) {
        // Update only if new data is provided
        if ($owner->owner !== $ownerData['owner']) {
            $owner->owner = $ownerData['owner'];
        }
        if ($owner->ndta !== $ownerData['ndt']) {
            $owner->ndta = $ownerData['ndt'];
        }
    } else {
        // Create new record if it doesn't exist
        $owner = new GlobalOwnerNdt();
        $owner->Type = $ownerData['type'];
        $owner->owner = $ownerData['owner'];
        $owner->ndta = $ownerData['ndt'];
        $owner->process_order_number = $processOrderNumber;
    }

    $owner->Quality_Step = 'Fabrication';
    $owner->save();
}




// You can return a response or redirect as needed
return response()->json(['data' => $fabricationFitUp]);
    }
}
