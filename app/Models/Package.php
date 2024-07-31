<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'merk_kaca',
        'jenis_kaca',
        'harga',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'id_package');
    }
}
