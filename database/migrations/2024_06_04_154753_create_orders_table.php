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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_booking');
            $table->decimal('amount', 8, 2);
            $table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending');
            $table->timestamps();

            $table->foreign('id_booking')->references('id')->on('bookings');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
