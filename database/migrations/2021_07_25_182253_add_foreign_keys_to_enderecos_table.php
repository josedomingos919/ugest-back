<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToEnderecosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('enderecos', function(Blueprint $table)
		{
			$table->foreign('end_pessoa_id', 'endereco_ibfk_1')->references('pes_id')->on('pessoas')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('end_estado_id', 'endereco_ibfk_2')->references('est_id')->on('estados')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('enderecos', function(Blueprint $table)
		{
			$table->dropForeign('endereco_ibfk_1');
			$table->dropForeign('endereco_ibfk_2');
		});
	}

}
