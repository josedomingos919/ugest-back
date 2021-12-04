<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Categoria
 * 
 * @property int $catg_id
 * @property string $catg_designacao
 * @property int|null $catg_subcategoria_id
 * @property int $catg_estado_id
 * 
 * @property Subcategoria|null $subcategoria
 * @property Estado $estado
 *
 * @package App\Models
 */
class Categoria extends Model
{
	protected $table = 'categorias';
	protected $primaryKey = 'catg_id';
	public $timestamps = false;

	protected $casts = [
		'catg_subcategoria_id' => 'int',
		'catg_estado_id' => 'int'
	];

	protected $fillable = [
		'catg_designacao',
		'catg_subcategoria_id',
		'catg_estado_id'
	];

	public function subcategoria()
	{
		return $this->belongsTo(Subcategoria::class, 'catg_subcategoria_id');
	}

	public function estado()
	{
		return $this->belongsTo(Estado::class, 'catg_estado_id');
	}
}
