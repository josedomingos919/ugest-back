<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Nivelacesso
 * 
 * @property int $niv_id
 * @property string $niv_designacao
 * @property int $niv_estado_id
 * 
 * @property Estado $estado
 * @property Collection|Permicoesniveltable[] $permicoesniveltables
 * @property Collection|Usuario[] $usuarios
 *
 * @package App\Models
 */
class Nivelacesso extends Model
{
	protected $table = 'nivelacessos';
	protected $primaryKey = 'niv_id';
	public $timestamps = false;

	protected $casts = [
		'niv_estado_id' => 'int'
	];

	protected $fillable = [
		'niv_designacao',
		'niv_estado_id'
	];

	public function estado()
	{
		return $this->belongsTo(Estado::class, 'niv_estado_id');
	}

	public function permicoesniveltables()
	{
		return $this->hasMany(Permicoesniveltable::class, 'pnt_nivelAcesso_id');
	}

	public function usuarios()
	{
		return $this->hasMany(Usuario::class, 'usu_nivelAcesso_id');
	}
}
