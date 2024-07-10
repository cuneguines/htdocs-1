<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use setasign\Fpdi\Fpdi;

class CertController extends Controller
{
    public function generateCertificate(Request $request)
    {
        // Validate the request
        $request->validate([
            'processOrderNumber' => 'required|string|max:255',
        ]);

        // Get the input data
        $processOrderNumber = $request->input('processOrderNumber');

        // SQL query to get the required data
        $sql = "
            select
              distinct t0.DocNum [SalesOrder],
              t0.CardName [Customer],
              t7.PrOrder [ProcessOrder],
             CAST(t7.Batchsize AS DECIMAL(18, 2)) AS [Quantity],
              t7.EndProduct [EndProduct],
              t2.SlpName [Engineer],
              t_3.ItemName
            from
            Kentstainless.dbo.iis_epc_pro_orderh t7
            inner join KENTSTAINLESS.dbo.oitm t_3 on t_3.itemcode = t7.EndProduct
            left join Kentstainless.dbo.ordr t0 on t0.DocNum = t7.SONum
            LEFT JOIN Kentstainless.dbo.rdr1 t3 ON t3.DocEntry = t0.DocEntry
            INNER JOIN Kentstainless.dbo.ohem t1 ON t1.empID = t0.OwnerCode
            INNER JOIN Kentstainless.dbo.oslp t2 ON t2.SlpCode = t0.SlpCode
            INNER JOIN Kentstainless.dbo.ocrd t4 ON t4.CardCode = t0.CardCode
            where t7.PrOrder = ?
        ";

        // Execute the query
        $result = DB::select($sql, [$processOrderNumber]);

        // Check if there are any results
        if (!empty($result)) {
            // Get the first item
            $data_sales = (array)$result[0];
        } else {
            return response()->json(['message' => 'No data found for the given process order number.'], 404);
        }

        // Path to the prebuilt PDF template
        $templatePath = storage_path('app/public/LK_Certificate of Compliance_Rev1.pdf');

        // Create new FPDI object
        $pdf = new Fpdi();

        // Add a page
        $pdf->AddPage();

        // Set the source file
        $pdf->setSourceFile($templatePath);

        // Import the first page of the template
        $tplIdx = $pdf->importPage(1);

        // Use the imported page as the template
        $pdf->useTemplate($tplIdx);

        // Set font
        $pdf->SetFont('Helvetica');

        // Add the data to the template
        $pdf->SetXY(45, 93); // Adjust position as needed
        $pdf->Write(0,$data_sales['Customer']);

        $pdf->SetXY(64, 103); // Adjust position as needed
      
        $pdf->Write(0, $data_sales['SalesOrder']);
        $itemName = $data_sales['ItemName'];
$maxLength = 80; // Set a maximum length to determine if font size needs adjustment
$maxWidth = 130; // Set the maximum width for the MultiCell
$defaultFontSize = 12; // Default font size
$smallFontSize = 10; // Smaller font size for long text

// Determine the font size based on the length of the item name
if (strlen($itemName) > $maxLength) {
    $pdf->SetFont('Arial', '', 10); // Adjust to smaller font size
    $pdf->SetXY(64, 108);
} else {
    $pdf->SetXY(50, 111);
    $pdf->SetFont('Arial', '', 12); // Default font size
}
//$pdf->SetXY(64, 110); // Adjust position as needed
$pdf->MultiCell($maxWidth, 4, $itemName);
        //$pdf->SetXY(64,112); // Adjust position as needed
        //$pdf->Write(0, $data_sales['ItemName']);

        $pdf->SetFont('Helvetica','', 12);

        $pdf->SetXY(44, 123); // Adjust position as needed
        $pdf->Write(0,$data_sales['Quantity']);

       

      //  $pdf->SetXY(50, 160); // Adjust position as needed
      

        // Output the PDF as a download
        return response()->streamDownload(function () use ($pdf) {
            $pdf->Output();
        }, 'certificate.pdf');
    }
}
