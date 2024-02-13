<?php
// app/Http/Controllers/ManufacturingController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ManufacturingFormData; // Make sure to import your Manufacturing model

class ManufacturingController extends Controller
{
    public function submitManufacturingForm(Request $request)
    {
        // Validate the request data if needed

        // Assuming you have an Eloquent model named ManufacturingFormData
        $manufacturingData = new ManufacturingFormData;
        $manufacturingData->production_drawings = $request->input('production_drawings');
        $manufacturingData->production_drawings_document = $request->input('production_drawings_document');
        $manufacturingData->bom = $request->input('bom');
        $manufacturingData->bom_document = $request->input('bom_document');
        $manufacturingData->machine_programming_files = $request->input('machine_programming_files');
        $manufacturingData->machine_programming_files_document = $request->input('machine_programming_files_document');
        $manufacturingData->ndt_documentation = $request->input('ndt_documentation');
        $manufacturingData->ndt_documentation_document = $request->input('ndt_documentation_document');
        $manufacturingData->quality_documents = $request->input('quality_documents');
        $manufacturingData->quality_documents_document = $request->input('quality_documents_document');
        $manufacturingData->sign_off_manufacturing = $request->input('sign_off_manufacturing');
        $manufacturingData->comments_manufacturing = $request->input('comments_manufacturing');
        $manufacturingData->process_order_number = $request->input('process_order_number');

        // Add other fields accordingly

        $manufacturingData->save();

        // You can return a response or redirect as needed
        return response()->json(['data' => $manufacturingData]);
    }
}
