<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRefererLengthForAccessLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('access_logs', function (Blueprint $table) {
            $table->text('referer')->nullable(true)->comment('參照來源')->change();
            $table->text('input')->nullable(true)->comment('輸入參數')->change();
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
            $table->longText('referer')->nullable(true)->comment('參照來源')->change();
            $table->longText('input')->nullable(true)->comment('輸入參數')->change();
        });
    }
}
