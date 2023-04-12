<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJalonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jalon', function (Blueprint $table) {

            $table->integer('id_jalon')->autoIncrement();

            $table->integer("id_template");
            $table->foreign("id_template")->references("id_template")->on("template");

            $table->string('libelle', 255);

            $table->text("description");

            $table->bigInteger("echeance");

            // indique si jalon concerne l'utilisateur suivi plutôt que le tuteur (par default)
            $table->boolean("pour_utilisateur_suivi")->default(false);

            // indique si le jalon requiert une note
            $table->boolean('notable')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jalon');
    }
}
