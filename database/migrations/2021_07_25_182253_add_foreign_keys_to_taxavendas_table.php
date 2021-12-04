<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTaxavendasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('taxavendas', function(Blueprint $table)
		{
			$table->foreign('tvn_artigo_id', 'taxaVenda_ibfk_1')->references('art_id')->on('artigos')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('tvn_taxa_id', 'taxaVenda_ibfk_2')->references('tax_id')->on('taxas')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('tvn_venda_id', 'taxaVenda_ibfk_3')->references('ven_id')->on('vendas')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('tvn_estado', 'taxaVenda_ibfk_4')->references('est_id')->on('estados')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('taxavendas', function(Blueprint $table)
		{
			$table->dropForeign('taxaVenda_ibfk_1');
			$table->dropForeign('taxaVenda_ibfk_2');
			$table->dropForeign('taxaVenda_ibfk_3');
			$table->dropForeign('taxaVenda_ibfk_4');
		});
	}

}
