<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServerFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server_file', function (Blueprint $table) {
            $table->id();

            $table->string('path',255);
            $table->string('name',255);
            $table->string('owner',255);            
            $table->date('created_file');         
            $table->decimal('size',8,2);
                     
            $table->string('url_download',255);
            $table->string('secret',255);

            $table->unsignedBigInteger('server_id');

            $table->foreign('server_id')->references('id')->on('servers');
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
        Schema::dropIfExists('server_file');
    }
}
