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
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid("uuid")->primary();
            $table->string("title");
            $table->string("body");
            $table->string("icon")->nullable();
            $table->uuid("request_uuid")->nullable();
            $table->boolean("read")->default(false);
            $table->enum("type", ["info", "request", "warning"])->default("info");
            $table->uuid("user_uuid");
            $table->foreign("user_uuid")->references("uuid")->on("users");
            $table->foreign("request_uuid")->references("uuid")->on("school_connection_requests");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
