<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArtigosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artigos', function (Blueprint $table) {
            $table->integer('art_id', true);
            $table->string('art_designacao', 45);
            $table->integer('art_estado_id')->index('art_estado_id');
            $table->integer('art_tipoArtigo_id');
            $table->integer('art_stock_minimo')->nullable();
            $table->integer('art_stock_real')->nullable();
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
        Schema::drop('artigos');
    }
}
