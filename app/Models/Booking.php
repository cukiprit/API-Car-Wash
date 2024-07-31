<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'booking_time',
        'booking_date',
        'id_service',
        'id_package'
    ];

    public function package()
    {
        return $this->belongsTo(Package::class, 'id_package');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'id_service');
    }

    public function order()
    {
        return $this->hasOne(Order::class);
    }
}
