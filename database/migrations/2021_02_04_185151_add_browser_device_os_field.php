<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBrowserDeviceOsField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('logs_download_file', function (Blueprint $table) {
           $table->string('OS',100)->after('is_admin');
           $table->string('browser',100)->after('OS');
           $table->string('device',100)->after('browser');
           $table->string('ip',100)->after('device');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('logs_download_file', function (Blueprint $table) {
            //
        });
    }
}
