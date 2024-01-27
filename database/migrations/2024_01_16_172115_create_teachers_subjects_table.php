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
        Schema::create('teachers_subjects', function (Blueprint $table) {
            $table->uuid("uuid")->primary();
            $table->uuid("user_uuid");
            $table->uuid("class_uuid");
            $table->uuid("subject_uuid");
            $table->boolean("active")->default(true);
            $table->boolean("primary_teacher")->default(true);
            $table->foreign("user_uuid")->references("uuid")->on("users");
            $table->foreign("class_uuid")->references("uuid")->on("classes");
            $table->foreign("subject_uuid")->references("uuid")->on("subjects");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers_subjects');
    }
};
