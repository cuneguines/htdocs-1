<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PackingTransportFormData;
use App\Models\PackingTransportCompleteData;
use App\Models\ImageDataCompleteTransport;

class PackingTransportController extends Controller
{
    /**
     * Submit Packing and Transport Form Data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function submitPackingTransportForm(Request $request)
    {
        // Validate the request data if needed

        // Create a new instance of PackingTransportFormData
        $packingTransport = new PackingTransportFormData;
        $packingTransport->process_order_number = $request->input('process_order_number');
        $packingTransport->engineer = $request->input('engineer');
        //$packingTransport->technical_file = $request->has('technical_file') ? 'on' : '';
        $packingTransport->client_handover_documentation = $request->input('client_handover_documentation');
        $packingTransport->technical_file =  $request->input('technical_file');
        $packingTransport->secure_packing =  $request->input('secure_packing');
        // Save the Packing and Transport Form Data
        $packingTransport->save();

        // You can return a response or redirect as needed
        return response()->json(['data' => $packingTransport]);
    }

    /**
     * Get Packing and Transport Data By Process Order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getPackingTransportDataByProcessOrder(Request $request)
    {
        $processOrderID = $request->input('process_order_number');

        // Retrieve data based on the process order ID to get the latest record
        $data = PackingTransportFormData::where('process_order_number', $processOrderID)
            ->orderBy('updated_at', 'desc')
            ->first();

        return response()->json(['data' => $data]);
    }

    /**
     * View Packing and Transport Form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function viewPackingTransportForm(Request $request)
    {
        $processOrderID = $request->input('process_order_number');

        // Retrieve data based on the process order ID to get the latest record
        $data = PackingTransportFormData::where('process_order_number', $processOrderID)
            ->orderBy('updated_at', 'desc')
            ->first();

        return response()->json(['data' => $data]);
    }

    /**
     * Submit Packing and Transport Complete Form Data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function submitPackingTransportCompleteForm(Request $request)
    {
        // Validate the request data if needed

        // Create a new instance of PackingTransportCompleteData
        $packingTransportCompleteData = new PackingTransportCompleteData;
        $packingTransportCompleteData->process_order_number = $request->input('process_order_number');
        $packingTransportCompleteData->secure_packing = $request->input('secure_packing');
        $packingTransportCompleteData->photos_attached = $request->input('photos_attached');
        //$packingTransportCompleteData->technical_file = $request->has('technical_file') ? 'on' : '';
        //$packingTransportCompleteData->client_handover_documentation = $request->has('client_handover_documentation') ? 'on' : '';
        $packingTransportCompleteData->sign_off_documentation = $request->input('responsible_person_complete');
        $packingTransportCompleteData->comments_documentation = $request->input('comments_documentation');
        $packingTransportCompleteData->status = $request->input('status');
        $packingTransportCompleteData->quantity = $request->input('quantity');
        //$packingTransportCompleteData->labels_attached = $request->has('labels_attached') ? 'on' : '';
        // Add other fields accordingly
        $packingTransportCompleteData->uuid = $request->input('uuid_qlty');
        $packingTransportCompleteData->save();

        // You can return a response or redirect as needed
        return response()->json(['data' => $packingTransportCompleteData]);
    }

    public function viewPackingTransportCompleteForm(Request $request)
{
   $processOrderNumber = $request->input('process_order_number');

   // Retrieve data based on the process order number to get the latest record
   $data = PackingTransportCompleteData::where('process_order_number', $processOrderNumber)
       ->orderBy('updated_at', 'desc')
       ->first();

   return response()->json(['data' => $data]);
}

public function uploadImages_CompleteTransport(Request $request)
    {
        // Validate the request
        $request->validate([
            'process_order_number' => 'required|numeric', // Adjust validation rules as needed
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // Max 2MB and allowed file types
        ]);
    
        $processOrder = $request->input('process_order_number');
        $uuid = $request->input('uuid_qlty');
       // Get the maximum batch number for the process order
      $maxBatchNumber = ImageDataCompleteTransport::where('process_order_id', $processOrder)
      ->max('batch_number');
    
        // Determine the new batch number
     $batchNumber = $maxBatchNumber === null ? 1 : $maxBatchNumber + 1;
        // Check if the process order folder exists, if not, create it
        $folderPath = 'public/images_transport_complete/' . $processOrder . '/' . $uuid . '/';
        if (!\Storage::exists($folderPath)) {
            \Storage::makeDirectory($folderPath);
        }
    
        if ($request->hasFile('images')) {
            $uploadedImages = [];
    
            foreach ($request->file('images') as $image) {
                // Generate a unique name for the image
                $imageName = time().'_'.$image->getClientOriginalName();
                
                // Store the image to the local storage
                $image->storeAs($folderPath, $imageName);
    
                // Save image name to the database
                $newImage = new ImageDataCompleteTransport();
                $newImage->uuid = $uuid;
                $newImage->process_order_id = $processOrder;
                $newImage->filename = $imageName;
                $newImage->batch_number = $batchNumber; 
                $newImage->save(); 
    
                // Keep track of uploaded image names
                $uploadedImages[] = $imageName;
            }
    
            return response()->json(['message' => 'Images uploaded successfully', 'images' => $uploadedImages]);
        }
    
        return response()->json(['message' => 'No images uploaded'], 400);
    }


    public function getImages_CompleteTransport(Request $request)
{
    $processOrderId = (int) $request->input('id'); // Cast to integer

    // Retrieve the most recent quality data for the process order
    $qualityData = PackingTransportCompleteData::where('process_order_number', $processOrderId)
        ->orderBy('updated_at', 'desc')
        ->first();

    if ($qualityData) {
        $uuid = $qualityData->uuid;

        // Retrieve filenames with the highest batch number for the given process order and UUID
        $filenames = ImageDataCompleteTransport::where('process_order_id', $processOrderId)
            ->where('uuid', $uuid)
            ->where('batch_number', function ($query) use ($processOrderId) {
                $query->selectRaw('max(batch_number)')
                ->from('QUALITY_PACK.dbo.imageData_CompleteTransport')
                ->whereColumn('process_order_id', 'QUALITY_PACK.dbo.imageData_CompleteTransport.process_order_id')
                ->where('process_order_id', $processOrderId);
            })
            ->pluck('filename')
            ->toArray();

        return response()->json(['filenames' => $filenames]);
    }

}
}