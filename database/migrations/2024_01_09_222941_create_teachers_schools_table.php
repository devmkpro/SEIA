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
        Schema::create('teachers_schools', function (Blueprint $table) {
            $table->uuid("uuid")->primary();
            $table->uuid("user_uuid");
            $table->uuid("school_uuid");
            $table->uuid("class_uuid");
            $table->foreign('user_uuid')->references('uuid')->on('users');         
            $table->foreign('school_uuid')->references('uuid')->on('schools');
            $table->foreign('class_uuid')->references('uuid')->on('classes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers_schools');
    }
};
