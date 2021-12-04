<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToVendasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('vendas', function(Blueprint $table)
		{
			$table->foreign('ven_cliente_id', 'venda_ibfk_1')->references('pes_id')->on('pessoas')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('ven_art_id', 'venda_ibfk_2')->references('art_id')->on('artigos')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('ven_estado', 'venda_ibfk_3')->references('est_id')->on('estados')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('vendas', function(Blueprint $table)
		{
			$table->dropForeign('venda_ibfk_1');
			$table->dropForeign('venda_ibfk_2');
			$table->dropForeign('venda_ibfk_3');
		});
	}

}
