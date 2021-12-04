<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePermicoesniveltablesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('permicoesniveltables', function(Blueprint $table)
		{
			$table->integer('pnt_id', true);
			$table->enum('pnt_ler', array('sim','não'))->nullable()->default('sim');
			$table->enum('pnt_escrever', array('sim','não'))->nullable()->default('sim');
			$table->enum('pnt_eliminar', array('sim','não'))->nullable()->default('não');
			$table->integer('pnt_nivelAcesso_id')->index('pnt_nivelAcesso_id');
			$table->integer('pnt_estado_id')->index('pnt_estado_id');
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
		Schema::drop('permicoesniveltables');
	}

}
