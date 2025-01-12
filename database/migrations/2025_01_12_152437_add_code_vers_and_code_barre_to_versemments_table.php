<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('versements', function (Blueprint $table) {
            $table->string('code_vers')->nullable();
            $table->string('code_barre')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('versements', function (Blueprint $table) {
            $table->dropColumn(['code_vers', 'code_barre']); // Supprime les colonnes si on fait un rollback
        });
    }
};
