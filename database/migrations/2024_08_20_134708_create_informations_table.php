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
        Schema::create('informations', function (Blueprint $table) {
            $table->id();
            $table->string('nom_entr')->nullable();
            $table->string('N_registre')->nullable();
            $table->string('date_registre')->nullable();
            $table->string('adresse')->nullable();
            $table->string('map')->nullable();
            $table->string('tel')->nullable();
            $table->string('email')->unique();
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informations');
    }
};
