<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToHistoricostocksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('historicostocks', function(Blueprint $table)
		{
			$table->foreign('hst_estado', 'historicoStock_ibfk_1')->references('est_id')->on('estados')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('historicostocks', function(Blueprint $table)
		{
			$table->dropForeign('historicoStock_ibfk_1');
		});
	}

}
