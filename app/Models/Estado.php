<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Estado
 *
 * @property int $est_id
 * @property string $est_designacao
 * @property Carbon|null $est_data_criacao
 *
 * @property Collection|Artigo[] $artigos
 * @property Collection|Categoria[] $categorias
 * @property Collection|Contacto[] $contactos
 * @property Collection|Endereco[] $enderecos
 * @property Collection|Historicostock[] $historicostocks
 * @property Collection|Nivelacesso[] $nivelacessos
 * @property Collection|Papei[] $papeis
 * @property Collection|Papelpessoa[] $papelpessoas
 * @property Collection|Permicoesniveltable[] $permicoesniveltables
 * @property Collection|Pessoa[] $pessoas
 * @property Collection|Subcategoria[] $subcategorias
 * @property Collection|Taxaartigo[] $taxaartigos
 * @property Collection|Taxacompra[] $taxacompras
 * @property Collection|Taxa[] $taxas
 * @property Collection|Taxavenda[] $taxavendas
 * @property Collection|Tipoartigo[] $tipoartigos
 * @property Collection|Usuario[] $usuarios
 * @property Collection|Venda[] $vendas
 *
 * @package App\Models
 */
class Estado extends Model
{
	protected $table = 'estados';
	protected $primaryKey = 'est_id';
	public $timestamps = false;

    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';

	protected $dates = [
		'est_data_criacao'
	];

	protected $fillable = [
		'est_designacao',
		'est_data_criacao'
	];

	public function artigos()
	{
		return $this->hasMany(Artigo::class, 'art_estado_id');
	}

	public function categorias()
	{
		return $this->hasMany(Categoria::class, 'catg_estado_id');
	}

	public function contactos()
	{
		return $this->hasMany(Contacto::class, 'cont_estado_id');
	}

	public function enderecos()
	{
		return $this->hasMany(Endereco::class, 'end_estado_id');
	}

	public function historicostocks()
	{
		return $this->hasMany(Historicostock::class, 'hst_estado');
	}

	public function nivelacessos()
	{
		return $this->hasMany(Nivelacesso::class, 'niv_estado_id');
	}

	public function papeis()
	{
		return $this->hasMany(Papei::class, 'pap_estado_id');
	}

	public function papelpessoas()
	{
		return $this->hasMany(Papelpessoa::class, 'ppa_estado_id');
	}

	public function permicoesniveltables()
	{
		return $this->hasMany(Permicoesniveltable::class, 'pnt_estado_id');
	}

	public function pessoas()
	{
		return $this->hasMany(Pessoa::class, 'pes_estado_id');
	}

	public function subcategorias()
	{
		return $this->hasMany(Subcategoria::class, 'scat_estado_id');
	}

	public function taxaartigos()
	{
		return $this->hasMany(Taxaartigo::class, 'trt_estado');
	}

	public function taxacompras()
	{
		return $this->hasMany(Taxacompra::class, 'tcm_estado');
	}

	public function taxas()
	{
		return $this->hasMany(Taxa::class, 'tax_estado');
	}

	public function taxavendas()
	{
		return $this->hasMany(Taxavenda::class, 'tvn_estado');
	}

	public function tipoartigos()
	{
		return $this->hasMany(Tipoartigo::class, 'tip_estado_id');
	}

	public function usuarios()
	{
		return $this->hasMany(Usuario::class, 'usu_estado_id');
	}

	public function vendas()
	{
		return $this->hasMany(Venda::class, 'ven_estado');
	}
}
