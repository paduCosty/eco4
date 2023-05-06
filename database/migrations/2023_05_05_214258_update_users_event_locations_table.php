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
            $table->dropColumn('status');
        });

        Schema::table('users_event_locations', function (Blueprint $table) {
            $table->enum('status', ['in asteptare', 'aprobat', 'refuzat', 'in desfasurare', 'desfasurat'])->default('in asteptare');
        });
    }

    public function down()
    {
        Schema::table('users_event_locations', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
