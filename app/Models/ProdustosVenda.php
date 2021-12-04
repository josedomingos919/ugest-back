<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdustosVenda extends Model
{
    use HasFactory;

    protected $table = 'produstosvenda';
    protected $primaryKey = 'id';
    //  public $timestamps = false;

    protected $fillable = [
        'id',
        'prod_venda_id',
        'prod_art_id',
        'prod_quantidade',
        'prod_total',
        'prod_preco',
        'created_at',
        'updated_at',
    ];
}
