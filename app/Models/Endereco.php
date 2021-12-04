<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Endereco
 * 
 * @property int $end_id
 * @property string $end_morada
 * @property string|null $end_localidade
 * @property string|null $end_codigo_postal
 * @property float|null $end_latitude
 * @property float|null $end_longitude
 * @property string $end_principal
 * @property int $end_estado_id
 * @property int $end_pessoa_id
 * 
 * @property Pessoa $pessoa
 * @property Estado $estado
 *
 * @package App\Models
 */
class Endereco extends Model
{
	protected $table = 'enderecos';
	protected $primaryKey = 'end_id';
	public $timestamps = false;

	protected $casts = [
		'end_latitude' => 'float',
		'end_longitude' => 'float',
		'end_estado_id' => 'int',
		'end_pessoa_id' => 'int'
	];

	protected $fillable = [
		'end_morada',
		'end_localidade',
		'end_codigo_postal',
		'end_latitude',
		'end_longitude',
		'end_principal',
		'end_estado_id',
		'end_pessoa_id'
	];

	public function pessoa()
	{
		return $this->belongsTo(Pessoa::class, 'end_pessoa_id');
	}

	public function estado()
	{
		return $this->belongsTo(Estado::class, 'end_estado_id');
	}
}
