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
        Schema::create('curricula', function (Blueprint $table) {
            $table->uuid("uuid")->primary();
            $table->uuid("school_uuid");
            $table->foreign('school_uuid')->references('uuid')->on('schools');
            $table->string('series')
            ->enum(
            'educ_infa_cc_0_3',
            'educ_infa_cc_4_5',
            'educ_ini_1_5',
            'educ_ini_6_9',
            'educ_med_1',
            'educ_med_2',
            'educ_med_3', 
            'other');
            $table->integer('weekly_hours');
            $table->integer('total_hours');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('modality')
            ->enum(
                'bercario',
                'creche',
                'pre_escola',
                'fundamental',
                'medio',
                'eja',
                'educacao_especial',
                'other'
            );


            $table->string('description')->nullable();
            $table->string('complementary_information')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curricula');
    }
};
