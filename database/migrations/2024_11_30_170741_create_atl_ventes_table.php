<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('atl_ventes', function (Blueprint $table) {
            $table->id(); // Champ 'id' auto-incrémenté

            $table->unsignedBigInteger('id_fact')->nullable();
            $table->foreign('id_fact')
                ->references('id')
                ->on('factures')
                ->onDelete('set null');


            $table->unsignedBigInteger('id_lestock')->nullable(); // Clé étrangère vers la table 'lestock' (par exemple)
            $table->foreign('id_lestock')
                ->references('id')
                ->on('lestocks')
                ->onDelete('set null');

            $table->string('categorie')->nullable();    
            $table->string('produit')->nullable();    
            $table->decimal('PU', 10, 2)->nullable(); // Prix unitaire (décimal avec 10 chiffres au total, 2 après la virgule)
            $table->integer('Q')->nullable(); // Quantité
            $table->decimal('total', 10, 2)->nullable(); // Total (décimal avec 10 chiffres au total, 2 après la virgule)

            $table->timestamps(); // Champs 'created_at' et 'updated_at'

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atl_ventes');
    }
};
