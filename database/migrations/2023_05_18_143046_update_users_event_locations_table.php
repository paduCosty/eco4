<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users_event_locations', function (Blueprint $table) {
            $table->text('description')->nullable()->after('name');
            $table->unsignedInteger('crm_propose_event_id')->nullable()->after('description');
        });
    }

    public function down()
    {
        Schema::table('users_event_locations', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->dropColumn('crm_propose_event_id');
        });
    }
};
