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
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->string('code_facture')->nullable();
            $table->unsignedBigInteger('id_user')->nullable();
            $table->foreign('id_user')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
            $table->unsignedBigInteger('id_magasin')->nullable();
            $table->foreign('id_magasin')
                ->references('id')
                ->on('magasins')
                ->onDelete('set null');
            $table->unsignedBigInteger('id_caisse')->nullable();
            $table->foreign('id_caisse')
                ->references('id')
                ->on('caisses')
                ->onDelete('set null');
            $table->unsignedBigInteger('id_client')->nullable();
            $table->foreign('id_client')
                ->references('id')
                ->on('clients')
                ->onDelete('set null');
            $table->string('etat_facture')->nullable()->default('en-attente');

            $table->decimal('total_facture', 8, 2)->default(0.00);
            $table->decimal('versement', 8, 2)->default(0.00);
            $table->decimal('credit', 8, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factures');
    }
};
