<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateFichierValidationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fichier_validation_jalon', function (Blueprint $table) {

            $table->integer("id_fichier_validation_jalon")->autoIncrement();

            $table->integer("id_activite");
            $table->foreign("id_activite")->references("id_activite")->on("activite");

            $table->integer("id_jalon");
            $table->foreign("id_jalon")->references("id_jalon")->on("jalon");

            $table->string("nom_original", 255);

            $table->integer("taille")->unsigned();

            $table->dateTime("date_upload");

            $table->string("localisation", 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fichier_validation_jalon');
    }
}
