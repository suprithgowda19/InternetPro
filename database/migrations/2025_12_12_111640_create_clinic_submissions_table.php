<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('clinic_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('phc', 255)->index();
            $table->string('clinic_name', 255)->index();
            $table->string('doctor_name', 255)->nullable();
            $table->string('phone', 10)->index();
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
            $table->string('image_path')->nullable();
            $table->string('source')->default('whatsapp');
            $table->json('raw_payload')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clinic_submissions');
    }
};
