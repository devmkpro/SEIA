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
        Schema::create('classes_rooms', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->uuid('class_uuid');
            $table->foreign('class_uuid')->references('uuid')->on('classes')->onDelete('cascade');
            $table->uuid('room_uuid');
            $table->foreign('room_uuid')->references('uuid')->on('rooms')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes_rooms');
    }
};
