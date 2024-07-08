<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_booking',
        'payment_method',
        'amount',
        'status',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
