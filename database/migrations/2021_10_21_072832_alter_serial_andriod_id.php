<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSerialAndriodId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('downloaded_video_details', function (Blueprint $table) {
            $table->string('serial_number')->after('device_id');
            $table->string('andriod_id')->after('device_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('downloaded_video_details', function (Blueprint $table) {
            //
        });
    }
}
