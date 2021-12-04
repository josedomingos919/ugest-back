<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTipoartigosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tipoartigos', function(Blueprint $table)
		{
			$table->foreign('tip_estado_id', 'tipoArtigo_ibfk_1')->references('est_id')->on('estados')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tipoartigos', function(Blueprint $table)
		{
			$table->dropForeign('tipoArtigo_ibfk_1');
		});
	}

}
