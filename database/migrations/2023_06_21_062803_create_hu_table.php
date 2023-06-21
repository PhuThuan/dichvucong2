<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hu', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->char('ẹnn');
            $table->string('service_id');
            $table->string('user_id');
            $table->boolean('status');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('hu');
    }
}
