<?php

namespace App\Http\Controllers;
use App\Models\Taxa;
use Illuminate\Http\Request;

class TaxaController extends Controller
{
    public function index(Request $req)
    {
        return Taxa::join(
            'estados',
            'estados.est_id',
            '=',
            'taxas.tax_estado'
        )->paginate(isset($req->limit) ? $req->limit : 5);
    }

    public function store(Request $req)
    {
        try {
            $taxa = new Taxa();

            $taxa->tax_tipo = $req->tax_tipo;
            $taxa->tax_descricao = $req->tax_descricao;
            $taxa->tax_preco = $req->tax_preco;
            $taxa->tax_percentagem = $req->tax_percentagem;
            $taxa->tax_estado = $req->tax_estado;

            $result = $taxa->save();

            if ($result) {
                return ['result' => $result];
            }

            return ['error' => 'Some error ocurred'];
        } catch (Exception $e) {
            return ['error' => $e];
        }
    }

    public function show($id)
    {
        return $id ? Taxa::find($id) : Taxa::all();
    }

    public function update(Request $req, $id)
    {
        try {
            $taxa = Taxa::find($id);

            if ($taxa) {
                $taxa->tax_tipo = $req->tax_tipo;
                $taxa->tax_descricao = $req->tax_descricao;
                $taxa->tax_preco = $req->tax_preco;
                $taxa->tax_percentagem = $req->tax_percentagem;
                $taxa->tax_estado = $req->tax_estado;

                $result = $taxa->save();

                if ($result) {
                    return ['result' => $result];
                }

                return ['error' => 'Some error ocurred'];
            }

            return ['error' => 'taxa does not exists'];
        } catch (Exception $e) {
            return ['error' => $e];
        }
    }

    public function destroy($id)
    {
        $taxa = Taxa::find($id);

        if ($taxa) {
            $result = $taxa->delete();

            if ($result) {
                return ['deleted' => true];
            }

            return ['error' => false];
        }

        return ['error' => 'id does not exists'];
    }
}
