<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToNivelacessosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('nivelacessos', function(Blueprint $table)
		{
			$table->foreign('niv_estado_id', 'nivelAcesso_ibfk_1')->references('est_id')->on('estados')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('nivelacessos', function(Blueprint $table)
		{
			$table->dropForeign('nivelAcesso_ibfk_1');
		});
	}

}
