<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaxavendasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('taxavendas', function(Blueprint $table)
		{
			$table->integer('tvn_id', true);
			$table->integer('tvn_estado')->index('tvn_estado');
			$table->integer('tvn_venda_id')->nullable()->index('tvn_venda_id');
			$table->integer('tvn_artigo_id')->nullable()->index('tvn_artigo_id');
			$table->integer('tvn_taxa_id')->nullable()->index('tvn_taxa_id');
			$table->float('tvn_percentagem', 10, 0)->nullable();
			$table->float('tvn_valor', 10, 0)->nullable();
			$table->timestamp('tvn_data_registrar')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->text('tvn_descricao', 65535)->nullable();
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
		Schema::drop('taxavendas');
	}

}
