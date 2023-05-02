<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users_event_locations', function (Blueprint $table) {
            $table->boolean('terms_site')->default(false);
            $table->boolean('terms_workshop')->default(false);
            $table->boolean('volunteering_contract')->default(false);
            $table->enum('status', ['pending', 'approved', 'denied'])->default('pending');
            $table->dropColumn('event_name');
        });
    }

    public function down()
    {
        Schema::table('nume_tabel', function (Blueprint $table) {
            $table->string('event_name');
            $table->dropColumn('terms_site');
            $table->dropColumn('terms_workshop');
            $table->dropColumn('volunteering_contract');
            $table->dropColumn('status');
        });
    }
};
