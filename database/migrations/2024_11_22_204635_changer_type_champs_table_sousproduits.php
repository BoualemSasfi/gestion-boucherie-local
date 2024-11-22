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
        Schema::table('sousproduits', function (Blueprint $table) {
            //
            $table->integer('prix_vente')->change();
            $table->integer('prix_semi_gros')->change();
            $table->integer('prix_gros')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sousproduits', function (Blueprint $table) {
            //
        });
    }
};
