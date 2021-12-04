<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contactos', function(Blueprint $table)
		{
			$table->integer('cont_id', true);
			$table->string('cont_email', 100)->nullable();
			$table->string('cont_fax', 100)->nullable();
			$table->string('cont_telefone', 100)->nullable();
			$table->string('cont_telemovel', 100);
			$table->enum('cont_principal', array('true','false'))->default('false');
			$table->integer('cont_estado_id')->index('cont_estado_id');
			$table->integer('cont_pessoa_id')->index('cont_pessoa_id');
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
		Schema::drop('contactos');
	}

}
