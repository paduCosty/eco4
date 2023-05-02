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
        Schema::create('event_locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('cities_id');
            $table->unsignedBigInteger('user_id');
            $table->float('longitude', 10, 6);
            $table->float('latitude', 10, 6);
            $table->unsignedBigInteger('size_volunteer_id');
            $table->enum('status', ['pending', 'approved', 'denied'])->default('pending');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_locations');
    }
};
