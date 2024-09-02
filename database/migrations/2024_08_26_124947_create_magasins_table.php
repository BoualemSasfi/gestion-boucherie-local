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
        Schema::create('magasins', function (Blueprint $table) {
            $table->id();
            
            $table->string('nom')->nullable();
            $table->string('N_reg')->nullable();
            $table->string('adresse')->nullable();
            $table->string('tel')->nullable();
            $table->string('type')->nullable();
            $table->text('loca')->nullable();
            $table->string('photo')->nullable();
            $table->boolean('activ')->default(1);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('magasins');
    }
};
