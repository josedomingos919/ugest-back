<?php

namespace App\Http\Controllers;
use App\Models\Papelpessoa;
use Illuminate\Http\Request;

class PapelPessoaController extends Controller
{
    public function index(Request $req)
    {
        return Papelpessoa::paginate(isset($req->limit) ? $req->limit : 5);
    }

    public function store(Request $req)
    {
        try {
            $papelpessoa = new Papelpessoa();

            $papelpessoa->ppa_designacao = $req->ppa_designacao;
            $papelpessoa->ppa_principal = $req->ppa_principal;
            $papelpessoa->ppa_estado_id = $req->ppa_estado_id;
            $papelpessoa->ppa_pessoa_id = $req->ppa_pessoa_id;
            $papelpessoa->ppa_papel_id = $req->ppa_papel_id;

            $result = $papelpessoa->save();

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
        return $id ? Papelpessoa::find($id) : Papelpessoa::all();
    }

    public function update(Request $req, $id)
    {
        try {
            $papelpessoa = Papelpessoa::find($id);

            if ($papelpessoa) {
                $papelpessoa->ppa_designacao = $req->ppa_designacao;
                $papelpessoa->ppa_principal = $req->ppa_principal;
                $papelpessoa->ppa_estado_id = $req->ppa_estado_id;
                $papelpessoa->ppa_pessoa_id = $req->ppa_pessoa_id;
                $papelpessoa->ppa_papel_id = $req->ppa_papel_id;

                $result = $papelpessoa->save();

                if ($result) {
                    return ['result' => $result];
                }

                return ['error' => 'Some error ocurred'];
            }

            return ['error' => 'papelpessoa does not exists'];
        } catch (Exception $e) {
            return ['error' => $e];
        }
    }

    public function destroy($id)
    {
        $papelpessoa = Papelpessoa::find($id);

        if ($papelpessoa) {
            $result = $papelpessoa->delete();

            if ($result) {
                return ['deleted' => true];
            }

            return ['error' => false];
        }

        return ['error' => 'id does not exists'];
    }
}
