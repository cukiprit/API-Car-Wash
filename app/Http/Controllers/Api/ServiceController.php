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
        return $this->jsonResponse('success', $services, 200);
    }

    public function store(Request $request)
    {
        $validator = $this->validateService($request);

        if ($validator->fails()) {
            return $this->jsonResponse('error', $validator->errors(), 422);
        }

        $validated = $validator->validated();
        $service = Service::create($validated);

        return $this->jsonResponse('success', $service, 201);
    }

    public function show(Service $service)
    {
        if (is_null($service)) {
            return $this->jsonResponse('error', 'Service Not Found!', 404);
        }

        return $this->jsonResponse('success', $service, 200);
    }

    public function update(Request $request, Service $service)
    {
        $validator = $this->validateService($request);

        if ($validator->fails()) {
            return $this->jsonResponse('error', $service, 422);
        }

        if (is_null($service)) {
            return $this->jsonResponse('error', 'Service Not Found!', 404);
        }

        $validated = $validator->validated();
        $service->update($validated);

        return $this->jsonResponse('success', $service, 200);
    }

    public function destroy(Service $service)
    {
        if (is_null($service)) {
            return $this->jsonResponse('error', 'Service Not Found!', 404);
        }

        $service->delete();

        return $this->jsonResponse('success', 'Service Deleted!', 200);
    }

    private function validateService(Request $request)
    {
        return Validator::make($request->all(), [
            'car_type' => 'required|in:small/medium,large/big/suv,premium',
            'service_type' => 'required|in:express glow,hidrolik glow,extra glow',
            'price' => 'required|numeric',
            'description' => 'string'
        ]);
    }

    private function jsonResponse($status, $data, $code)
    {
        return response()->json([
            'status' => $status,
            'data' => $data,
        ], $code);
    }
}
