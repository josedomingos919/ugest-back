<?php

namespace App\Http\Controllers;
use App\Models\Taxacompra;
use Illuminate\Http\Request;

class TaxaCompraController extends Controller
{
    public function index(Request $req)
    {
        return Taxacompra::paginate(isset($req->limit) ? $req->limit : 5);
    }

    public function store(Request $req)
    {
        try {
            $taxacompra = new Taxacompra();

            $taxacompra->tcm_historicoStock_id = $req->tcm_historicoStock_id;
            $taxacompra->tcm_taxa_id = $req->tcm_taxa_id;
            $taxacompra->tcm_estado = $req->tcm_estado;

            $result = $taxacompra->save();

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
        return $id ? Taxacompra::find($id) : Taxacompra::all();
    }

    public function update(Request $req, $id)
    {
        try {
            $taxacompra = Taxacompra::find($id);

            if ($taxacompra) {
                $taxacompra->tcm_historicoStock_id =
                    $req->tcm_historicoStock_id;
                $taxacompra->tcm_taxa_id = $req->tcm_taxa_id;
                $taxacompra->tcm_estado = $req->tcm_estado;

                $result = $taxacompra->save();

                if ($result) {
                    return ['result' => $result];
                }

                return ['error' => 'Some error ocurred'];
            }

            return ['error' => 'taxacompra does not exists'];
        } catch (Exception $e) {
            return ['error' => $e];
        }
    }

    public function destroy($id)
    {
        $taxacompra = Taxacompra::find($id);

        if ($taxacompra) {
            $result = $taxacompra->delete();

            if ($result) {
                return ['deleted' => true];
            }

            return ['error' => false];
        }

        return ['error' => 'id does not exists'];
    }
}
