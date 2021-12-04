<?php

namespace App\Http\Controllers;
use App\Models\Nivelacesso;
use Illuminate\Http\Request;

class NivelAcessoController extends Controller
{
    public function index(Request $req)
    {
        return Nivelacesso::paginate(isset($req->limit) ? $req->limit : 5);
    }

    public function store(Request $req)
    {
        try {
            $nivelacesso = new Nivelacesso();

            $nivelacesso->niv_designacao = $req->niv_designacao;
            $nivelacesso->niv_estado_id = $req->niv_estado_id;

            $result = $nivelacesso->save();

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
        return $id ? Nivelacesso::find($id) : Nivelacesso::all();
    }

    public function update(Request $req, $id)
    {
        try {
            $nivelacesso = Nivelacesso::find($id);

            if ($nivelacesso) {
                $nivelacesso->niv_designacao = $req->niv_designacao;
                $nivelacesso->niv_estado_id = $req->niv_estado_id;

                $result = $nivelacesso->save();

                if ($result) {
                    return ['result' => $result];
                }

                return ['error' => 'Some error ocurred'];
            }

            return ['error' => 'nivelacesso does not exists'];
        } catch (Exception $e) {
            return ['error' => $e];
        }
    }

    public function destroy($id)
    {
        $nivelacesso = Nivelacesso::find($id);

        if ($nivelacesso) {
            $result = $nivelacesso->delete();

            if ($result) {
                return ['deleted' => true];
            }

            return ['error' => false];
        }

        return ['error' => 'id does not exists'];
    }
}
