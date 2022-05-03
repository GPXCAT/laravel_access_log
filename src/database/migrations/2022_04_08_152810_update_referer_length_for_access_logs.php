<?php

use App\Models\AccessLog;
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
        AccessLog::orderby('id')->chunk(100, function ($accessLogRowset) {
            foreach ($accessLogRowset as $accessLogRow) {
                $newInput = app('App\Http\Middleware\HandleRequest')->removeBase64Data($accessLogRow->input);
                if (md5(json_encode($newInput)) != md5(json_encode($accessLogRow->input))) {
                    Log::info('id:' . $accessLogRow->id . ' - 調整Log移除Base64內容');
                    $accessLogRow->input = $newInput;
                    $accessLogRow->save();
                }
            }
        });
        Log::notice('調整Log移除Base64內容完成');

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
