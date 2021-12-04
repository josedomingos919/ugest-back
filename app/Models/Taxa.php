<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Taxa
 * 
 * @property int $tax_id
 * @property string $tax_tipo
 * @property string $tax_descricao
 * @property float|null $tax_preco
 * @property float|null $tax_percentagem
 * @property Carbon|null $tax_data_regitro
 * @property int $tax_estado
 * 
 * @property Estado $estado
 * @property Collection|Artigo[] $artigos
 * @property Collection|Taxacompra[] $taxacompras
 * @property Collection|Venda[] $vendas
 *
 * @package App\Models
 */
class Taxa extends Model
{
	protected $table = 'taxas';
	protected $primaryKey = 'tax_id';
	public $timestamps = false;

	protected $casts = [
		'tax_preco' => 'float',
		'tax_percentagem' => 'float',
		'tax_estado' => 'int'
	];

	protected $dates = [
		'tax_data_regitro'
	];

	protected $fillable = [
		'tax_tipo',
		'tax_descricao',
		'tax_preco',
		'tax_percentagem',
		'tax_data_regitro',
		'tax_estado'
	];

	public function estado()
	{
		return $this->belongsTo(Estado::class, 'tax_estado');
	}

	public function artigos()
	{
		return $this->belongsToMany(Artigo::class, 'taxaartigos', 'trt_taxa_id', 'trt_art_id')
					->withPivot('trt_id', 'trt_estado');
	}

	public function taxacompras()
	{
		return $this->hasMany(Taxacompra::class, 'tcm_taxa_id');
	}

	public function vendas()
	{
		return $this->belongsToMany(Venda::class, 'taxavendas', 'tvn_taxa_id', 'tvn_venda_id')
					->withPivot('tvn_id', 'tvn_estado', 'tvn_artigo_id', 'tvn_percentagem', 'tvn_valor', 'tvn_data_registrar', 'tvn_descricao');
	}
}
