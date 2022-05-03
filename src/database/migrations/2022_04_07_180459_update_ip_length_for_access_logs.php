<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateIpLengthForAccessLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('access_logs', function (Blueprint $table) {
            $table->string('ip', 50)->nullable(false)->default('')->comment('來源IP')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('access_logs', function (Blueprint $table) {
            $table->string('ip', 15)->nullable(false)->default('')->comment('來源IP')->change();
        });
    }
}
