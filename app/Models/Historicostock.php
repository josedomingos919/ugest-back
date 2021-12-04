<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Historicostock
 * 
 * @property int $hst_id
 * @property string $hst_tipo
 * @property int $hst_quantidade
 * @property Carbon $hst_data_entrada
 * @property float $hst_preco_compra
 * @property Carbon|null $hst_data_regitro
 * @property int $hst_estado
 * 
 * @property Estado $estado
 * @property Collection|Taxacompra[] $taxacompras
 *
 * @package App\Models
 */
class Historicostock extends Model
{
	protected $table = 'historicostocks';
	protected $primaryKey = 'hst_id';
	public $timestamps = false;

	protected $casts = [
		'hst_quantidade' => 'int',
		'hst_preco_compra' => 'float',
		'hst_estado' => 'int'
	];

	protected $dates = [
		'hst_data_entrada',
		'hst_data_regitro'
	];

	protected $fillable = [
		'hst_tipo',
		'hst_quantidade',
		'hst_data_entrada',
		'hst_preco_compra',
		'hst_data_regitro',
		'hst_estado'
	];

	public function estado()
	{
		return $this->belongsTo(Estado::class, 'hst_estado');
	}

	public function taxacompras()
	{
		return $this->hasMany(Taxacompra::class, 'tcm_historicoStock_id');
	}
}
