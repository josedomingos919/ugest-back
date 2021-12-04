<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTaxacomprasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('taxacompras', function(Blueprint $table)
		{
			$table->foreign('tcm_historicoStock_id', 'taxaCompra_ibfk_1')->references('hst_id')->on('historicostocks')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('tcm_taxa_id', 'taxaCompra_ibfk_2')->references('tax_id')->on('taxas')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('tcm_estado', 'taxaCompra_ibfk_3')->references('est_id')->on('estados')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('taxacompras', function(Blueprint $table)
		{
			$table->dropForeign('taxaCompra_ibfk_1');
			$table->dropForeign('taxaCompra_ibfk_2');
			$table->dropForeign('taxaCompra_ibfk_3');
		});
	}

}
