<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tipoartigo
 * 
 * @property int $tip_id
 * @property string $tip_designacao
 * @property int $tip_estado_id
 * 
 * @property Estado $estado
 *
 * @package App\Models
 */
class Tipoartigo extends Model
{
	protected $table = 'tipoartigos';
	protected $primaryKey = 'tip_id';
	public $timestamps = false;

	protected $casts = [
		'tip_estado_id' => 'int'
	];

	protected $fillable = [
		'tip_designacao',
		'tip_estado_id'
	];

	public function estado()
	{
		return $this->belongsTo(Estado::class, 'tip_estado_id');
	}
}
