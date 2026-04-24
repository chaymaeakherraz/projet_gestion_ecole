<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('emplois', function (Blueprint $table) {
            $table->string('type')->after('matiere'); // هادي كتزيد عمود 'type'
        });
    }

    public function down()
    {
        Schema::table('emplois', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
