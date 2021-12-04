<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaxaartigosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('taxaartigos', function(Blueprint $table)
		{
			$table->integer('trt_id', true);
			$table->integer('trt_art_id')->index('trt_art_id');
			$table->integer('trt_taxa_id')->index('trt_taxa_id');
			$table->integer('trt_estado')->index('trt_estado');
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
		Schema::drop('taxaartigos');
	}

}
