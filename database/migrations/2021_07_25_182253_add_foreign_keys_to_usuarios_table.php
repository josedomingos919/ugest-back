<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToUsuariosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('usuarios', function(Blueprint $table)
		{
			$table->foreign('usu_nivelAcesso_id', 'usuario_ibfk_1')->references('niv_id')->on('nivelacessos')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('usu_estado_id', 'usuario_ibfk_2')->references('est_id')->on('estados')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('usuarios', function(Blueprint $table)
		{
			$table->dropForeign('usuario_ibfk_1');
			$table->dropForeign('usuario_ibfk_2');
		});
	}

}
