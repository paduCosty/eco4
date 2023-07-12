<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users_event_locations_photos', function ($table) {
            $table->id();
            $table->string('path');
            $table->unsignedBigInteger('user_event_location_id');
            $table->foreign('user_event_location_id')->references('id')->on('users_event_locations');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('users_event_locations_photos', function ($table) {
            Schema::dropIfExists('users_event_locations_photos');
        });
    }
};
