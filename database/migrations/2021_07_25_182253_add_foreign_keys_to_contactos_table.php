<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToContactosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('contactos', function(Blueprint $table)
		{
			$table->foreign('cont_pessoa_id', 'contacto_ibfk_1')->references('pes_id')->on('pessoas')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('cont_estado_id', 'contacto_ibfk_2')->references('est_id')->on('estados')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('contactos', function(Blueprint $table)
		{
			$table->dropForeign('contacto_ibfk_1');
			$table->dropForeign('contacto_ibfk_2');
		});
	}

}
