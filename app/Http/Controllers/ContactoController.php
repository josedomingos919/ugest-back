<?php

namespace App\Http\Controllers;
use App\Models\Contacto;
use Illuminate\Http\Request;

class ContactoController extends Controller
{
    public function index(Request $req)
    {
        return Contacto::paginate(isset($req->limit) ? $req->limit : 5);
    }

    public function store(Request $req)
    {
        try {
            $contacto = new Contacto();

            $contacto->cont_email = $req->cont_email;
            $contacto->cont_fax = $req->cont_fax;
            $contacto->cont_telefone = $req->cont_telefone;
            $contacto->cont_telemovel = $req->cont_telemovel;
            $contacto->cont_principal = $req->cont_principal;
            $contacto->cont_estado_id = $req->cont_estado_id;
            $contacto->cont_pessoa_id = $req->cont_pessoa_id;

            $result = $contacto->save();

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
        return $id ? Contacto::find($id) : Contacto::all();
    }

    public function update(Request $req, $id)
    {
        try {
            $contacto = Contacto::find($id);

            if ($contacto) {
                $contacto->cont_email = $req->cont_email;
                $contacto->cont_fax = $req->cont_fax;
                $contacto->cont_telefone = $req->cont_telefone;
                $contacto->cont_telemovel = $req->cont_telemovel;
                $contacto->cont_principal = $req->cont_principal;
                $contacto->cont_estado_id = $req->cont_estado_id;
                $contacto->cont_pessoa_id = $req->cont_pessoa_id;

                $result = $contacto->save();

                if ($result) {
                    return ['result' => $result];
                }

                return ['error' => 'Some error ocurred'];
            }

            return ['error' => 'contacto does not exists'];
        } catch (Exception $e) {
            return ['error' => $e];
        }
    }

    public function destroy($id)
    {
        $contacto = Contacto::find($id);

        if ($contacto) {
            $result = $contacto->delete();

            if ($result) {
                return ['deleted' => true];
            }

            return ['error' => false];
        }

        return ['error' => 'id does not exists'];
    }
}
