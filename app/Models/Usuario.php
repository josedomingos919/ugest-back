<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Usuario
 * 
 * @property int $usu_id
 * @property string $usu_username
 * @property string $usu_password
 * @property int $usu_pessoa_id
 * @property int $usu_nivelAcesso_id
 * @property int $usu_estado_id
 * 
 * @property Nivelacesso $nivelacesso
 * @property Estado $estado
 *
 * @package App\Models
 */
class Usuario extends Model
{
	protected $table = 'usuarios';
	protected $primaryKey = 'usu_id';
	public $timestamps = false;

	protected $casts = [
		'usu_pessoa_id' => 'int',
		'usu_nivelAcesso_id' => 'int',
		'usu_estado_id' => 'int'
	];

	protected $hidden = [
		'usu_password'
	];

	protected $fillable = [
		'usu_username',
		'usu_password',
		'usu_pessoa_id',
		'usu_nivelAcesso_id',
		'usu_estado_id'
	];

	public function nivelacesso()
	{
		return $this->belongsTo(Nivelacesso::class, 'usu_nivelAcesso_id');
	}

	public function estado()
	{
		return $this->belongsTo(Estado::class, 'usu_estado_id');
	}
}
