<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Permicoesniveltable
 * 
 * @property int $pnt_id
 * @property string|null $pnt_ler
 * @property string|null $pnt_escrever
 * @property string|null $pnt_eliminar
 * @property int $pnt_nivelAcesso_id
 * @property int $pnt_estado_id
 * 
 * @property Nivelacesso $nivelacesso
 * @property Estado $estado
 *
 * @package App\Models
 */
class Permicoesniveltable extends Model
{
	protected $table = 'permicoesniveltables';
	protected $primaryKey = 'pnt_id';
	public $timestamps = false;

	protected $casts = [
		'pnt_nivelAcesso_id' => 'int',
		'pnt_estado_id' => 'int'
	];

	protected $fillable = [
		'pnt_ler',
		'pnt_escrever',
		'pnt_eliminar',
		'pnt_nivelAcesso_id',
		'pnt_estado_id'
	];

	public function nivelacesso()
	{
		return $this->belongsTo(Nivelacesso::class, 'pnt_nivelAcesso_id');
	}

	public function estado()
	{
		return $this->belongsTo(Estado::class, 'pnt_estado_id');
	}
}
