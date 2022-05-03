<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('access_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('guards')->nullable(true)->comment('操作人(guards)');
            $table->string('method', 10)->nullable(false)->default('')->comment('呼叫方法');
            $table->string('url')->nullable(false)->default('')->comment('呼叫網址');
            $table->text('referer')->nullable(true)->comment('參照來源');
            $table->string('user_agent')->nullable(false)->default('')->comment('User-Agent');
            $table->text('input')->nullable(true)->comment('輸入參數');
            $table->string('ip', 50)->nullable(false)->default('')->comment('來源IP');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('access_logs');
    }
}
