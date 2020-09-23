<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('raison_sociale', 50);
            $table->string('sigle', 10);
            $table->string('contact');
            $table->integer('etat')->default(1);
            $table->timestamps();
        });

        // clé etrangère pour mapper le username de l'user l'ayant creer
        Schema::table('clients', function (Blueprint $table) {
            $table->string('creer_par')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
