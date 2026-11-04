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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained('locations')->cascadeOnDelete();
            $table->foreignId('vehicle_id')->constrained('vehicles')->cascadeOnDelete();
            $table->timestamp('departed_at');
            $table->timestamp('arrived_at');
            $table->timestamp('returned_at');
            $table->decimal('outbound_distance_km', 12,2);
            $table->decimal('total_distance_km', 12,2);
            $table->decimal('average_speed_kmh', 12,2);
            $table->decimal('estimated_fuel_liters', 12,2);
            $table->decimal('estimated_fuel_cost', 12,2);
            $table->decimal('actual_fuel_cost', 12,2);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
