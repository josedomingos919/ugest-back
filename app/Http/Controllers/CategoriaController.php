<?php

namespace App\Http\Controllers;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index(Request $req)
    {
        return Categoria::paginate(isset($req->limit) ? $req->limit : 5);
    }

    public function store(Request $req)
    {
        try {
            $categoria = new Categoria();

            $categoria->catg_designacao = $req->catg_designacao;
            $categoria->catg_subcategoria_id = $req->catg_subcategoria_id;
            $categoria->catg_estado_id = $req->catg_estado_id;

            $result = $categoria->save();

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
        return $id ? Categoria::find($id) : Categoria::all();
    }

    public function update(Request $req, $id)
    {
        try {
            $categoria = Categoria::find($id);

            if ($categoria) {
                $categoria->catg_designacao = $req->catg_designacao;
                $categoria->catg_subcategoria_id = $req->catg_subcategoria_id;
                $categoria->catg_estado_id = $req->catg_estado_id;

                $result = $categoria->save();

                if ($result) {
                    return ['result' => $result];
                }

                return ['error' => 'Some error ocurred'];
            }

            return ['error' => 'categoria does not exists'];
        } catch (Exception $e) {
            return ['error' => $e];
        }
    }

    public function destroy($id)
    {
        $categoria = Categoria::find($id);

        if ($categoria) {
            $result = $categoria->delete();

            if ($result) {
                return ['deleted' => true];
            }

            return ['error' => false];
        }

        return ['error' => 'id does not exists'];
    }
}
