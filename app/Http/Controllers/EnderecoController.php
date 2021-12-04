<?php

namespace App\Http\Controllers;
use App\Models\Endereco;
use Illuminate\Http\Request;

class EnderecoController extends Controller
{
    public function index(Request $req)
    {
        return Endereco::paginate(isset($req->limit) ? $req->limit : 5);
    }

    public function store(Request $req)
    {
        try {
            $endereco = new Endereco();

            $endereco->end_morada = $req->end_morada;
            $endereco->end_localidade = $req->end_localidade;
            $endereco->end_codigo_postal = $req->end_codigo_postal;
            $endereco->end_latitude = $req->end_latitude;
            $endereco->end_longitude = $req->end_longitude;
            $endereco->end_principal = $req->end_principal;
            $endereco->end_estado_id = $req->end_estado_id;
            $endereco->end_pessoa_id = $req->end_pessoa_id;

            $result = $endereco->save();

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
        return $id ? Endereco::find($id) : Endereco::all();
    }

    public function update(Request $req, $id)
    {
        try {
            $endereco = Endereco::find($id);

            if ($endereco) {
                $endereco->end_morada = $req->end_morada;
                $endereco->end_localidade = $req->end_localidade;
                $endereco->end_codigo_postal = $req->end_codigo_postal;
                $endereco->end_latitude = $req->end_latitude;
                $endereco->end_longitude = $req->end_longitude;
                $endereco->end_principal = $req->end_principal;
                $endereco->end_estado_id = $req->end_estado_id;
                $endereco->end_pessoa_id = $req->end_pessoa_id;

                $result = $endereco->save();

                if ($result) {
                    return ['result' => $result];
                }

                return ['error' => 'Some error ocurred'];
            }

            return ['error' => 'endereco does not exists'];
        } catch (Exception $e) {
            return ['error' => $e];
        }
    }

    public function destroy($id)
    {
        $endereco = Endereco::find($id);

        if ($endereco) {
            $result = $endereco->delete();

            if ($result) {
                return ['deleted' => true];
            }

            return ['error' => false];
        }

        return ['error' => 'id does not exists'];
    }
}
