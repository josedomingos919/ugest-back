<?php

namespace App\Http\Controllers;
use App\Models\Permicoesniveltable;
use Illuminate\Http\Request;

class PermicoesNivelTablesController extends Controller
{
    public function index(Request $req)
    {
        return Permicoesniveltable::paginate(
            isset($req->limit) ? $req->limit : 5
        );
    }

    public function store(Request $req)
    {
        try {
            $permicoes = new Permicoesniveltable();

            $permicoes->pnt_ler = $req->pnt_ler;
            $permicoes->pnt_escrever = $req->pnt_escrever;
            $permicoes->pnt_eliminar = $req->pnt_eliminar;
            $permicoes->pnt_nivelAcesso_id = $req->pnt_nivelAcesso_id;
            $permicoes->pnt_estado_id = $req->pnt_estado_id;

            $result = $permicoes->save();

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
        return $id
            ? Permicoesniveltable::find($id)
            : Permicoesniveltable::all();
    }

    public function update(Request $req, $id)
    {
        try {
            $permicoes = Permicoesniveltable::find($id);

            if ($permicoes) {
                $permicoes->pnt_ler = $req->pnt_ler;
                $permicoes->pnt_escrever = $req->pnt_escrever;
                $permicoes->pnt_eliminar = $req->pnt_eliminar;
                $permicoes->pnt_nivelAcesso_id = $req->pnt_nivelAcesso_id;
                $permicoes->pnt_estado_id = $req->pnt_estado_id;

                $result = $permicoes->save();

                if ($result) {
                    return ['result' => $result];
                }

                return ['error' => 'Some error ocurred'];
            }

            return ['error' => 'permicoesniveltables does not exists'];
        } catch (Exception $e) {
            return ['error' => $e];
        }
    }

    public function destroy($id)
    {
        $permicoes = Permicoesniveltable::find($id);

        if ($permicoes) {
            $result = $permicoes->delete();

            if ($result) {
                return ['deleted' => true];
            }

            return ['error' => false];
        }

        return ['error' => 'id does not exists'];
    }
}
