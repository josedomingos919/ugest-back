<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Venda
 *
 * @property int $ven_id
 * @property float $ven_total
 * @property int $ven_quantidade
 * @property float $ven_troco
 * @property float $ven_valor_pago
 * @property int $ven_cliente_id
 * @property int $ven_estado
 * @property string|null $ven_descricao
 * @property Carbon $ven_data_venda
 * @property Carbon $ven_data_registrar
 *
 * @property Pessoa $pessoa
 * @property Artigo $artigo
 * @property Estado $estado
 * @property Collection|Taxa[] $taxas
 *
 * @package App\Models
 */
class Venda extends Model
{
    protected $table = 'vendas';
    protected $primaryKey = 'ven_id';
    public $timestamps = false;

    protected $casts = [
        'ven_total' => 'float',
        'ven_quantidade' => 'int',
        'ven_troco' => 'float',
        'ven_valor_pago' => 'float',
        'ven_cliente_id' => 'int',
        'ven_estado' => 'int',
    ];

    protected $dates = ['ven_data_venda', 'ven_data_registrar'];

    protected $fillable = [
        'ven_total',
        'ven_quantidade',
        'ven_troco',
        'ven_valor_pago',
        'ven_cliente_id',
        'ven_estado',
        'ven_descricao',
        'ven_data_venda',
        'ven_data_registrar',
    ];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'ven_cliente_id');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'ven_estado');
    }

    public function taxas()
    {
        return $this->belongsToMany(
            Taxa::class,
            'taxavendas',
            'tvn_venda_id',
            'tvn_taxa_id'
        )->withPivot(
            'tvn_id',
            'tvn_estado',
            'tvn_artigo_id',
            'tvn_percentagem',
            'tvn_valor',
            'tvn_data_registrar',
            'tvn_descricao'
        );
    }
}
