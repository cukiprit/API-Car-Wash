<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::paginate(10);
        return response()->json([
            'status' => 'success',
            'data' => $services
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'car_type' => 'required|in:small/medium,large/big/suv,premium',
            'service_type' => 'required|in:Express Glow,Hidrolik Glow,Extra Glow',
            'price' => 'required|numeric',
            'description' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $service = Service::create($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $service
        ], 201);
    }

    public function show($id)
    {
        $service = Service::find($id);

        if (is_null($service)) {
            return response()->json([
                'status' => 'error',
                'errors' => 'Service Not Found!'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $service
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'car_type' => 'required|in:small/medium,large/big/suv,premium',
            'service_type' => 'required|in:Express Glow,Hidrolik Glow,Extra Glow',
            'price' => 'required|numeric',
            'description' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $service = Service::find($id);

        if (is_null($service)) {
            return response()->json([
                'status' => 'error',
                'errors' => 'Service Not Found!'
            ], 404);
        }

        $service->update($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $service
        ], 200);
    }

    public function destroy($id)
    {
        $service = Service::find($id);

        if (is_null($service)) {
            return response()->json([
                'status' => 'error',
                'errors' => 'No Service Found!'
            ], 404);
        }

        $service->delete();

        return response()->json([
            'status' => 'success',
            'data' => 'Service Deleted!'
        ], 200);
    }
}
