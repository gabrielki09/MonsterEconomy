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
        Schema::create('fuel_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained('vehicles')->cascadeOnDelete();
            $table->timestamp('refueled_at');
            $table->decimal('liters', 12,2);
            $table->decimal('price_per_liter', 12,2);
            $table->decimal('total_amount', 12,2);
            $table->decimal('odometer_km', 12,2);
            $table->boolean('full_tank')->default(false);
            $table->string('location_name', 120);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuel_entries');
    }
};
