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
//$processOrderNumber=50000;
        // Fetch data from the database using the process order number
        $data1 = DB::table('QUALITY_PACK.dbo.MaterialPreparationFormData')
            ->where('process_order_number', $processOrderNumber)
            ->orderBy('updated_at', 'desc')
            ->limit(1)
            ->get();

        $data_1 = DB::table('QUALITY_PACK.dbo.MaterialPreparationFormCompleteData')
            ->where('process_order_number', $processOrderNumber)
            ->orderBy('updated_at', 'desc')
            ->limit(1)
            ->select('*','sign_off_material_complete_preparation as sign_off_material_preparation')
            ->get();
        $data2 = DB::table('QUALITY_PACK.dbo.Welding_Form_Data')
            ->where('ProcessOrderID', $processOrderNumber)
            ->orderBy('updated_at', 'desc')
            ->limit(1)
            ->get();

        $data_2 = DB::table('QUALITY_PACK.dbo.WeldingCompleteData')
            ->where('ProcessOrderID', $processOrderNumber)
            ->orderBy('updated_at', 'desc')
            ->limit(1)
            ->get();
        $data3 = DB::table('QUALITY_PACK.dbo.DocumentationFormData')
            ->where('process_order_number', $processOrderNumber)
            ->orderBy('updated_at', 'desc')
            ->limit(1)
            ->get();

        $data_3 = DB::table('QUALITY_PACK.dbo.DocumentationCompleteData')
            ->where('process_order_number', $processOrderNumber)
            ->orderBy('updated_at', 'desc')
            ->limit(1)
            ->get();
        $data4 = DB::table('QUALITY_PACK.dbo.TestingFormDatas')
            ->where('process_order_number', $processOrderNumber)
            ->orderBy('updated_at', 'desc')
            ->limit(1)
            ->get();

        $data_4= DB::table('QUALITY_PACK.dbo.TestingCompleteData')
            ->where('process_order_number', $processOrderNumber)
            ->orderBy('updated_at', 'desc')
            ->limit(1)
            ->get();
        $data5 = DB::table('QUALITY_PACK.dbo.KittingFormData')
            ->where('ProcessOrderID', $processOrderNumber)
            ->orderBy('updated_at', 'desc')
            ->limit(1)
            ->get();

        $data_5 = DB::table('QUALITY_PACK.dbo.KittingFormCompleteData')
            ->where('ProcessOrderID', $processOrderNumber)
            ->orderBy('updated_at', 'desc')
            ->limit(1)
            ->get();
        $data6 = DB::table('QUALITY_PACK.dbo.PackingTransportFormData')
            ->where('process_order_number', $processOrderNumber)
            ->orderBy('updated_at', 'desc')
            ->limit(1)
            ->get();

        $data_6 = DB::table('QUALITY_PACK.dbo.PackingTransportCompleteData')
            ->where('process_order_number', $processOrderNumber)
            ->orderBy('updated_at', 'desc')
            ->limit(1)
            ->get();

        // Pass data to the view
        $pdf = PDF::loadView('reportpdf', compact('data1', 'data_1','data2','data_2','data3','data_3','data6','data_6'));

        // Return the PDF for download
   // return $pdf->download('material_preparation_data.pdf');
      // return view('reportpdf');
      return view('reportpdf', compact('data1', 'data_1', 'data2', 'data_2', 'data3', 'data_3', 'data4', 'data_4', 'data5', 'data_5','data6','data_6'));
    }
}
