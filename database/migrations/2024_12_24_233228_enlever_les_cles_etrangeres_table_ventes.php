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
        Schema::table('ventes', function (Blueprint $table) {
            // Supprimer les contraintes de clés étrangères
            $table->dropForeign(['id_user']);
            $table->dropForeign(['id_facture']);
            $table->dropForeign(['id_lestock']);
            $table->dropForeign(['id_produit']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ventes', function (Blueprint $table) {
            // Réajouter les colonnes
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
        });
    }
};
