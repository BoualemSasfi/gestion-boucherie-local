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
        Schema::create('calculs_lists', function (Blueprint $table) {
            $table->id();
            $table->string('calculs_transfert_id')->nullable();

            $table->string('lestock_id')->nullable();
            $table->string('produit_id')->nullable();
            $table->string('produit_designation')->nullable();
            $table->float('quantite_transfere')->nullable();
            $table->float('quantite_ventes')->nullable();
            $table->float('quantite_retour')->nullable();
            $table->float('quantite_reste')->nullable();
            $table->float('montant_ventes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calculs_list');
    }
};
