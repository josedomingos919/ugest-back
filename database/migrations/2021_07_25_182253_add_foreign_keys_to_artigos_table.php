<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToArtigosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('artigos', function(Blueprint $table)
		{
			$table->foreign('art_estado_id', 'artigo_ibfk_1')->references('est_id')->on('estados')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('art_estado_id', 'artigo_ibfk_2')->references('est_id')->on('estados')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('artigos', function(Blueprint $table)
		{
			$table->dropForeign('artigo_ibfk_1');
			$table->dropForeign('artigo_ibfk_2');
		});
	}

}
