<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTaxaartigosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('taxaartigos', function(Blueprint $table)
		{
			$table->foreign('trt_art_id', 'taxaArtigo_ibfk_1')->references('art_id')->on('artigos')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('trt_taxa_id', 'taxaArtigo_ibfk_2')->references('tax_id')->on('taxas')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('trt_estado', 'taxaArtigo_ibfk_3')->references('est_id')->on('estados')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('taxaartigos', function(Blueprint $table)
		{
			$table->dropForeign('taxaArtigo_ibfk_1');
			$table->dropForeign('taxaArtigo_ibfk_2');
			$table->dropForeign('taxaArtigo_ibfk_3');
		});
	}

}
