<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('services_fields', function (Blueprint $table) {
            $table->id();
            $table->integer('services_id');
            $table->string('field_name');
            $table->tinyInteger('html_type');
            $table->tinyInteger('db_type');
            $table->string('label');
            $table->string('validate')->nullable();
            $table->string('placeholder')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services_fields');
    }
};
