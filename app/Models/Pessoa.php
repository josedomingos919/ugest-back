<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Pessoa
 * 
 * @property int $pes_id
 * @property string $pes_nome
 * @property string $pes_nif
 * @property string|null $pes_genero
 * @property string|null $pes_estado_civil
 * @property int $pes_estado_id
 * @property Carbon|null $pes_data_nascimento
 * 
 * @property Estado $estado
 * @property Collection|Contacto[] $contactos
 * @property Collection|Endereco[] $enderecos
 * @property Collection|Papelpessoa[] $papelpessoas
 * @property Collection|Venda[] $vendas
 *
 * @package App\Models
 */
class Pessoa extends Model
{
	protected $table = 'pessoas';
	protected $primaryKey = 'pes_id';
	public $timestamps = false;

	protected $casts = [
		'pes_estado_id' => 'int'
	];

	protected $dates = [
		'pes_data_nascimento'
	];

	protected $fillable = [
		'pes_nome',
		'pes_nif',
		'pes_genero',
		'pes_estado_civil',
		'pes_estado_id',
		'pes_data_nascimento'
	];

	public function estado()
	{
		return $this->belongsTo(Estado::class, 'pes_estado_id');
	}

	public function contactos()
	{
		return $this->hasMany(Contacto::class, 'cont_pessoa_id');
	}

	public function enderecos()
	{
		return $this->hasMany(Endereco::class, 'end_pessoa_id');
	}

	public function papelpessoas()
	{
		return $this->hasMany(Papelpessoa::class, 'ppa_pessoa_id');
	}

	public function vendas()
	{
		return $this->hasMany(Venda::class, 'ven_cliente_id');
	}
}
