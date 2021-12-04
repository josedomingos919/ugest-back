<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Contacto
 * 
 * @property int $cont_id
 * @property string|null $cont_email
 * @property string|null $cont_fax
 * @property string|null $cont_telefone
 * @property string $cont_telemovel
 * @property string $cont_principal
 * @property int $cont_estado_id
 * @property int $cont_pessoa_id
 * 
 * @property Pessoa $pessoa
 * @property Estado $estado
 *
 * @package App\Models
 */
class Contacto extends Model
{
	protected $table = 'contactos';
	protected $primaryKey = 'cont_id';
	public $timestamps = false;

	protected $casts = [
		'cont_estado_id' => 'int',
		'cont_pessoa_id' => 'int'
	];

	protected $fillable = [
		'cont_email',
		'cont_fax',
		'cont_telefone',
		'cont_telemovel',
		'cont_principal',
		'cont_estado_id',
		'cont_pessoa_id'
	];

	public function pessoa()
	{
		return $this->belongsTo(Pessoa::class, 'cont_pessoa_id');
	}

	public function estado()
	{
		return $this->belongsTo(Estado::class, 'cont_estado_id');
	}
}
