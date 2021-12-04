<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHistoricostocksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('historicostocks', function(Blueprint $table)
		{
			$table->integer('hst_id', true);
			$table->enum('hst_tipo', array('Entrada','Saida','Saida Stock Minimo','Quebra'));
			$table->integer('hst_quantidade')->default(0);
			$table->dateTime('hst_data_entrada');
			$table->float('hst_preco_compra', 10, 0);
			$table->timestamp('hst_data_regitro')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->integer('hst_estado')->index('hst_estado');
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
		Schema::drop('historicostocks');
	}

}
