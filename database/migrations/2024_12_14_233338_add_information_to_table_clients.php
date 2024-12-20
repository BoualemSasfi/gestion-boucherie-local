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
        Schema::table('clients', function (Blueprint $table) {
          $table->string('n_rc');
          $table->string('NIF');
          $table->string('NIS');
          $table->string('adresse');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('n_rc');
            $table->dropColumn('NIF');
            $table->dropColumn('NIS');
            $table->dropColumn('adresse');
        });
    }
};
