<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPapeisTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('papeis', function(Blueprint $table)
		{
			$table->foreign('pap_estado_id', 'papel_ibfk_1')->references('est_id')->on('estados')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('papeis', function(Blueprint $table)
		{
			$table->dropForeign('papel_ibfk_1');
		});
	}

}
