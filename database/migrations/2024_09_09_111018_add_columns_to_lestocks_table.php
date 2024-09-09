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
        Schema::table('lestocks', function (Blueprint $table) {
            $table->decimal('prix_achat', 8, 2)->default(0.00);
            $table->decimal('prix_vente', 8, 2)->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lestocks', function (Blueprint $table) {
            $table->dropColumn('prix_achat');
            $table->dropColumn('prix_vente');
        });
    }
};
