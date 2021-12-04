<?php

namespace App\Http\Controllers;
use App\Models\Taxavenda;
use Illuminate\Http\Request;

class TaxaVendaController extends Controller
{
    public function index(Request $req)
    {
        return Taxavenda::paginate(isset($req->limit) ? $req->limit : 5);
    }

    public function store(Request $req)
    {
        try {
            $taxavenda = new Taxavenda();

            $taxavenda->tvn_estado = $req->tvn_estado;
            $taxavenda->tvn_venda_id = $req->tvn_venda_id;
            $taxavenda->tvn_artigo_id = $req->tvn_artigo_id;
            $taxavenda->tvn_taxa_id = $req->tvn_taxa_id;
            $taxavenda->tvn_percentagem = $req->tvn_percentagem;
            $taxavenda->tvn_valor = $req->tvn_valor;
            $taxavenda->tvn_descricao = $req->tvn_descricao;

            $result = $taxavenda->save();

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
        return $id ? Taxavenda::find($id) : Taxavenda::all();
    }

    public function update(Request $req, $id)
    {
        try {
            $taxavenda = Taxavenda::find($id);

            if ($taxavenda) {
                $taxavenda->tvn_estado = $req->tvn_estado;
                $taxavenda->tvn_venda_id = $req->tvn_venda_id;
                $taxavenda->tvn_artigo_id = $req->tvn_artigo_id;
                $taxavenda->tvn_taxa_id = $req->tvn_taxa_id;
                $taxavenda->tvn_percentagem = $req->tvn_percentagem;
                $taxavenda->tvn_valor = $req->tvn_valor;
                $taxavenda->tvn_descricao = $req->tvn_descricao;

                $result = $taxavenda->save();

                if ($result) {
                    return ['result' => $result];
                }

                return ['error' => 'Some error ocurred'];
            }

            return ['error' => 'taxavenda does not exists'];
        } catch (Exception $e) {
            return ['error' => $e];
        }
    }

    public function destroy($id)
    {
        $taxavenda = Taxavenda::find($id);

        if ($taxavenda) {
            $result = $taxavenda->delete();

            if ($result) {
                return ['deleted' => true];
            }

            return ['error' => false];
        }

        return ['error' => 'id does not exists'];
    }
}
