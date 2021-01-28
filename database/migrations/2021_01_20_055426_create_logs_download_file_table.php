<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsDownloadFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs_download_file', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_admin')->default(0);
            $table->unsignedBigInteger('server_file_id');
            $table->foreign('server_file_id')->references('id')->on('server_file');
            
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
        Schema::dropIfExists('logs_download_file');
    }
}
