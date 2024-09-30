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
        Schema::table('produits', function (Blueprint $table) {
            $table->integer('prix_achat')->unsigned()->default(0);
            $table->integer('prix_vente')->unsigned()->default(0);
            $table->string('unite_mesure');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produits', function (Blueprint $table) {
            $table->dropColumn('prix_achat');
            $table->dropColumn('prix_vente');
            $table->dropColumn('unite_mesure');
        });
    }
};
