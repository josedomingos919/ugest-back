<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Artigo
 *
 * @property int $art_id
 * @property string $art_designacao
 * @property int $art_estado_id
 * @property int $art_tipoArtigo_id
 * @property int|null $art_stock_minimo
 * @property int|null $art_stock_real
 *
 * @property Estado $estado
 * @property Collection|Taxa[] $taxas
 * @property Collection|Taxavenda[] $taxavendas
 * @property Collection|Venda[] $vendas
 *
 * @package App\Models
 */
class Artigo extends Model
{
    protected $table = 'artigos';
    protected $primaryKey = 'art_id';
    public $timestamps = false;

    protected $casts = [
        'art_estado_id' => 'int',
        'art_tipoArtigo_id' => 'int',
        'art_stock_minimo' => 'int',
        'art_stock_real' => 'int',
        'art_preco' => 'double',
        'art_imagem' => 'string',
    ];

    protected $fillable = [
        'art_designacao',
        'art_estado_id',
        'art_tipoArtigo_id',
        'art_stock_minimo',
        'art_stock_real',
        'art_preco' => 'double',
        'art_imagem',
    ];

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'art_estado_id');
    }

    public function taxas()
    {
        return $this->belongsToMany(
            Taxa::class,
            'taxaartigos',
            'trt_art_id',
            'trt_taxa_id'
        )->withPivot('trt_id', 'trt_estado');
    }

    public function taxavendas()
    {
        return $this->hasMany(Taxavenda::class, 'tvn_artigo_id');
    }
}
