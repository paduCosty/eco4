<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_event_locations', function (Blueprint $table) {
            $table->renameColumn('user_id', 'coordinator_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_event_locations', function (Blueprint $table) {
            $table->renameColumn('coordinator_id', 'user_id');
        });
    }
};
