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
            $table->foreignId('bus_id')->constrained()->cascadeOnDelete();
            $table->foreignId('starting_location_id')->constrained('locations')->cascadeOnDelete();
            $table->foreignId('ending_location_id')->constrained('locations')->cascadeOnDelete();
            $table->date('trip_date');
            $table->time('starting_time');
            $table->time('arrival_time');
            $table->boolean('round_trip')->default(false);
            $table->date('return_date')->nullable();
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
