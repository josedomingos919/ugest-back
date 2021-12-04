<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendas', function (Blueprint $table) {
            $table->integer('ven_id', true);
            $table->float('ven_total', 10, 0)->default(0);
            $table->integer('ven_quantidade')->default(0);
            $table->float('ven_troco', 10, 0)->default(0);
            $table->float('ven_valor_pago', 10, 0)->default(0);
            $table->integer('ven_cliente_id')->index('ven_cliente_id');
            $table->integer('ven_estado')->index('ven_estado');
            $table->text('code');
            $table->text('ven_descricao', 65535)->nullable();
            $table
                ->timestamp('ven_data_venda')
                ->default(DB::raw('CURRENT_TIMESTAMP'));
            $table
                ->timestamp('ven_data_registrar')
                ->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('vendas');
    }
}
