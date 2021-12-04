<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Taxavenda
 * 
 * @property int $tvn_id
 * @property int $tvn_estado
 * @property int|null $tvn_venda_id
 * @property int|null $tvn_artigo_id
 * @property int|null $tvn_taxa_id
 * @property float|null $tvn_percentagem
 * @property float|null $tvn_valor
 * @property Carbon $tvn_data_registrar
 * @property string|null $tvn_descricao
 * 
 * @property Artigo|null $artigo
 * @property Taxa|null $taxa
 * @property Venda|null $venda
 * @property Estado $estado
 *
 * @package App\Models
 */
class Taxavenda extends Model
{
	protected $table = 'taxavendas';
	protected $primaryKey = 'tvn_id';
	public $timestamps = false;

	protected $casts = [
		'tvn_estado' => 'int',
		'tvn_venda_id' => 'int',
		'tvn_artigo_id' => 'int',
		'tvn_taxa_id' => 'int',
		'tvn_percentagem' => 'float',
		'tvn_valor' => 'float'
	];

	protected $dates = [
		'tvn_data_registrar'
	];

	protected $fillable = [
		'tvn_estado',
		'tvn_venda_id',
		'tvn_artigo_id',
		'tvn_taxa_id',
		'tvn_percentagem',
		'tvn_valor',
		'tvn_data_registrar',
		'tvn_descricao'
	];

	public function artigo()
	{
		return $this->belongsTo(Artigo::class, 'tvn_artigo_id');
	}

	public function taxa()
	{
		return $this->belongsTo(Taxa::class, 'tvn_taxa_id');
	}

	public function venda()
	{
		return $this->belongsTo(Venda::class, 'tvn_venda_id');
	}

	public function estado()
	{
		return $this->belongsTo(Estado::class, 'tvn_estado');
	}
}
