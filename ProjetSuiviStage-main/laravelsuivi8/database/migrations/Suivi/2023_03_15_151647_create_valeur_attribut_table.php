<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValeurAttributTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('valeur_attribut', function (Blueprint $table) {

            $table->integer('id_valeur_attribut')->autoIncrement();

            $table->integer('id_activite');
            $table->foreign("id_activite")->references("id_activite")->on("activite")->onDelete('cascade');

            $table->integer("id_attribut");
            $table->foreign("id_attribut")->references("id_attribut")->on("attribut");

            $table->text('valeur')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('valeur_attribut');
    }
}
