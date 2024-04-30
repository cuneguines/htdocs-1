<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PackingTransportFormData;
use App\Models\PackingTransportCompleteData;

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
        $packingTransportCompleteData->technical_file = $request->has('technical_file') ? 'on' : '';
        $packingTransportCompleteData->client_handover_documentation = $request->has('client_handover_documentation') ? 'on' : '';
        $packingTransportCompleteData->sign_off_documentation = $request->input('sign_off_documentation');
        $packingTransportCompleteData->comments_documentation = $request->input('comments_documentation');
        $packingTransportCompleteData->status = $request->input('status');
        $packingTransportCompleteData->quantity = $request->input('quantity');
        $packingTransportCompleteData->labels_attached = $request->has('labels_attached') ? 'on' : '';
        // Add other fields accordingly

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
}
