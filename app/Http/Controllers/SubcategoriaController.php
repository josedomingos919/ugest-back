<?php

namespace App\Http\Controllers;
use App\Models\Subcategoria;
use Illuminate\Http\Request;

class SubcategoriaController extends Controller
{
    public function index(Request $req)
    {
        return Subcategoria::paginate(isset($req->limit) ? $req->limit : 5);
    }

    public function store(Request $req)
    {
        try {
            $subcategoria = new Subcategoria();

            $subcategoria->scat_designacao = $req->scat_designacao;
            $subcategoria->scat_estado_id = $req->scat_estado_id;

            $result = $subcategoria->save();

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
        return $id ? Subcategoria::find($id) : Subcategoria::all();
    }

    public function update(Request $req, $id)
    {
        try {
            $subcategoria = Subcategoria::find($id);

            if ($subcategoria) {
                $subcategoria->scat_designacao = $req->scat_designacao;
                $subcategoria->scat_estado_id = $req->scat_estado_id;

                $result = $subcategoria->save();

                if ($result) {
                    return ['result' => $result];
                }

                return ['error' => 'Some error ocurred'];
            }

            return ['error' => 'subcategoria does not exists'];
        } catch (Exception $e) {
            return ['error' => $e];
        }
    }

    public function destroy($id)
    {
        $subcategoria = Subcategoria::find($id);

        if ($subcategoria) {
            $result = $subcategoria->delete();

            if ($result) {
                return ['deleted' => true];
            }

            return ['error' => false];
        }

        return ['error' => 'id does not exists'];
    }
}
