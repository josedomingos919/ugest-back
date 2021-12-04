<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Subcategoria
 * 
 * @property int $scat_id
 * @property string $scat_designacao
 * @property int $scat_estado_id
 * 
 * @property Estado $estado
 * @property Collection|Categoria[] $categorias
 *
 * @package App\Models
 */
class Subcategoria extends Model
{
	protected $table = 'subcategorias';
	protected $primaryKey = 'scat_id';
	public $timestamps = false;

	protected $casts = [
		'scat_estado_id' => 'int'
	];

	protected $fillable = [
		'scat_designacao',
		'scat_estado_id'
	];

	public function estado()
	{
		return $this->belongsTo(Estado::class, 'scat_estado_id');
	}

	public function categorias()
	{
		return $this->hasMany(Categoria::class, 'catg_subcategoria_id');
	}
}
