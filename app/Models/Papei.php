<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Papei
 * 
 * @property int $pap_id
 * @property string $pap_designacao
 * @property int $pap_estado_id
 * 
 * @property Estado $estado
 * @property Collection|Papelpessoa[] $papelpessoas
 *
 * @package App\Models
 */
class Papei extends Model
{
	protected $table = 'papeis';
	protected $primaryKey = 'pap_id';
	public $timestamps = false;

	protected $casts = [
		'pap_estado_id' => 'int'
	];

	protected $fillable = [
		'pap_designacao',
		'pap_estado_id'
	];

	public function estado()
	{
		return $this->belongsTo(Estado::class, 'pap_estado_id');
	}

	public function papelpessoas()
	{
		return $this->hasMany(Papelpessoa::class, 'ppa_papel_id');
	}
}
