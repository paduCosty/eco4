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
        Schema::create('event_registrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('email')->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('transport')->default(0);
            $table->unsignedInteger('seats_available')->nullable();
            $table->unsignedBigInteger('users_event_location_id');
            $table->foreign('users_event_location_id')->references('id')->on('users_event_locations');
            $table->boolean('terms_site')->default(false);
            $table->boolean('terms_workshop')->default(false);
            $table->boolean('volunteering_contract')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_registrations');
    }
};
