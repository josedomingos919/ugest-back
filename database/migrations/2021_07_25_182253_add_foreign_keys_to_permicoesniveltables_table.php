<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPermicoesniveltablesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('permicoesniveltables', function(Blueprint $table)
		{
			$table->foreign('pnt_nivelAcesso_id', 'permicoesNivelTable_ibfk_1')->references('niv_id')->on('nivelacessos')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('pnt_estado_id', 'permicoesNivelTable_ibfk_2')->references('est_id')->on('estados')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('permicoesniveltables', function(Blueprint $table)
		{
			$table->dropForeign('permicoesNivelTable_ibfk_1');
			$table->dropForeign('permicoesNivelTable_ibfk_2');
		});
	}

}
