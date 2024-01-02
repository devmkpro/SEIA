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
        Schema::create('users_schools', function (Blueprint $table) {
            $table->uuid("uuid")->primary();
            $table->uuid("users_uuid");
            $table->uuid("school_uuid");
            $table->uuid("role")->nullable();
            $table->foreign("users_uuid")->references("uuid")->on("users");
            $table->foreign("school_uuid")->references("uuid")->on("schools");
            $table->foreign("role")->references("uuid")->on("roles");
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aluno_escolas');
    }
};
