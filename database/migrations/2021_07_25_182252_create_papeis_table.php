<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePapeisTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('papeis', function(Blueprint $table)
		{
			$table->integer('pap_id', true);
			$table->string('pap_designacao', 100);
			$table->integer('pap_estado_id')->index('pap_estado_id');
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
		Schema::drop('papeis');
	}

}
