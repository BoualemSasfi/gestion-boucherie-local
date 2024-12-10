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
        Schema::create('calculs_transferts', function (Blueprint $table) {
            $table->id();
            $table->string('calculs_par_jour_id')->nullable();

            $table->string('categorie_id')->nullable();
            $table->string('categorie_designation')->nullable();

            $table->float('total_ventes')->nullable();
            $table->float('total_quantite_transfere')->nullable();
            $table->float('total_quantite_retour')->nullable();
            $table->float('total_quantite_reste')->nullable();

            $table->float('poids_os')->nullable();
            $table->float('prix_os')->nullable();
            $table->float('poids_dechets')->nullable();
            $table->float('prix_dechets')->nullable();
            
            $table->float('poids_decalage')->nullable();
            $table->float('poids_insere')->nullable();
            
            $table->float('montant_insere')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calculs_transfert');
    }
};
