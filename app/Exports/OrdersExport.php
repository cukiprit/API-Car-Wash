<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrdersExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return DB::table('orders')
            ->join('bookings', 'orders.id_booking', '=', 'bookings.id')
            ->leftJoin('packages', 'bookings.id_package', '=', 'packages.id')
            ->join('services', 'bookings.id_service', '=', 'services.id')
            ->select(
                'orders.id_booking',
                'orders.amount',
                'orders.status',
                'bookings.name',
                'bookings.phone',
                'bookings.booking_time',
                'bookings.booking_date',
                'packages.merk_kaca',
                'packages.jenis_kaca',
                'services.car_type',
                'services.service_type',
            )
            ->get();
    }

    public function headings(): array
    {
        return [
            'Booking ID',
            'Amount',
            'Status',
            'Name',
            'Phone',
            'Booking Time',
            'Booking Date',
            'Merk Kaca',
            'Jenis Kaca',
            'Car Type',
            'Service Type'
        ];
    }
}
