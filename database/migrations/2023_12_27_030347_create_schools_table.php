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
        Schema::create('schools', function (Blueprint $table) {
            $table->uuid("uuid")->primary();

            $table->uuid("city_uuid");
            $table->foreign("city_uuid")->references("uuid")->on("cities");

            $table->string("name");
            $table->string("email");
            $table->string("phone")->nullable();
            $table->string("landline")->nullable();
            $table->string("zip_code");
            $table->string("district");
            $table->string("email_responsible");


            $table->boolean("active")->default(true);
            $table->boolean("public")->default(false);
            $table->boolean("has_education_infant")->default(false);
            $table->boolean("has_education_fundamental")->default(false);
            $table->boolean("has_education_medium")->default(false);
            $table->boolean("has_education_professional")->default(false);

            $table->string("inep")->nullable();
            $table->string("number")->nullable();
            $table->string("street")->nullable();
            $table->string("complement")->nullable();
            $table->string("cnpj")->nullable();
            $table->string("slug")->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
