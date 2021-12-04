<?php

namespace App\Http\Controllers;
use App\Models\Estado;
use Illuminate\Http\Request;

class EstadoController extends Controller
{
    public function index(Request $req)
    {
        return Estado::paginate(isset($req->limit) ? $req->limit : 5);
    }

    public function store(Request $req)
    {
        try {
            $estado = new Estado();

            $estado->est_designacao = $req->est_designacao;

            $result = $estado->save();

            if ($result) {
                return ['result' => $result];
            }

            return ['error' => 'Some error ocurred'];
        } catch (Exception $e) {
            return ['error' => $e];
        }
    }

    public function show($id = null)
    {
        return $id ? Estado::find($id) : Estado::all();
    }

    public function update(Request $req, $id)
    {
        try {
            $estado = Estado::find($id);

            if ($estado) {
                $estado->est_designacao = $req->est_designacao;

                $result = $estado->save();

                if ($result) {
                    return ['result' => $result];
                }
            }

            return ['error' => 'Some error ocurred'];
        } catch (Exception $e) {
            return ['error' => $e];
        }
    }

    public function destroy($id)
    {
        $estado = Estado::find($id);

        if ($estado) {
            $result = $estado->delete();

            if ($result) {
                return ['deleted' => true];
            }

            return ['error' => false];
        }

        return ['error' => 'id does not exists'];
    }
}
