<?php

namespace App\Http\Controllers;

use App\Models\ProdustosVenda;
use App\Models\Venda;
use Illuminate\Http\Request;

class VendaController extends Controller
{
    public function index(Request $req)
    {
        $limit = isset( $req->limit ) ? $req->limit : 5;
        return Venda::paginate($limit);
    }

    public function getFatNumber($id)
    {
        $venda = Venda::find($id)
            ::join('pessoas', 'pessoas.pes_id', '=', 'vendas.ven_cliente_id')
            ->where('ven_id', $id)
            ->first();

        $produtos = ProdustosVenda::where('prod_venda_id', $id)
            ->join(
                'artigos',
                'artigos.art_id',
                '=',
                'produstosvenda.prod_art_id'
            )
            ->get();

        if ($venda) {
            $year = explode('-', ((array) new \DateTime())['date'])[0];
            return [
                'fatura' => 'FAT' . $id . $year,
                'venda' => $venda,
                'artigos' => $produtos,
            ];
        }
    }

    public function store(Request $req)
    {
        try {
            $result = Venda::create([
                'ven_total' => $req->ven_total,
                'ven_quantidade' => $req->ven_quantidade,
                'ven_troco' => $req->ven_troco,
                'ven_valor_pago' => $req->ven_valor_pago,
                'ven_cliente_id' => $req->ven_cliente_id,
                'ven_estado' => $req->ven_estado,
                'ven_descricao' => $req->ven_descricao,
            ]);

            $year = explode('-', ((array) new \DateTime())['date'])[0];
            $fat_id = $result;
            $code = "FAT 00$year/$fat_id";

            if ($result) {
                $venda = Venda::find($fat_id);
                $venda->code = $code;
                $venda->save();

                return ['result' => $fat_id, 'code' => $code];
            }

            return ['error' => 'Some error ocurred'];
        } catch (Exception $e) {
            return ['error' => $e];
        }
    }

    public function show($id)
    {
        return $id ? Venda::find($id) : Venda::all();
    }

    public function update(Request $req, $id)
    {
        try {
            $venda = Venda::find($id);

            if ($venda) {
                $venda->ven_total = $req->ven_total;
                $venda->ven_quantidade = $req->ven_quantidade;
                $venda->ven_troco = $req->ven_troco;
                $venda->ven_valor_pago = $req->ven_valor_pago;
                $venda->ven_cliente_id = $req->ven_cliente_id;
                $venda->ven_estado = $req->ven_estado;
                $venda->ven_descricao = $req->ven_descricao;

                $result = $venda->save();

                if ($result) {
                    return ['result' => $result];
                }

                return ['error' => 'Some error ocurred'];
            }

            return ['error' => 'venda does not exists'];
        } catch (Exception $e) {
            return ['error' => $e];
        }
    }

    public function destroy($id)
    {
        $venda = Venda::find($id);

        if ($venda) {
            $result = $venda->delete();

            if ($result) {
                return ['deleted' => true];
            }

            return ['error' => false];
        }

        return ['error' => 'id does not exists'];
    }
}
