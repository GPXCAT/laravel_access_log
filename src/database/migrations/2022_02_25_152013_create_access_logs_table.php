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
            $table->unsignedInteger('employee_id')->nullable(true)->comment('建立員工ID');
            $table->unsignedInteger('member_id')->nullable(true)->comment('會員ID');
            $table->string('method', 10)->nullable(false)->default('')->comment('呼叫方法');
            $table->string('url')->nullable(false)->default('')->comment('呼叫網址');
            $table->longText('referer')->nullable(true)->comment('參照來源');
            $table->string('user_agent')->nullable(false)->default('')->comment('User-Agent');
            $table->longText('input')->nullable(true)->comment('輸入參數');
            $table->string('ip', 15)->nullable(false)->default('')->comment('來源IP');
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employee')->onDelete('cascade');
            $table->foreign('member_id')->references('id')->on('member')->onDelete('cascade');
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
