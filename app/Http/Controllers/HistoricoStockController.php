<?php

namespace App\Http\Controllers;
use App\Models\Historicostock;
use Illuminate\Http\Request;

class HistoricoStockController extends Controller
{
    public function index(Request $req)
    {
        return Historicostock::paginate(isset($req->limit) ? $req->limit : 5);
    }

    public function store(Request $req)
    {
        try {
            $hitoricostock = new Historicostock();

            $hitoricostock->hst_tipo = $req->hst_tipo;
            $hitoricostock->hst_quantidade = $req->hst_quantidade;
            $hitoricostock->hst_data_entrada = $req->hst_data_entrada;
            $hitoricostock->hst_preco_compra = $req->hst_preco_compra;
            $hitoricostock->hst_estado = $req->hst_estado;

            $result = $hitoricostock->save();

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
        return $id ? Historicostock::find($id) : Historicostock::all();
    }

    public function update(Request $req, $id)
    {
        try {
            $hitoricostock = Historicostock::find($id);

            if ($hitoricostock) {
                $hitoricostock->hst_tipo = $req->hst_tipo;
                $hitoricostock->hst_quantidade = $req->hst_quantidade;
                $hitoricostock->hst_data_entrada = $req->hst_data_entrada;
                $hitoricostock->hst_preco_compra = $req->hst_preco_compra;
                $hitoricostock->hst_estado = $req->hst_estado;

                $result = $hitoricostock->save();

                if ($result) {
                    return ['result' => $result];
                }

                return ['error' => 'Some error ocurred'];
            }

            return ['error' => 'historicostock does not exists'];
        } catch (Exception $e) {
            return ['error' => $e];
        }
    }

    public function destroy($id)
    {
        $hitoricostock = Historicostock::find($id);

        if ($hitoricostock) {
            $result = $hitoricostock->delete();

            if ($result) {
                return ['deleted' => true];
            }

            return ['error' => false];
        }

        return ['error' => 'id does not exists'];
    }
}
