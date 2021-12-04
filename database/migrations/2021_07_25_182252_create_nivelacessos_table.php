<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNivelacessosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('nivelacessos', function(Blueprint $table)
		{
			$table->integer('niv_id', true);
			$table->string('niv_designacao', 100);
			$table->integer('niv_estado_id')->index('niv_estado_id');
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
		Schema::drop('nivelacessos');
	}

}
