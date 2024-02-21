<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\FileModel;
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
}