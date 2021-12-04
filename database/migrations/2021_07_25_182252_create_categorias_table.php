<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoriasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('categorias', function(Blueprint $table)
		{
			$table->integer('catg_id', true);
			$table->string('catg_designacao', 100)->unique('catg_designacao');
			$table->integer('catg_subcategoria_id')->nullable()->index('catg_subcategoria_id');
			$table->integer('catg_estado_id')->index('catg_estado_id');
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
		Schema::drop('categorias');
	}

}
