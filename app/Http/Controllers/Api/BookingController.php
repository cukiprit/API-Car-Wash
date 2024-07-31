<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::paginate(10);
        return $this->jsonResponse('success', $bookings, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $this->validateBooking($request);

        if ($validator->fails()) {
            return $this->jsonResponse('error', $validator->errors(), 422);
        }

        $validated = $validator->validated();
        $booking = Booking::create($validated);

        return $this->jsonResponse('success', $booking, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        if (is_null($booking)) {
            return $this->jsonResponse('error', 'Booking Not Found!', 404);
        }

        return $this->jsonResponse('success', $booking, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        $validator = $this->validateBooking($request);

        if ($validator->fails()) {
            return $this->jsonResponse('error', $validator->errors(), 422);
        }

        if (is_null($booking)) {
            return $this->jsonResponse('error', 'Booking Not Found!', 404);
        }

        $validated = $validator->validated();
        $booking->update($validated);

        return $this->jsonResponse('success', $booking, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        if (is_null($booking)) {
            return $this->jsonResponse('error', 'Booking Not Found!', 404);
        }

        $booking->delete();

        return $this->jsonResponse('success', 'Booking Deleted!', 200);
    }

    private function validateBooking(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:16',
            'booking_time' => 'required|date_format:H:i:s',
            'booking_date' => 'required|date',
            // 'status' => 'required|in:scheduled,completed,cancelled',
            'id_service' => 'required|exists:services,id',
            'id_package' => 'nullable|exists:packages,id'
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
