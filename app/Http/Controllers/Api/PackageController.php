<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packages = Package::paginate(10);
        return $this->jsonResponse('success', $packages, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $this->validatePackage($request);

        if ($validator->fails()) {
            return $this->jsonResponse('error', $validator->errors(), 422);
        }

        $validated = $validator->validated();
        $package = Package::create($validated);

        return $this->jsonResponse('success', $package, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Package $package)
    {
        if (is_null($package)) {
            return $this->jsonResponse('Error', 'Package Not Found!', 404);
        }

        return $this->jsonResponse('success', $package, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Package $package)
    {
        $validator = $this->validatePackage($request);

        if ($validator->fails()) {
            return $this->jsonResponse('error', $package, 422);
        }

        if (is_null($package)) {
            return $this->jsonResponse('error', 'Package Not Found!', 404);
        }

        $validated = $validator->validated();
        $package->update($validated);

        return $this->jsonResponse('success', $package, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package)
    {
        if (is_null($package)) {
            return $this->jsonResponse('error', 'Package Not Found!', 404);
        }

        $package->delete();

        return $this->jsonResponse('success', 'Package Deleted!', 200);
    }

    private function validatePackage(Request $request)
    {
        return Validator::make($request->all(), [
            'merk_kaca' => 'required|string|max:255',
            'jenis_kaca' => 'required|in:full,samping-belakang,depan',
            'harga' => 'required|numeric'
        ]);
    }

    private function jsonResponse($status, $data, $code)
    {
        return response()->json([
            'status' => $status,
            'data' => $data
        ], $code);
    }
}
