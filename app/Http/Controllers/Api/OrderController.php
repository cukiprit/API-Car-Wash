<?php

namespace App\Http\Controllers\Api;

use App\Exports\OrdersExport;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Order;
use Exception;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    public function getSnapToken()
    {
        // $booking = Booking::findOrFail($bookingId);
        // $service = Service::findOrFail($booking->id_service);

        $transactionDetails = [
            'order_id' => uniqid(),
            'gross_amount' => '80000'
        ];

        $customerDetails = [
            'name' => 'Supri',
            'email' => 'supri@gmail.com',
            'phone' => '0895710568000'
        ];

        $params = [
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            return response()->json([
                'status' => 'success',
                'data' => [
                    'snap_token' => $snapToken
                ]
            ], 201);
        } catch (Exception $err) {
            return response()->json([
                'status' => 'error',
                'errors' => $err->getMessage()
            ], 500);
        }
    }

    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');
    }

    public function createPayment(Request $request)
    {
        $booking = Booking::find($request->id_booking);
        $order = Order::create([
            'id_booking' => $booking->id,
            'amount' => $booking->service->price,
            'status' => 'pending'
        ]);

        $params = [
            'transaction_details' => [
                'order_id' => $order->id,
                'gross_amount' => $order->amount
            ],
            'customer_details' => [
                'first_name' => $booking->name,
                'phone' => $booking->phone
            ]
        ];

        $snapToken = Snap::getSnapToken($params);
        return response()->json(['snapToken' => $snapToken]);
    }

    public function paymentCallback(Request $request)
    {
        $serverKey = config('services.midtrans.serverKey');
        $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                $order = Order::find($request->order_id);
                $order->status = 'paid';
                $order->save();
            }
        }

        return response()->json(['status' => 'success']);
    }

    public function exportPayments()
    {
        return Excel::download(new OrdersExport, 'rekap.xlsx');
    }
}
