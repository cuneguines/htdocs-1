<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QualityFormData; 
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

        // Save uploaded images
        if ($request->hasFile('quality_images')) {
            $images = [];
            foreach ($request->file('quality_images') as $image) {
                // Assuming you have a storage disk named 'public'
                $path = $image->store('quality_images', 'public');
                $images[] = $path;
            }
            $qualityData->images = $images;
        }

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
        ->first();;

        return response()->json($qualityData);
    }

    public function submitQualityCompleteForm(Request $request)
    {
        // Validate the request data if needed

        // Assuming you have an Eloquent model named QualityFormData
        $qualityData = QualityFormData::findOrFail($request->input('id'));
        $qualityData->walk_down_visual_inspection = $request->input('walk_down_visual_inspection') === 'Yes' ? true : false;
        $qualityData->comments_quality = $request->input('comments_quality');
        $qualityData->sign_off_quality = $request->input('sign_off_quality');
        $qualityData->submission_date = $request->input('submission_date');
        $qualityData->status = $request->input('status');
        $qualityData->quantity = $request->input('quantity');
        $qualityData->photos_attached = $request->input('photos_attached') === 'Yes' ? true : false;

        $qualityData->save();

        // You can return a response or redirect as needed
        return response()->json(['data' => $qualityData]);
    }

    public function getQualityCompleteDataByProcessOrder(Request $request)
    {
        // Fetch Quality Form Data based on process order number
        $processOrder = $request->input('process_order_number');
        
        $qualityData = QualityFormData::where('process_order_number', $processOrder)
        ->orderBy('updated_at', 'desc')
        ->first();

        return response()->json($qualityData);
    }
}


