<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePivotRessourceJalonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ressource_jalon', function (Blueprint $table) {

            $table->integer("id_ressource_jalon")->autoIncrement();

            $table->integer("id_jalon");
            $table->foreign("id_jalon")->references("id_jalon")->on("jalon");

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
        Schema::dropIfExists('ressource_jalon');
    }
}
