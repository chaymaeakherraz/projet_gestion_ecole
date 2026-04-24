<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('emplois', function (Blueprint $table) {
            $table->id();
            $table->string('jour');
            $table->string('heure');
            $table->string('matiere');
            $table->string('type'); // etudiant ou professeur
            $table->unsignedBigInteger('user_id'); // lié à étudiant ou professeur
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('emplois');
    }
};
