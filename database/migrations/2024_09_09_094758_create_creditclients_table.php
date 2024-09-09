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
        Schema::create('creditclients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_client')->nullable();
            $table->foreign('id_client')
                ->references('id')
                ->on('clients')
                ->onDelete('set null');
            $table->unsignedBigInteger('id_facture')->nullable();
            $table->foreign('id_facture')
                ->references('id')
                ->on('factures')
                ->onDelete('set null');
            $table->decimal('total_facture', 8, 2)->default(0.00);
            $table->decimal('versement', 8, 2)->default(0.00);
            $table->decimal('credit', 8, 2)->default(0.00);
            $table->string('etat_credit')->nullable()->default('impayé');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('creditclients');
    }
};
