<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('phone', 16);
            $table->time('booking_time');
            $table->date('booking_date');
            $table->enum('status', ['scheduled', 'completed', 'cancelled']);
            $table->unsignedBigInteger('id_services');
            $table->timestamps();

            $table->foreign('id_services')->references('id')->on('services');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
