<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProdustosVenda;

class ProdustosVendaController extends Controller
{
    //

    public function index(Request $req)
    {
        return ProdustosVenda::paginate(isset($req->limit) ? $req->limit : 5);
    }

    public function store(Request $req)
    {
        $validated = $req->validate([
            'prod_venda_id' => 'required',
            'prod_art_id' => 'required',
            'prod_quantidade' => 'required',
            'prod_total' => 'required',
            'prod_preco' => 'required',
        ]);

        try {
            $result = ProdustosVenda::create([
                'prod_venda_id' => $req->prod_venda_id,
                'prod_art_id' => $req->prod_art_id,
                'prod_quantidade' => $req->prod_quantidade,
                'prod_total' => $req->prod_total,
                'prod_preco' => $req->prod_preco,
            ]);

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
        if ($id) {
            $result = ProdustosVenda::find($id);
            if ($result) {
                return $result;
            } else {
                return ['message' => 'not found'];
            }
        } else {
            return ProdustosVenda::all();
        }
    }

    public function update(Request $req, $id)
    {
        try {
            $item = ProdustosVenda::find($id);

            if ($item) {
                $item->prod_venda_id = $req->prod_venda_id;
                $item->prod_art_id = $req->prod_art_id;
                $item->prod_quantidade = $req->prod_quantidade;
                $item->prod_total = $req->prod_total;
                $item->prod_preco = $req->prod_preco;

                $result = $item->save();

                if ($result) {
                    return ['result' => $result];
                }

                return ['error' => 'Some error ocurred'];
            }

            return ['error' => 'Registro does not exists'];
        } catch (Exception $e) {
            return ['error' => $e];
        }
    }

    public function destroy($id)
    {
        $item = ProdustosVenda::find($id);

        if ($item) {
            $result = $item->delete();

            if ($result) {
                return ['deleted' => true];
            }

            return ['error' => false];
        }

        return ['error' => 'id does not exists'];
    }
}
