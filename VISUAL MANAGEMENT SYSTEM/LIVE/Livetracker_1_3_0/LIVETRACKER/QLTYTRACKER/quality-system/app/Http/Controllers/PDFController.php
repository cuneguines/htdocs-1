<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;

class PDFController extends Controller



{


    public function fetchData(Request $request)
    {
        // Validate the request input
        $request->validate([
            'processOrderNumber' => 'required|string'
        ]);

        // Get the process order number from the request
        $processOrderNumber = $request->input('processOrderNumber');

        // Fetch data from the database using the process order number
        $data1 = DB::table('MaterialPreparationFormData')
            ->where('process_order_number', $processOrderNumber)
            ->limit(1000)
            ->get();

        $data2 = DB::table('MaterialPreparationFormCompleteData')
            ->where('process_order_number', $processOrderNumber)
            ->limit(1000)
            ->get();

        // Render the fetched data in a view and return it as HTML for the modal
        return view('data.modal-content', compact('data1', 'data2', 'processOrderNumber'))->render();
    }

    public function generatePDF(Request $request)
    {
        // Validate the request input
        $request->validate([
            'processOrderNumber' => 'required|string'
        ]);

        // Get the process order number from the request
        $processOrderNumber = $request->input('processOrderNumber');

        // Fetch data from the database using the process order number
        $data1 = DB::table('QUALITY_PACK.dbo.MaterialPreparationFormData')
            ->where('process_order_number', $processOrderNumber)
            ->orderBy('updated_at', 'desc')
            ->limit(1)
            ->get();

        $data2 = DB::table('QUALITY_PACK.dbo.MaterialPreparationFormCompleteData')
            ->where('process_order_number', $processOrderNumber)
            ->orderBy('updated_at', 'desc')
            ->limit(1)
            ->get();

        // Pass data to the view
        $pdf = PDF::loadView('reportpdf', compact('data1', 'data2'));

        // Return the PDF for download
        return $pdf->download('material_preparation_data.pdf');
    }
}
