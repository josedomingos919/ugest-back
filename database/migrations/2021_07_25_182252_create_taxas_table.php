<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaxasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('taxas', function(Blueprint $table)
		{
			$table->integer('tax_id', true);
			$table->enum('tax_tipo', array('imposto','encargo','desconto'));
			$table->string('tax_descricao', 100);
			$table->float('tax_preco', 10, 0)->nullable()->default(0);
			$table->float('tax_percentagem', 10, 0)->nullable()->default(0);
			$table->timestamp('tax_data_regitro')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->integer('tax_estado')->index('tax_estado');
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
		Schema::drop('taxas');
	}

}
