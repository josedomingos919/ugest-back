<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Taxaartigo
 * 
 * @property int $trt_id
 * @property int $trt_art_id
 * @property int $trt_taxa_id
 * @property int $trt_estado
 * 
 * @property Artigo $artigo
 * @property Taxa $taxa
 * @property Estado $estado
 *
 * @package App\Models
 */
class Taxaartigo extends Model
{
	protected $table = 'taxaartigos';
	protected $primaryKey = 'trt_id';
	public $timestamps = false;

	protected $casts = [
		'trt_art_id' => 'int',
		'trt_taxa_id' => 'int',
		'trt_estado' => 'int'
	];

	protected $fillable = [
		'trt_art_id',
		'trt_taxa_id',
		'trt_estado'
	];

	public function artigo()
	{
		return $this->belongsTo(Artigo::class, 'trt_art_id');
	}

	public function taxa()
	{
		return $this->belongsTo(Taxa::class, 'trt_taxa_id');
	}

	public function estado()
	{
		return $this->belongsTo(Estado::class, 'trt_estado');
	}
}
