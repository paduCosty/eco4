<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('pre_greening_event_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_location_id');
            $table->string('path');
            $table->timestamps();

            $table->foreign('event_location_id')
                ->references('id')
                ->on('users_event_locations')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pre_greening_event_pictures');
    }
};
