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
        Schema::table('informations', function (Blueprint $table) {
            $table->string('NIS');
            $table->string('NIF');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('informations', function (Blueprint $table) {
            $table->dropColumn('NIS');
            $table->dropColumn('NIF');
        });
    }
};
