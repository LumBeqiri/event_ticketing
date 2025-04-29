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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('booking_id')
                ->constrained('bookings')->cascadeOnDelete();

            $table->decimal('price', 10, 2);
            $table->string('seat_info')->nullable();

            $table->enum('status', ['reserved', 'paid', 'cancelled'])
                ->default('reserved');

            $table->timestamp('booking_time')->useCurrent();

            $table->timestamp('payment_time')->nullable();
            $table->string('ticket_number')->unique();
            $table->timestamps();
        });
    }
};
