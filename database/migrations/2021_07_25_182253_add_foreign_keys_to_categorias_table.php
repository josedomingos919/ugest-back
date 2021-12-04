<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCategoriasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('categorias', function(Blueprint $table)
		{
			$table->foreign('catg_subcategoria_id', 'categoria_ibfk_1')->references('scat_id')->on('subcategorias')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('catg_estado_id', 'categoria_ibfk_2')->references('est_id')->on('estados')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('categorias', function(Blueprint $table)
		{
			$table->dropForeign('categoria_ibfk_1');
			$table->dropForeign('categoria_ibfk_2');
		});
	}

}
