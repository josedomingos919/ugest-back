<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Papelpessoa
 * 
 * @property int $ppa_id
 * @property string $ppa_designacao
 * @property string $ppa_principal
 * @property int $ppa_estado_id
 * @property int $ppa_pessoa_id
 * @property int $ppa_papel_id
 * 
 * @property Papei $papei
 * @property Pessoa $pessoa
 * @property Estado $estado
 *
 * @package App\Models
 */
class Papelpessoa extends Model
{
	protected $table = 'papelpessoas';
	protected $primaryKey = 'ppa_id';
	public $timestamps = false;

	protected $casts = [
		'ppa_estado_id' => 'int',
		'ppa_pessoa_id' => 'int',
		'ppa_papel_id' => 'int'
	];

	protected $fillable = [
		'ppa_designacao',
		'ppa_principal',
		'ppa_estado_id',
		'ppa_pessoa_id',
		'ppa_papel_id'
	];

	public function papei()
	{
		return $this->belongsTo(Papei::class, 'ppa_papel_id');
	}

	public function pessoa()
	{
		return $this->belongsTo(Pessoa::class, 'ppa_pessoa_id');
	}

	public function estado()
	{
		return $this->belongsTo(Estado::class, 'ppa_estado_id');
	}
}
