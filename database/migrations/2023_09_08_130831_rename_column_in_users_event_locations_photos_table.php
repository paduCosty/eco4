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
        Schema::table('users_event_locations_photos', function (Blueprint $table) {
            $table->renameColumn('user_event_location_id', 'event_location_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users_event_locations_photos', function (Blueprint $table) {
            $table->renameColumn('event_location_id', 'user_event_location_id');
        });
    }
};
