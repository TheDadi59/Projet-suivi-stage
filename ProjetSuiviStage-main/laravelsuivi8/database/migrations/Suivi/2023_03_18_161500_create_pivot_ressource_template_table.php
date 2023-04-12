<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePivotRessourceTemplateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ressource_template', function (Blueprint $table) {

            $table->integer("id_ressource_template")->autoIncrement();

            $table->integer("id_template");
            $table->foreign("id_template")->references("id_template")->on("template");

            $table->integer("id_ressource");
            $table->foreign("id_ressource")->references("id_ressource")->on("ressource")->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ressource_template');
    }
}
