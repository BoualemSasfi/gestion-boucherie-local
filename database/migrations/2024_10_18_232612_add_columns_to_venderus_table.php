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
        Schema::table('vendeurs', function (Blueprint $table) {
            $table->integer('id_p')->nullable();
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->string('tel')->nullable();
            $table->string('details')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendeurs', function (Blueprint $table) {
            $table->dropColumn('id_p');
            $table->dropColumn('nom');
            $table->dropColumn('prenom');
            $table->dropColumn('tel');
            $table->dropColumn('details');
        });
    }
};
