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
        Schema::create('sousproduits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pr')->nullable(); 
            $table->string('nom_s_pr')->nullable(); 
            $table->string('photo_s_pr')->nullable()->nullable(); 
            $table->decimal('prix_vente', 8, 2)->nullable();
            $table->decimal('prix_semi_gros', 8, 2)->nullable(); 
            $table->decimal('prix_gros', 8, 2)->nullable();
            $table->string('unite_mesure')->nullable(); 

            $table->foreign('id_pr')->references('id')->on('produits')->onDelete('cascade');



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sousproduits');
    }
};
