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
        Schema::create('data_users', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->uuid('user_uuid');
            $table->date('birth_date');
            $table->string('gender');
            $table->string('country');
            $table->string('district');
            $table->string('city');
            $table->string('city_birth');
            $table->string('state');
            $table->string('state_birth');
            $table->string('zone');
            $table->string('zip_code');
            $table->string('cpf_responsible');
            $table->string('name_responsible')->nullable();


            $table->string('street')->nullable();
            $table->string('number')->nullable();
            $table->string('landline')->nullable();
            $table->string('complement')->nullable();
            $table->string('inep')->nullable();
            $table->string('cpf')->nullable();
            $table->string('rg')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('father_name')->nullable();
            $table->string('blood_type')->nullable();
            $table->boolean('deficiency')->default(false);
            $table->string('observation')->nullable();
            $table->timestamps();

            $table->foreign('user_uuid')->references('uuid')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_users');
    }
};
