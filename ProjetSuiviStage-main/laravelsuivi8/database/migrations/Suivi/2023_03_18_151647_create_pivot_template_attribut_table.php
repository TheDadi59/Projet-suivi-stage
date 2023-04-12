<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePivotTemplateAttributTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('template_attribut', function (Blueprint $table) {

            $table->integer("id_template_attribut")->autoIncrement();

            $table->integer("id_attribut");
            $table->foreign("id_attribut")->references("id_attribut")->on("attribut");

            $table->integer("id_template");
            $table->foreign("id_template")->references("id_template")->on("template");

            //$table->primary(["id_attribut", "id_template"]);

            $table->boolean("obligatoire")->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('template_attribut');
    }
}
