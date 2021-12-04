<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePapelpessoasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('papelpessoas', function(Blueprint $table)
		{
			$table->integer('ppa_id', true);
			$table->string('ppa_designacao', 100);
			$table->enum('ppa_principal', array('true','false'))->default('false');
			$table->integer('ppa_estado_id')->index('ppa_estado_id');
			$table->integer('ppa_pessoa_id')->index('ppa_pessoa_id');
			$table->integer('ppa_papel_id')->index('ppa_papel_id');
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
		Schema::drop('papelpessoas');
	}

}
