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
        Schema::create('lestocks', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('stock_id')->nullable();
            // Définir la clé étrangère magasin
            $table->foreign('stock_id')
                ->references('id')
                ->on('stocks')
                ->onDelete('set null');
            // Définir la clé étrangère magasin

            $table->unsignedBigInteger('categorie_id')->nullable();
            // Définir la clé étrangère category
            $table->foreign('categorie_id')
                ->references('id')
                ->on('categories')
                ->onDelete('set null');
            // Définir la clé étrangère category

            $table->unsignedBigInteger('produit_id')->nullable();
            // Définir la clé étrangère category
            $table->foreign('produit_id')
                ->references('id')
                ->on('produits')
                ->onDelete('set null');
            // Définir la clé étrangère category

            $table->decimal('quantity',8,2)->default(0.00);
            $table->boolean('activ')->default(1);


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lestocks');
    }
};
