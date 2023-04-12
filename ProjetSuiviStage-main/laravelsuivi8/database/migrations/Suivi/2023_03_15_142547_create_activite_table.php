<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActiviteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activite', function (Blueprint $table) {
            $table->integer('id_activite')->autoIncrement();

            $table->integer('id_template');
            $table->foreign("id_template")->references("id_template")->on("template");

            $table->integer('id_utilisateur_referent');
            $table->foreign("id_utilisateur_referent")->references("id_utilisateur")->on("ent.utilisateur");

            $table->integer('id_utilisateur_suivi');
            $table->foreign("id_utilisateur_suivi")->references("id_utilisateur")->on("ent.utilisateur");

            $table->dateTime("date_debut");

            $table->boolean("est_cloture")->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activite');
    }
}
