<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('services')->insert([
            [
                'car_type' => 'small/medium',
                'service_type' => 'express glow',
                'price' => 25000
            ],
            [
                'car_type' => 'small/medium',
                'service_type' => 'hidrolik glow',
                'price' => 35000
            ],
            [
                'car_type' => 'small/medium',
                'service_type' => 'extra glow',
                'price' => 55000
            ],
            [
                'car_type' => 'large/big/suv',
                'service_type' => 'express glow',
                'price' => 30000
            ],
            [
                'car_type' => 'large/big/suv',
                'service_type' => 'hidrolik glow',
                'price' => 40000
            ],
            [
                'car_type' => 'large/big/suv',
                'service_type' => 'extra glow',
                'price' => 60000
            ],
            [
                'car_type' => 'premium',
                'service_type' => 'express glow',
                'price' => 40000
            ],
            [
                'car_type' => 'premium',
                'service_type' => 'hidrolik glow',
                'price' => 50000
            ],
            [
                'car_type' => 'premium',
                'service_type' => 'extra glow',
                'price' => 70000
            ],
        ]);
    }
}
