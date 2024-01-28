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
        Schema::create('classes', function (Blueprint $table) {

            $table->uuid('uuid')->primary();
            $table->string('code')->unique();
            $table->string('name');
            $table->uuid('primary_room')->nullable();
            $table->foreign('primary_room')->references('code')->on('rooms')->onDelete('cascade')->onUpdate('cascade');
            $table->uuid('schools_uuid');
            $table->foreign('schools_uuid')->references('uuid')->on('schools')->onDelete('cascade');
            $table->uuid('school_years_uuid');
            $table->foreign('school_years_uuid')->references('uuid')->on('school_years')->onDelete('cascade');
            $table->enum('modality', ['regular', 'eja', 'eja_fundamental', 'eja_medio'])->default('regular');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('turn', ['morning', 'afternoon', 'night'])->default('morning');
            $table->boolean('monday')->default(false);
            $table->boolean('tuesday')->default(false);
            $table->boolean('wednesday')->default(false);
            $table->boolean('thursday')->default(false);
            $table->boolean('friday')->default(false);
            $table->boolean('saturday')->default(false);
            $table->boolean('sunday')->default(false);
            $table->integer('max_students')->default(30);

            
            $table->uuid('teacher_responsible_uuid')->nullable();
            $table->foreign('teacher_responsible_uuid')->references('uuid')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->uuid('curriculum_uuid')->nullable();
            $table->foreign('curriculum_uuid')->references('uuid')->on('curricula')->onDelete('cascade')->onUpdate('cascade');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
