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
        Schema::create('teachers_subjects_schedules', function (Blueprint $table) {
            $table->uuid("uuid")->primary();
            $table->uuid("teacher_subject_uuid");
            $table->uuid("subject_uuid");
            $table->uuid("user_uuid");
            $table->enum("day", ["monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday"]);
            $table->time("start_time");
            $table->time("end_time");
            $table->integer("total_hours");
            $table->foreign("teacher_subject_uuid")->references("uuid")->on("teachers_subjects")->onDelete("cascade");
            $table->foreign("subject_uuid")->references("uuid")->on("subjects")->onDelete("cascade");
            $table->foreign("user_uuid")->references("uuid")->on("users")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers_schedules');
    }
};
