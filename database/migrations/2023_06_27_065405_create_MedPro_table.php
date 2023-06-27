<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedProTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('MedPro', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->char('ho_va_ten');
            $table->char('gender');
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
        Schema::drop('MedPro');
    }
}
