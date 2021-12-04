<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEnderecosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('enderecos', function(Blueprint $table)
		{
			$table->integer('end_id', true);
			$table->string('end_morada', 100);
			$table->string('end_localidade', 100)->nullable();
			$table->string('end_codigo_postal', 45)->nullable();
			$table->float('end_latitude', 10, 0)->nullable();
			$table->float('end_longitude', 10, 0)->nullable();
			$table->enum('end_principal', array('true','false'))->default('false');
			$table->integer('end_estado_id')->index('end_estado_id');
			$table->integer('end_pessoa_id')->index('end_pessoa_id');
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
		Schema::drop('enderecos');
	}

}
