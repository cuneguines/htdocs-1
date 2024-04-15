<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\FileModel;
use App\Models\ImageData;
use App\Models\ImageDataQlty;


use Illuminate\Support\Facades\Storage;
class UploadController extends Controller
{
    public function handleFileUploadEngineer(Request $request)
    {
       
        try {
            $insert = [];
    
            // Extract process_order_number from the request
            $processOrderNumber = $request->input('process_order_number');
    
            foreach ($request->all() as $key => $file) {
                if ($request->hasFile($key)) {
                    $uploadedFile = $request->file($key);
                    $name = $uploadedFile->getClientOriginalName();
    
                    // Specify the storage path with process_order_number in it
                    $path = $uploadedFile->storeAs("public/engineer_task/{$processOrderNumber}", $name);
    
                    $insert[] = [
                        'name' => $name,
                        'path' => $path,
                        'process_order_number' => $processOrderNumber,
                    ];
                }
            }
    
            // Assuming you have a FileModel for database interaction
            FileModel::insert($insert);
    
            return response()->json(['success' => 'Files uploaded successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function handleFileUploadPlanning(Request $request)
    {
       
        try {
            $insert = [];
    
            // Extract process_order_number from the request
            $processOrderNumber = $request->input('process_order_number');
    
            foreach ($request->all() as $key => $file) {
                if ($request->hasFile($key)) {
                    $uploadedFile = $request->file($key);
                    $name = $uploadedFile->getClientOriginalName();
    
                    // Specify the storage path with process_order_number in it
                    $path = $uploadedFile->storeAs("public/planning_task/{$processOrderNumber}", $name);
    
                    $insert[] = [
                        'name' => $name,
                        'path' => $path,
                        'process_order_number' => $processOrderNumber,
                    ];
                }
            }
    
            // Assuming you have a FileModel for database interaction
            FileModel::insert($insert);
    
            return response()->json(['success' => 'Files uploaded successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function handleFileUploadMaterialPreparation(Request $request)
    {
       
        try {
            $insert = [];
    
            // Extract process_order_number from the request
            $processOrderNumber = $request->input('process_order_number');
    
            foreach ($request->all() as $key => $file) {
                if ($request->hasFile($key)) {
                    $uploadedFile = $request->file($key);
                    $name = $uploadedFile->getClientOriginalName();
    
                    // Specify the storage path with process_order_number in it
                    $path = $uploadedFile->storeAs("public/material_preparation_task/{$processOrderNumber}", $name);
    
                    $insert[] = [
                        'name' => $name,
                        'path' => $path,
                        'process_order_number' => $processOrderNumber,
                    ];
                }
            }
    
            // Assuming you have a FileModel for database interaction
            FileModel::insert($insert);
    
            return response()->json(['success' => 'Files uploaded successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function handleFileUploadManufacturing(Request $request)
    {
       
        try {
            $insert = [];
    
            // Extract process_order_number from the request
            $processOrderNumber = $request->input('process_order_number');
    
            foreach ($request->all() as $key => $file) {
                if ($request->hasFile($key)) {
                    $uploadedFile = $request->file($key);
                    $name = $uploadedFile->getClientOriginalName();
    
                    // Specify the storage path with process_order_number in it
                    $path = $uploadedFile->storeAs("public/manufacturing_task/{$processOrderNumber}", $name);
    
                    $insert[] = [
                        'name' => $name,
                        'path' => $path,
                        'process_order_number' => $processOrderNumber,
                    ];
                }
            }
    
            // Assuming you have a FileModel for database interaction
            FileModel::insert($insert);
    
            return response()->json(['success' => 'Files uploaded successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function handleFileUploadFabricationFitUp(Request $request)
    {
       
        try {
            $insert = [];
    
            // Extract process_order_number from the request
            $processOrderNumber = $request->input('process_order_number');
    
            foreach ($request->all() as $key => $file) {
                if ($request->hasFile($key)) {
                    $uploadedFile = $request->file($key);
                    $name = $uploadedFile->getClientOriginalName();
    
                    // Specify the storage path with process_order_number in it
                    $path = $uploadedFile->storeAs("public/fabricationfitup_task/{$processOrderNumber}", $name);
    
                    $insert[] = [
                        'name' => $name,
                        'path' => $path,
                        'process_order_number' => $processOrderNumber,
                    ];
                }
            }
    
            // Assuming you have a FileModel for database interaction
            FileModel::insert($insert);
    
            return response()->json(['success' => 'Files uploaded successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function handleFileUploadKitting(Request $request)
    {
       
        try {
            $insert = [];
    
            // Extract process_order_number from the request
            $processOrderNumber = $request->input('process_order_number');
    
            foreach ($request->all() as $key => $file) {
                if ($request->hasFile($key)) {
                    $uploadedFile = $request->file($key);
                    $name = $uploadedFile->getClientOriginalName();
    
                    // Specify the storage path with process_order_number in it
                    $path = $uploadedFile->storeAs("public/kitting_task/{$processOrderNumber}", $name);
    
                    $insert[] = [
                        'name' => $name,
                        'path' => $path,
                        'process_order_number' => $processOrderNumber,
                    ];
                }
            }
    
            // Assuming you have a FileModel for database interaction
            FileModel::insert($insert);
    
            return response()->json(['success' => 'Files uploaded successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function handleFileUploadWelding(Request $request)
    {
       
        try {
            $insert = [];
    
            // Extract process_order_number from the request
            $processOrderNumber = $request->input('process_order_number');
    
            foreach ($request->all() as $key => $file) {
                if ($request->hasFile($key)) {
                    $uploadedFile = $request->file($key);
                    $name = $uploadedFile->getClientOriginalName();
    
                    // Specify the storage path with process_order_number in it
                    $path = $uploadedFile->storeAs("public/welding_task/{$processOrderNumber}", $name);
    
                    $insert[] = [
                        'name' => $name,
                        'path' => $path,
                        'process_order_number' => $processOrderNumber,
                    ];
                }
            }
    
            // Assuming you have a FileModel for database interaction
            FileModel::insert($insert);
    
            return response()->json(['success' => 'Files uploaded successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function handleFileUploadTesting(Request $request)
    {
       
        try {
            $insert = [];
    
            // Extract process_order_number from the request
            $processOrderNumber = $request->input('process_order_number');
    
            foreach ($request->all() as $key => $file) {
                if ($request->hasFile($key)) {
                    $uploadedFile = $request->file($key);
                    $name = $uploadedFile->getClientOriginalName();
    
                    // Specify the storage path with process_order_number in it
                    $path = $uploadedFile->storeAs("public/testing_task/{$processOrderNumber}", $name);
    
                    $insert[] = [
                        'name' => $name,
                        'path' => $path,
                        'process_order_number' => $processOrderNumber,
                    ];
                }
            }
    
            // Assuming you have a FileModel for database interaction
            FileModel::insert($insert);
    
            return response()->json(['success' => 'Files uploaded successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function handleFileUploadFinishing(Request $request)
    {
       
        try {
            $insert = [];
    
            // Extract process_order_number from the request
            $processOrderNumber = $request->input('process_order_number');
    
            foreach ($request->all() as $key => $file) {
                if ($request->hasFile($key)) {
                    $uploadedFile = $request->file($key);
                    $name = $uploadedFile->getClientOriginalName();
    
                    // Specify the storage path with process_order_number in it
                    $path = $uploadedFile->storeAs("public/finishing_task/{$processOrderNumber}", $name);
    
                    $insert[] = [
                        'name' => $name,
                        'path' => $path,
                        'process_order_number' => $processOrderNumber,
                    ];
                }
            }
    
            // Assuming you have a FileModel for database interaction
            FileModel::insert($insert);
    
            return response()->json(['success' => 'Files uploaded successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function handleFileUploadSubContract(Request $request)
    {
       
        try {
            $insert = [];
    
            // Extract process_order_number from the request
            $processOrderNumber = $request->input('process_order_number');
    
            foreach ($request->all() as $key => $file) {
                if ($request->hasFile($key)) {
                    $uploadedFile = $request->file($key);
                    $name = $uploadedFile->getClientOriginalName();
    
                    // Specify the storage path with process_order_number in it
                    $path = $uploadedFile->storeAs("public/subcontract_task/{$processOrderNumber}", $name);
    
                    $insert[] = [
                        'name' => $name,
                        'path' => $path,
                        'process_order_number' => $processOrderNumber,
                    ];
                }
            }
    
            // Assuming you have a FileModel for database interaction
            FileModel::insert($insert);
    
            return response()->json(['success' => 'Files uploaded successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function handleFileUploadFinalAssembly(Request $request)
    {
       
        try {
            $insert = [];
    
            // Extract process_order_number from the request
            $processOrderNumber = $request->input('process_order_number');
    
            foreach ($request->all() as $key => $file) {
                if ($request->hasFile($key)) {
                    $uploadedFile = $request->file($key);
                    $name = $uploadedFile->getClientOriginalName();
    
                    // Specify the storage path with process_order_number in it
                    $path = $uploadedFile->storeAs("public/final_assembly_tasks/{$processOrderNumber}", $name);
    
                    $insert[] = [
                        'name' => $name,
                        'path' => $path,
                        'process_order_number' => $processOrderNumber,
                    ];
                }
            }
    
            // Assuming you have a FileModel for database interaction
            FileModel::insert($insert);
    
            return response()->json(['success' => 'Files uploaded successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function handleFileUploadDocumentation(Request $request)
    {
       
        try {
            $insert = [];
    
            // Extract process_order_number from the request
            $processOrderNumber = $request->input('process_order_number');
    
            foreach ($request->all() as $key => $file) {
                if ($request->hasFile($key)) {
                    $uploadedFile = $request->file($key);
                    $name = $uploadedFile->getClientOriginalName();
    
                    // Specify the storage path with process_order_number in it
                    $path = $uploadedFile->storeAs("public/documentation_tasks/{$processOrderNumber}", $name);
    
                    $insert[] = [
                        'name' => $name,
                        'path' => $path,
                        'process_order_number' => $processOrderNumber,
                    ];
                }
            }
    
            // Assuming you have a FileModel for database interaction
            FileModel::insert($insert);
    
            return response()->json(['success' => 'Files uploaded successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function handleFileUploadPackingTransport(Request $request)
    {
       
        try {
            $insert = [];
    
            // Extract process_order_number from the request
            $processOrderNumber = $request->input('process_order_number');
    
            foreach ($request->all() as $key => $file) {
                if ($request->hasFile($key)) {
                    $uploadedFile = $request->file($key);
                    $name = $uploadedFile->getClientOriginalName();
    
                    // Specify the storage path with process_order_number in it
                    $path = $uploadedFile->storeAs("public/transport_tasks/{$processOrderNumber}", $name);
    
                    $insert[] = [
                        'name' => $name,
                        'path' => $path,
                        'process_order_number' => $processOrderNumber,
                    ];
                }
            }
    
            // Assuming you have a FileModel for database interaction
            FileModel::insert($insert);
    
            return response()->json(['success' => 'Files uploaded successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
public function uploadImages(Request $request)
{
    // Validate the request
    $request->validate([
        'process_order_number' => 'required|numeric', // Adjust validation rules as needed
        'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // Max 2MB and allowed file types
    ]);

    $processOrder = $request->input('process_order_number');
   // Get the maximum batch number for the process order
  $maxBatchNumber = ImageData::where('process_order_id', $processOrder)
  ->max('batch_number');

    // Determine the new batch number
 $batchNumber = $maxBatchNumber === null ? 1 : $maxBatchNumber + 1;
    // Check if the process order folder exists, if not, create it
    $folderPath = 'public/images/'.$processOrder;
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
            $newImage = new ImageData();
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

public function uploadImages_Quality(Request $request)
{
    // Validate the request
    $request->validate([
        'process_order_number' => 'required|numeric', // Adjust validation rules as needed
        'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // Max 2MB and allowed file types
    ]);

    $processOrder = $request->input('process_order_number');
   // Get the maximum batch number for the process order
  $maxBatchNumber = ImageDataQlty::where('process_order_id', $processOrder)
  ->max('batch_number');

    // Determine the new batch number
 $batchNumber = $maxBatchNumber === null ? 1 : $maxBatchNumber + 1;
    // Check if the process order folder exists, if not, create it
    $folderPath = 'public/images_qlty/'.$processOrder;
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


public function getImages_Quality(Request $request)
    {
        $processOrderId = $request->input('id');

        // Query the database to get the filenames with the highest batch number
        $filenames = ImageDataQlty::where('process_order_id', $processOrderId)
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