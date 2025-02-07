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
        Schema::create('produits', function (Blueprint $table) {
            $table->id();

            $table->string('nom_pr')->nullable();
            $table->string('photo_pr')->nullable();
            $table->string('prix_vent')->nullable();    
            $table->unsignedBigInteger('categorie_id')->nullable();

            // Définir la clé étrangère
            $table->foreign('categorie_id')
                ->references('id')
                ->on('categories')
                ->onDelete('set null'); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
