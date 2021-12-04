<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPapelpessoasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('papelpessoas', function(Blueprint $table)
		{
			$table->foreign('ppa_papel_id', 'papelPessoa_ibfk_1')->references('pap_id')->on('papeis')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('ppa_pessoa_id', 'papelPessoa_ibfk_2')->references('pes_id')->on('pessoas')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('ppa_estado_id', 'papelPessoa_ibfk_3')->references('est_id')->on('estados')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('papelpessoas', function(Blueprint $table)
		{
			$table->dropForeign('papelPessoa_ibfk_1');
			$table->dropForeign('papelPessoa_ibfk_2');
			$table->dropForeign('papelPessoa_ibfk_3');
		});
	}

}
