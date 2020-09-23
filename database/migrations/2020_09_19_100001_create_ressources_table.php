<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRessourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ressources', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->longText('description');
            $table->longText('detail');
            $table->integer('etat')->default(1);
            $table->timestamps();
        });

        // clé etrangère pour mapper le username de l'user l'ayant creer
        Schema::table('ressources', function (Blueprint $table) {
            $table->string('creer_par')->index();
        });

        // clé etrangère pour mapper le username de l'user l'ayant creer
        Schema::table('ressources', function (Blueprint $table) {
            $table->integer('client_id')->unsigned()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ressources');
    }
}
