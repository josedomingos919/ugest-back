<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTipoartigosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tipoartigos', function(Blueprint $table)
		{
			$table->integer('tip_id', true);
			$table->string('tip_designacao', 45);
			$table->integer('tip_estado_id')->index('tip_estado_id');
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
		Schema::drop('tipoartigos');
	}

}
