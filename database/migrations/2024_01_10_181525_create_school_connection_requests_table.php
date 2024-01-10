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
        Schema::create('school_connection_requests', function (Blueprint $table) {
            $table->uuid("uuid")->primary();
            $table->uuid("school_uuid");
            $table->uuid("user_uuid");
            $table->uuid("role");
            $table->uuid("class_uuid");
            $table->string("status")->default("pending");
            $table->foreign('school_uuid')->references('uuid')->on('schools');
            $table->foreign('user_uuid')->references('uuid')->on('users');
            $table->foreign('class_uuid')->references('uuid')->on('classes');
            $table->foreign("role")->references("uuid")->on("roles");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_connection_requests');
    }
};
