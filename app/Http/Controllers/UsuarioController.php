<?php

namespace App\Http\Controllers;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index(Request $req)
    {
        return Usuario::paginate(isset($req->limit) ? $req->limit : 5);
    }

    public function store(Request $req)
    {
        try {
            $usuario = new Usuario();

            $usuario->usu_username = $req->usu_username;
            $usuario->usu_password = $req->usu_password;
            $usuario->usu_pessoa_id = $req->usu_pessoa_id;
            $usuario->usu_nivelAcesso_id = $req->usu_nivelAcesso_id;
            $usuario->usu_estado_id = $req->usu_estado_id;

            $result = $usuario->save();

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
        return $id ? Usuario::find($id) : Usuario::all();
    }

    public function update(Request $req, $id)
    {
        try {
            $usuario = Usuario::find($id);

            if ($usuario) {
                $usuario->usu_username = $req->usu_username;
                $usuario->usu_password = $req->usu_password;
                $usuario->usu_pessoa_id = $req->usu_pessoa_id;
                $usuario->usu_nivelAcesso_id = $req->usu_nivelAcesso_id;
                $usuario->usu_estado_id = $req->usu_estado_id;

                $result = $usuario->save();

                if ($result) {
                    return ['result' => $result];
                }

                return ['error' => 'Some error ocurred'];
            }

            return ['error' => 'usuario does not exists'];
        } catch (Exception $e) {
            return ['error' => $e];
        }
    }

    public function destroy($id)
    {
        $usuario = Usuario::find($id);

        if ($usuario) {
            $result = $usuario->delete();

            if ($result) {
                return ['deleted' => true];
            }

            return ['error' => false];
        }

        return ['error' => 'id does not exists'];
    }
}
