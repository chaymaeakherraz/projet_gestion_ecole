<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ajouter la colonne 'password' à la table professeurs.
     */
    public function up(): void
    {
        Schema::table('professeurs', function (Blueprint $table) {
            //$table->string('password')->after('email');
        });
    }

    /**
     * Supprimer la colonne 'password' si on fait un rollback.
     */
    public function down(): void
    {
        Schema::table('professeurs', function (Blueprint $table) {
            $table->dropColumn('password');
        });
    }
};
