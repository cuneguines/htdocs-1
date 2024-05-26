<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QualityFormData; 
use App\Models\QualityCompleteData;
use App\Models\ImageDataQlty; 
use App\Models\ImageDataCompleteQlty; 
class QualityController extends Controller
{
    

    public function submitQualityForm(Request $request)
    {
        // Validate the request data if needed

        // Assuming you have an Eloquent model named QualityFormData
        $qualityData = new QualityFormData;
        $qualityData->walk_down_visual_inspection = $request->input('walk_down_visual_inspection') === 'Yes' ? true : false;
        $qualityData->comments_quality = $request->input('comments_quality');
        $qualityData->sign_off_quality = $request->input('sign_off_quality');
        $qualityData->process_order_number = $request->input('process_order_number');
        $qualityData->uuid = $request->input('uuid');
        

        $qualityData->save();

        // You can return a response or redirect as needed
        return response()->json(['data' => $qualityData]);
    }

    public function getQualityDataByProcessOrder(Request $request)
    {
        // Fetch Quality Form Data based on process order number
        $processOrder = $request->input('process_order_number');

        $qualityData = QualityFormData::where('process_order_number', $processOrder) 
        ->orderBy('updated_at', 'desc')
        ->first();

        return response()->json($qualityData);
    }

    public function submitQualityCompleteForm(Request $request)
    {
        // Validate the request data if needed

        // Assuming you have an Eloquent model named QualityFormData
        $qualityData = new QualityCompleteData;
        //$qualityData = QualityCompleteData::findOrFail($request->input('id'));
        $qualityData->walk_down_visual_inspection = $request->input('walk_down_visual_inspection');
        $qualityData->comments_quality = $request->input('comments_quality');
        $qualityData->sign_off_quality = $request->input('sign_off_quality');
        $qualityData->submission_date = $request->input('submission_date');
        $qualityData->process_order_number = $request->input('process_order_number');
       $qualityData->status = $request->input('status');
       // $qualityData->quantity = $request->input('quantity');
        //$qualityData->photos_attached = $request->input('photos_attached') === 'Yes' ? true : false;
        $qualityData->uuid = $request->input('uuid_qlty');
        $qualityData->save();

        // You can return a response or redirect as needed
        return response()->json(['data' =>  $qualityData]);
    }

    public function getQualityCompleteDataByProcessOrder(Request $request)
    {
        // Fetch Quality Form Data based on process order number
        $processOrder = $request->input('po');
        
        $qualityData = QualityCompleteData::where('process_order_number', $processOrder)
        ->orderBy('updated_at', 'desc')
        ->first();

        return response()->json(['data' => $qualityData]);
    }


    public function uploadImages_Quality(Request $request)
{
    // Validate the request
    $request->validate([
        'process_order_number' => 'required|numeric', // Adjust validation rules as needed
        'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // Max 2MB and allowed file types
    ]);

    $processOrder = $request->input('process_order_number');
    $uuid = $request->input('uuid');
   // Get the maximum batch number for the process order
  $maxBatchNumber = ImageDataQlty::where('process_order_id', $processOrder)
  ->max('batch_number');

    // Determine the new batch number
 $batchNumber = $maxBatchNumber === null ? 1 : $maxBatchNumber + 1;
    // Check if the process order folder exists, if not, create it
    $folderPath = 'public/images_qlty/' . $processOrder . '/' . $uuid . '/';
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
            $newImage = new ImageDataQlty();
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




public function getImages_Quality_real(Request $request)
    {
        $processOrderId = $request->input('id');
// Query to get the UUID from the QualityFormData table
$processOrderId = $request->input('id');

$qualityData = QualityFormData::where('process_order_number', $processOrderId)
->orderBy('updated_at', 'desc')
->first();
  

if ($qualityData) {
    $uuid = $qualityData->uuid;
        // Query the database to get the filenames with the highest batch number
        $filenames = ImageDataQlty::where('process_order_id', $processOrderId)
        ->where('uuid', $uuid) 
            ->where('batch_number', function ($query) {
                $query->selectRaw('max(batch_number)')
                    ->from('QUALITY_PACK.dbo.imageData_Qlty')
                    ->whereColumn('process_order_id', 'QUALITY_PACK.dbo.imageData_Qlty.process_order_id');
            })
            ->pluck('filename') // Pluck only the filenames
            ->toArray(); // Convert the collection to an array
    
        return response()->json(['filenames' => $filenames]);
    }
    }
    public function getImages_Quality(Request $request)
{
    $processOrderId = (int) $request->input('id'); // Cast to integer

    // Retrieve the most recent quality data for the process order
    $qualityData = QualityFormData::where('process_order_number', $processOrderId)
        ->orderBy('updated_at', 'desc')
        ->first();

    if ($qualityData) {
        $uuid = $qualityData->uuid;

        // Retrieve filenames with the highest batch number for the given process order and UUID
        $filenames = ImageDataQlty::where('process_order_id', $processOrderId)
            ->where('uuid', $uuid)
            ->where('batch_number', function ($query) use ($processOrderId) {
                $query->selectRaw('max(batch_number)')
                ->from('QUALITY_PACK.dbo.imageData_Qlty')
                ->whereColumn('process_order_id', 'QUALITY_PACK.dbo.imageData_Qlty.process_order_id')
                ->where('process_order_id', $processOrderId);
            })
            ->pluck('filename')
            ->toArray();

        return response()->json(['filenames' => $filenames]);
    }

    return response()->json(['filenames' => []]);
}

    

    public function uploadImages_CompleteQuality(Request $request)
    {
        // Validate the request
        $request->validate([
            'process_order_number' => 'required|numeric', // Adjust validation rules as needed
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // Max 2MB and allowed file types
        ]);
    
        $processOrder = $request->input('process_order_number');
        $uuid = $request->input('uuid_qlty');
       // Get the maximum batch number for the process order
      $maxBatchNumber = ImageDataCompleteQlty::where('process_order_id', $processOrder)
      ->max('batch_number');
    
        // Determine the new batch number
     $batchNumber = $maxBatchNumber === null ? 1 : $maxBatchNumber + 1;
        // Check if the process order folder exists, if not, create it
        $folderPath = 'public/images_qlty_complete/' . $processOrder . '/' . $uuid . '/';
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
                $newImage = new ImageDataCompleteQlty();
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




    public function getImages_CompleteQuality(Request $request)
    {
        $processOrderId = (int)$request->input('id');
// Query to get the UUID from the QualityFormData table
$qualityData = QualityCompleteData::where('process_order_number', $processOrderId)
->orderBy('updated_at', 'desc')
->first();
  

if ($qualityData) {
    $uuid = $qualityData->uuid;
        // Query the database to get the filenames with the highest batch number
        $filenames = ImageDataCompleteQlty::where('process_order_id', $processOrderId)
        ->where('uuid', $uuid) 
        ->where('batch_number', function ($query) use ($processOrderId) {
            $query->selectRaw('max(batch_number)')
            ->from('QUALITY_PACK.dbo.imageData_CompleteQlty')
            ->whereColumn('process_order_id', 'QUALITY_PACK.dbo.imageData_CompleteQlty.process_order_id')
            ->where('process_order_id', $processOrderId);
            })
            ->pluck('filename') // Pluck only the filenames
            ->toArray(); // Convert the collection to an array
    
        return response()->json(['filenames' => $filenames]);
    }
    }
    
}