<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdustosvendaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produstosvenda', function (Blueprint $table) {
            $table->id();
            $table->integer('prod_venda_id')->nullable();
            $table->integer('prod_art_id')->nullable();
            $table->integer('prod_quantidade')->nullable();
            $table->integer('prod_total')->nullable();
            $table->integer('prod_preco')->nullable();
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
        Schema::dropIfExists('produstosvenda');
    }
}
