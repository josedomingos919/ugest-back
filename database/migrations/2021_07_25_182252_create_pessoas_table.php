<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePessoasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pessoas', function(Blueprint $table)
		{
			$table->integer('pes_id', true);
			$table->string('pes_nome', 100);
			$table->string('pes_nif', 100)->unique('pes_nif');
			$table->enum('pes_genero', array('masculino','feminino'))->nullable();
			$table->enum('pes_estado_civil', array('casado/a','solteiro/a','viuvo/a'))->nullable();
			$table->integer('pes_estado_id')->index('pes_estado_id');
			$table->date('pes_data_nascimento')->nullable();
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
		Schema::drop('pessoas');
	}

}
