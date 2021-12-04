<?php

use Illuminate\Http\Request;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\SubcategoriaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\TipoArtigoController;
use App\Http\Controllers\ArtigoController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\EnderecoController;
use App\Http\Controllers\HistoricoStockController;
use App\Http\Controllers\NivelAcessoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\TaxaController;
use App\Http\Controllers\ProdustosVendaController;
use App\Http\Controllers\VendaController;
use App\Http\Controllers\TaxaVendaController;
use App\Http\Controllers\TaxaCompraController;
use App\Http\Controllers\TaxaArtigoController;
use App\Http\Controllers\PapelController;
use App\Http\Controllers\PapelPessoaController;
use App\Http\Controllers\PermicoesNivelTablesController;
use App\Http\Controllers\AuthController;

//Rotas públicas
Route::post('/login', ['uses' => 'AuthController@login']);
Route::post('/logOut/{tokenId}', ['uses' => 'AuthController@logOut']);
Route::post('/logOutAll', ['uses' => 'AuthController@logOutAll']);

Route::post('/register', ['uses' => 'AuthController@register']);

//Rotas Privadas
Route::group(['middleware' => ['auth:sanctum']], function () {
    //Generate Saft
    Route::get('/saft-generate', ['uses' => 'SaftController@get']);

    //Criando Rotas de Venda
    Route::get('/fatura/{id}', ['uses' => 'VendaController@getFatNumber']);
    Route::get('/venda', ['uses' => 'VendaController@index']);
    Route::post('/venda', ['uses' => 'VendaController@store']);
    Route::get('/venda/{id}', ['uses' => 'VendaController@show']);
    Route::put('/venda/{id}', ['uses' => 'VendaController@update']);
    Route::delete('/venda/{id}', ['uses' => 'VendaController@destroy']);

    //ProdustosVendaController
    Route::get('/produstosvenda', ['uses' => 'ProdustosVendaController@index']);
    Route::post('/produstosvenda', [
        'uses' => 'ProdustosVendaController@store',
    ]);
    Route::get('/produstosvenda/{id}', [
        'uses' => 'ProdustosVendaController@show',
    ]);
    Route::put('/produstosvenda/{id}', [
        'uses' => 'ProdustosVendaController@update',
    ]);
    Route::delete('/produstosvenda/{id}', [
        'uses' => 'ProdustosVendaController@destroy',
    ]);

    //Criando Rotas de Estado
    Route::get('/estado', ['uses' => 'EstadoController@index']);
    Route::post('/estado', ['uses' => 'EstadoController@store']);
    Route::get('/estado/{id}', ['uses' => 'EstadoController@show']);
    Route::put('/estado/{id}', ['uses' => 'EstadoController@update']);
    Route::delete('/estado/{id}', ['uses' => 'EstadoController@destroy']);

    //Criando Rotas de Pessoa
    Route::get('/pessoa', ['uses' => 'PessoaController@index']);
    Route::post('/pessoa', ['uses' => 'PessoaController@store']);
    Route::get('/pessoa/{id}', ['uses' => 'PessoaController@show']);
    Route::get('/pessoa/bi/{bi}', ['uses' => 'PessoaController@showBI']);
    Route::put('/pessoa/{id}', ['uses' => 'PessoaController@update']);
    Route::delete('/pessoa/{id}', ['uses' => 'PessoaController@destroy']);

    //Criando Rotas de Subcategoria
    Route::get('/subcategoria', ['uses' => 'SubcategoriaController@index']);
    Route::post('/subcategoria', ['uses' => 'SubcategoriaController@store']);
    Route::get('/subcategoria/{id}', ['uses' => 'SubcategoriaController@show']);
    Route::put('/subcategoria/{id}', [
        'uses' => 'SubcategoriaController@update',
    ]);
    Route::delete('/subcategoria/{id}', [
        'uses' => 'SubcategoriaController@destroy',
    ]);

    //Criando Rotas de Categoria
    Route::get('/categoria', ['uses' => 'CategoriaController@index']);
    Route::post('/categoria', ['uses' => 'CategoriaController@store']);
    Route::get('/categoria/{id}', ['uses' => 'CategoriaController@show']);
    Route::put('/categoria/{id}', ['uses' => 'CategoriaController@update']);
    Route::delete('/categoria/{id}', ['uses' => 'CategoriaController@destroy']);

    //Criando Rotas de TipoArtigo
    Route::get('/tipoartigo', ['uses' => 'TipoArtigoController@index']);
    Route::post('/tipoartigo', ['uses' => 'TipoArtigoController@store']);
    Route::get('/tipoartigo/{id}', ['uses' => 'TipoArtigoController@show']);
    Route::put('/tipoartigo/{id}', ['uses' => 'TipoArtigoController@update']);
    Route::delete('/tipoartigo/{id}', [
        'uses' => 'TipoArtigoController@destroy',
    ]);

    //Criando Rotas de Artigo
    Route::get('/artigo', ['uses' => 'ArtigoController@index']);
    Route::post('/artigo', ['uses' => 'ArtigoController@store']);
    Route::get('/artigo/{id}', ['uses' => 'ArtigoController@show']);
    Route::put('/artigo/{id}', ['uses' => 'ArtigoController@update']);
    Route::delete('/artigo/{id}', ['uses' => 'ArtigoController@destroy']);

    //Criando Rotas de Contacto
    Route::get('/contacto', ['uses' => 'ContactoController@index']);
    Route::post('/contacto', ['uses' => 'ContactoController@store']);
    Route::get('/contacto/{id}', ['uses' => 'ContactoController@show']);
    Route::put('/contacto/{id}', ['uses' => 'ContactoController@update']);
    Route::delete('/contacto/{id}', ['uses' => 'ContactoController@destroy']);

    //Criando Rotas de Endereços
    Route::get('/endereco', ['uses' => 'EnderecoController@index']);
    Route::post('/endereco', ['uses' => 'EnderecoController@store']);
    Route::get('/endereco/{id}', ['uses' => 'EnderecoController@show']);
    Route::put('/endereco/{id}', ['uses' => 'EnderecoController@update']);
    Route::delete('/endereco/{id}', ['uses' => 'EnderecoController@destroy']);

    //Criando Rotas de HistoricoStock
    Route::get('/historicostock', ['uses' => 'HistoricoStockController@index']);
    Route::post('/historicostock', [
        'uses' => 'HistoricoStockController@store',
    ]);
    Route::get('/historicostock/{id}', [
        'uses' => 'HistoricoStockController@show',
    ]);
    Route::put('/historicostock/{id}', [
        'uses' => 'HistoricoStockController@update',
    ]);
    Route::delete('/historicostock/{id}', [
        'uses' => 'HistoricoStockController@destroy',
    ]);

    //Criando Rotas de NivelAcesso
    Route::get('/nivelacesso', ['uses' => 'NivelAcessoController@index']);
    Route::post('/nivelacesso', ['uses' => 'NivelAcessoController@store']);
    Route::get('/nivelacesso/{id}', ['uses' => 'NivelAcessoController@show']);
    Route::put('/nivelacesso/{id}', ['uses' => 'NivelAcessoController@update']);
    Route::delete('/nivelacesso/{id}', [
        'uses' => 'NivelAcessoController@destroy',
    ]);

    //Criando Rotas de Usuarios
    Route::get('/usuario', ['uses' => 'UsuarioController@index']);
    Route::post('/usuario', ['uses' => 'UsuarioController@store']);
    Route::get('/usuario/{id}', ['uses' => 'UsuarioController@show']);
    Route::put('/usuario/{id}', ['uses' => 'UsuarioController@update']);
    Route::delete('/usuario/{id}', ['uses' => 'UsuarioController@destroy']);

    //Criando Rotas de Taxa
    Route::get('/taxa', ['uses' => 'TaxaController@index']);
    Route::post('/taxa', ['uses' => 'TaxaController@store']);
    Route::get('/taxa/{id}', ['uses' => 'TaxaController@show']);
    Route::put('/taxa/{id}', ['uses' => 'TaxaController@update']);
    Route::delete('/taxa/{id}', ['uses' => 'TaxaController@destroy']);

    //Criando Rotas de Taxa Venda
    Route::get('/taxavenda', ['uses' => 'TaxaVendaController@index']);
    Route::post('/taxavenda', ['uses' => 'TaxaVendaController@store']);
    Route::get('/taxavenda/{id}', ['uses' => 'TaxaVendaController@show']);
    Route::put('/taxavenda/{id}', ['uses' => 'TaxaVendaController@update']);
    Route::delete('/taxavenda/{id}', ['uses' => 'TaxaVendaController@destroy']);

    //Criando Rotas de Taxa Compra
    Route::get('/taxacompra', ['uses' => 'TaxaCompraController@index']);
    Route::post('/taxacompra', ['uses' => 'TaxaCompraController@store']);
    Route::get('/taxacompra/{id}', ['uses' => 'TaxaCompraController@show']);
    Route::put('/taxacompra/{id}', ['uses' => 'TaxaCompraController@update']);
    Route::delete('/taxacompra/{id}', [
        'uses' => 'TaxaCompraController@destroy',
    ]);

    //Criando Rotas de Taxa Artigo
    Route::get('/taxartigo', ['uses' => 'TaxaArtigoController@index']);
    Route::post('/taxartigo', ['uses' => 'TaxaArtigoController@store']);
    Route::get('/taxartigo/{id}', ['uses' => 'TaxaArtigoController@show']);
    Route::put('/taxartigo/{id}', ['uses' => 'TaxaArtigoController@update']);
    Route::delete('/taxartigo/{id}', [
        'uses' => 'TaxaArtigoController@destroy',
    ]);

    //Criando Rotas de Papel
    Route::get('/papel', ['uses' => 'PapelController@index']);
    Route::post('/papel', ['uses' => 'PapelController@store']);
    Route::get('/papel/{id}', ['uses' => 'PapelController@show']);
    Route::put('/papel/{id}', ['uses' => 'PapelController@update']);
    Route::delete('/papel/{id}', ['uses' => 'PapelController@destroy']);

    //Criando Rotas de PapelPessoa
    Route::get('/papelpessoa', ['uses' => 'PapelPessoaController@index']);
    Route::post('/papelpessoa', ['uses' => 'PapelPessoaController@store']);
    Route::get('/papelpessoa/{id}', ['uses' => 'PapelPessoaController@show']);
    Route::put('/papelpessoa/{id}', ['uses' => 'PapelPessoaController@update']);
    Route::delete('/papelpessoa/{id}', [
        'uses' => 'PapelPessoaController@destroy',
    ]);

    //Criando Rotas de Permicoes Nivel Tables
    Route::get('/permicoesniveltables', [
        'uses' => 'PermicoesNivelTablesController@index',
    ]);
    Route::post('/permicoesniveltables', [
        'uses' => 'PermicoesNivelTablesController@store',
    ]);
    Route::get('/permicoesniveltables/{id}', [
        'uses' => 'PermicoesNivelTablesController@show',
    ]);
    Route::put('/permicoesniveltables/{id}', [
        'uses' => 'PermicoesNivelTablesController@update',
    ]);
    Route::delete('/permicoesniveltables/{id}', [
        'uses' => 'PermicoesNivelTablesController@destroy',
    ]);
});
