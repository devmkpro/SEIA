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
        Schema::create('subjects', function (Blueprint $table) {
            $table->uuid("uuid")->primary();
            $table->string("code")->unique();
            $table->uuid("curriculum_uuid");
            $table->string("name")
            ->enum([
                'artes',
                'biologia',
                'ciencias',
                'educacao-fisica',
                'filosofia',
                'fisica',
                'geografia',
                'historia',
                'ingles',
                'literatura',
                'matematica',
                'portugues',
                'quimica',
                'sociologia',
                'ensino-religioso',
                'other'
            ]);
            $table->integer("ch")->default(0);
            $table->integer("ch_week")->default(0);
            $table->string("description")->nullable();
            $table->string('modality')
            ->enum([
                'linguagens-e-suas-tecnologias',
                'ciencias-da-natureza-e-suas-tecnologias',
                'ciencias-humanas-e-suas-tecnologias',
                'estudos-literarios',
                'ensino-religioso',
                'parte-diversificada',
            ])->nullable();

            $table->foreign('curriculum_uuid')->references('uuid')->on('curricula')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
