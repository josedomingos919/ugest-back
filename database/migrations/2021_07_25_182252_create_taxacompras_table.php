<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaxacomprasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('taxacompras', function(Blueprint $table)
		{
			$table->integer('tcm_id', true);
			$table->integer('tcm_historicoStock_id')->index('tcm_historicoStock_id');
			$table->integer('tcm_taxa_id')->index('tcm_taxa_id');
			$table->integer('tcm_estado')->index('tcm_estado');
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
		Schema::drop('taxacompras');
	}

}
