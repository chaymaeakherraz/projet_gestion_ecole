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
        Schema::create('certificats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('etudiant_id');

            $table->enum('type', [
                'Certificat de scolarité',
                'Certificat de stage',
                "Attestation _inscription"
            ])->default('Certificat de scolarité');

            $table->enum('statut', ['en attente', 'accepté', 'refusé'])->default('en attente');

            $table->timestamps();

            $table->foreign('etudiant_id')
                  ->references('id')
                  ->on('etudiants')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificats');
    }
};

