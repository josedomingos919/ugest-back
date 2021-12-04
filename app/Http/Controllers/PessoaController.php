<?php

namespace App\Http\Controllers;
use App\Models\Pessoa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PessoaController extends Controller
{
    public function index(Request $req)
    {
        return DB::table('pessoas')->paginate(
            isset($req->limit) ? $req->limit : 5
        );
    }

    public function store(Request $req)
    {
        try {
            $pessoa = new Pessoa();

            $pessoa->pes_nome = $req->pes_nome;
            $pessoa->pes_nif = $req->pes_nif;
            $pessoa->pes_genero = $req->pes_genero;
            $pessoa->pes_estado_civil = $req->pes_estado_civil;
            $pessoa->pes_estado_id = $req->pes_estado_id;
            $pessoa->pes_data_nascimento = $req->pes_data_nascimento;

            $result = $pessoa->save();

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
        return $id ? Pessoa::find($id) : Pessoa::all();
    }

    public function showBI($bi)
    {
        $users = DB::table('pessoas')
            ->select('pes_nome', 'pes_id', 'pes_nif')
            ->where('pes_nif', '=', $bi)
            ->get();

        return $users;
    }

    public function update(Request $req, $id)
    {
        try {
            $pessoa = Pessoa::find($id);

            if ($pessoa) {
                $pessoa->pes_nome = $req->pes_nome;
                $pessoa->pes_nif = $req->pes_nif;
                $pessoa->pes_genero = $req->pes_genero;
                $pessoa->pes_estado_civil = $req->pes_estado_civil;
                $pessoa->pes_estado_id = $req->pes_estado_id;
                $pessoa->pes_data_nascimento = $req->pes_data_nascimento;

                $result = $pessoa->save();

                if ($result) {
                    return ['result' => $result];
                }

                return ['error' => 'Some error ocurred'];
            }

            return ['error' => 'pessoa does not exists'];
        } catch (Exception $e) {
            return ['error' => $e];
        }
    }

    public function destroy($id)
    {
        $pessoa = Pessoa::find($id);

        if ($pessoa) {
            $result = $pessoa->delete();

            if ($result) {
                return ['deleted' => true];
            }

            return ['error' => false];
        }

        return ['error' => 'id does not exists'];
    }
}
