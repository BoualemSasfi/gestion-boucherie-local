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
        Schema::create('ventes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user')->nullable();
            $table->foreign('id_user')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
            $table->unsignedBigInteger('id_facture')->nullable();
            $table->foreign('id_facture')
                ->references('id')
                ->on('factures')
                ->onDelete('set null');
            $table->unsignedBigInteger('id_lestock')->nullable();
            $table->foreign('id_lestock')
                ->references('id')
                ->on('lestocks')
                ->onDelete('set null');
            $table->unsignedBigInteger('id_produit')->nullable();
            $table->foreign('id_produit')
                ->references('produit_id')
                ->on('lestocks')
                ->onDelete('set null');
            $table->decimal('prix_unitaire', 8, 2)->default(0.00);
            $table->decimal('quantite', 8, 2)->default(0.00);
            $table->decimal('total_vente', 8, 2)->default(0.00);
            $table->decimal('benefice', 8, 2)->default(0.00);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventes');
    }
};
