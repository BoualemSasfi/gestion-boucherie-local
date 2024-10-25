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
        Schema::create('caisses', function (Blueprint $table) {
            $table->id();
            $table->string('code_caisse');
            $table->unsignedBigInteger('id_magasin')->nullable();
            $table->foreign('id_magasin')
                ->references('id')
                ->on('magasins')
                ->onDelete('set null');
            $table->boolean('active')->nullable();
            $table->decimal('solde', 10, 2)->default(0.00);
            $table->decimal('fond_caisse', 10, 2)->default(0.00);
                
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caisses');
    }
};
