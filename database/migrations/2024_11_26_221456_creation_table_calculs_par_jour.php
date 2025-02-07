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
        Schema::create('calculs_par_jours', function (Blueprint $table) {
            $table->id();

            $table->string('magasin_id')->nullable();
            $table->string('magasin_nom')->nullable();
            $table->string('stock_id')->nullable();
            $table->string('transfert_id')->nullable();
            $table->float('chiffre_affaire')->nullable();
            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calculs_par_jour');
    }
};
