<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('emplois', function (Blueprint $table) {
            if (Schema::hasColumn('emplois', 'professeur_id')) {
                $table->dropColumn('professeur_id');
            }
            if (Schema::hasColumn('emplois', 'etudiant_id')) {
                $table->dropColumn('etudiant_id');
            }
        });
    }

    public function down()
    {
        Schema::table('emplois', function (Blueprint $table) {
            $table->unsignedBigInteger('professeur_id')->nullable();
            $table->unsignedBigInteger('etudiant_id')->nullable();
        });
    }
};
