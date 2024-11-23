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
            $table->string('designation_produit')->nullable();
            $table->boolean('produit')->default(true)->nullable();
            $table->boolean('sous_produit')->default(false)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ventes', function (Blueprint $table) {
            $table->dropColumn('designation_produit');
            $table->dropColumn('produit');
            $table->dropColumn('sous_produit');
        });
    }
};
