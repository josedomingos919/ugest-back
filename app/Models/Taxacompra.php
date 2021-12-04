<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Taxacompra
 * 
 * @property int $tcm_id
 * @property int $tcm_historicoStock_id
 * @property int $tcm_taxa_id
 * @property int $tcm_estado
 * 
 * @property Historicostock $historicostock
 * @property Taxa $taxa
 * @property Estado $estado
 *
 * @package App\Models
 */
class Taxacompra extends Model
{
	protected $table = 'taxacompras';
	protected $primaryKey = 'tcm_id';
	public $timestamps = false;

	protected $casts = [
		'tcm_historicoStock_id' => 'int',
		'tcm_taxa_id' => 'int',
		'tcm_estado' => 'int'
	];

	protected $fillable = [
		'tcm_historicoStock_id',
		'tcm_taxa_id',
		'tcm_estado'
	];

	public function historicostock()
	{
		return $this->belongsTo(Historicostock::class, 'tcm_historicoStock_id');
	}

	public function taxa()
	{
		return $this->belongsTo(Taxa::class, 'tcm_taxa_id');
	}

	public function estado()
	{
		return $this->belongsTo(Estado::class, 'tcm_estado');
	}
}
