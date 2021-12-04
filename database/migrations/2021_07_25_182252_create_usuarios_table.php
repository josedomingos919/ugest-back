<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsuariosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('usuarios', function(Blueprint $table)
		{
			$table->integer('usu_id', true);
			$table->string('usu_username', 45)->unique('usu_username');
			$table->string('usu_password', 100);
			$table->integer('usu_pessoa_id');
			$table->integer('usu_nivelAcesso_id')->index('usu_nivelAcesso_id');
			$table->integer('usu_estado_id')->index('usu_estado_id');
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
		Schema::drop('usuarios');
	}

}
