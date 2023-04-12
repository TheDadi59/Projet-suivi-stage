<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValidationJalonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('validation_jalon', function (Blueprint $table) {

            //$table->integer("id_validation_jalon")->autoIncrement();

            $table->integer("id_activite");
            $table->foreign("id_activite")->references("id_activite")->on("activite")->onDelete('cascade');

            $table->integer("id_jalon");
            $table->foreign("id_jalon")->references("id_jalon")->on("jalon");

            $table->dateTime("date_validation")->nullable();

            $table->boolean("valide")->default(false);

            $table->text("commentaire")->nullable();

            // colonne pour la note (optionnelle)
            $table->float('note')->nullable();

            $table->primary(["id_activite", "id_jalon"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('validation_jalon');
    }
}
