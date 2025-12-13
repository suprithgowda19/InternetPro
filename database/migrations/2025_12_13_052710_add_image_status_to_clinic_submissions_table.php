<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('clinic_submissions', function (Blueprint $table) {
            $table->string('image_status', 20)
                  ->default('pending')
                  ->after('image_path');

            $table->text('image_error')
                  ->nullable()
                  ->after('image_status');
        });
    }

    public function down(): void
    {
        Schema::table('clinic_submissions', function (Blueprint $table) {
            $table->dropColumn(['image_status', 'image_error']);
        });
    }
};
