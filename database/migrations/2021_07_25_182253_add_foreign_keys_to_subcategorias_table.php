<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToSubcategoriasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('subcategorias', function(Blueprint $table)
		{
			$table->foreign('scat_estado_id', 'subcategoria_ibfk_1')->references('est_id')->on('estados')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('subcategorias', function(Blueprint $table)
		{
			$table->dropForeign('subcategoria_ibfk_1');
		});
	}

}
