<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function handleFileUpload(Request $request)
    {
        // Validate the request
        $request->validate([
            'uploaded_files_1.*' => 'required|file|mimes:jpeg,png,pdf,txt|max:2048',
            'uploaded_files_2.*' => 'required|file|mimes:jpeg,png,pdf,txt|max:2048',
        ]);

        // Ensure the destination directories exist, create them if not
        File::makeDirectory(storage_path('app/public/uploaded_files_1'), 0775, true, true);
        File::makeDirectory(storage_path('app/public/uploaded_files_2'), 0775, true, true);

        // Handle uploaded files for 'uploaded_files_1'
        $uploadedFiles1 = $request->file('uploaded_files_1');
        if ($uploadedFiles1) {
            $filename = time() . '_uploaded_files_1_' . $uploadedFiles1->getClientOriginalName();
            $uploadedFiles1->move(storage_path('app/public/uploaded_files_1'), $filename);
            // Save $filename or perform other operations as needed
        }

        // Handle uploaded files for 'uploaded_files_2'
        $uploadedFiles2 = $request->file('uploaded_files_2');
        if ($uploadedFiles2) {
            $filename = time() . '_uploaded_files_2_' . $uploadedFiles2->getClientOriginalName();
            $uploadedFiles2->move(storage_path('app/public/uploaded_files_2'), $filename);
            // Save $filename or perform other operations as needed
        }

        return response()->json(['message' => 'Files uploaded successfully'], 200);
    }
}
