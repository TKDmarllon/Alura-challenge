<?php

namespace App\Repository;

use App\Models\Despesa;
use App\Entities\Despesa as DespesaEntity;
use Illuminate\Database\Eloquent\Collection;

class DespesaRepository 
{  

    public function criarDespesa(DespesaEntity $lancamento):Despesa
    {
        return Despesa::create($lancamento->toArray());
    }

    public function listarTodasDespesas():Collection
    {
        return Despesa::all();
    }

    public function listarBusca($busca):Collection
    {
        return Despesa::where('descricao',$busca)->get();
    }

    public function buscaDuplicado($data,$descricaoNova)
    {
        return Despesa::where('descricao', $descricaoNova)
        ->whereMonth('data', '=', $data)->get();
    }

    public function ListarUmaDespesa($id):Despesa
    {
        return Despesa::findorfail($id);
    }

    public function atualizarDespesa($lancamento)
    {
        $lancamento->save();
    }

    public function deletarDespesa($id):int
    {
        $deletar=Despesa::findorfail($id);
        return Despesa::destroy($deletar);
    }

    public function listarAnoMes($ano, $mes)
    {
        return Despesa::whereYear('data', '=', $ano)->whereMonth('data', '=', $mes)->get();
    }

    public function buscaDescricao($descricao)
    {
        return Despesa::where('descricao', '=', $descricao)->get();
    }

    public function totalDespesa($ano,$mes)
    {
        return Despesa::whereYear('data', '=', $ano)
                        ->whereMonth('data', '=', $mes)
                        ->selectRaw('SUM(despesa.valor) AS valorTotal')
                        ->get();
    }

    public function totalDespesaCategoria($ano,$mes)
    {
        return Despesa::whereYear('data', '=', $ano)
                        ->whereMonth('data', '=', $mes)
                        ->selectRaw('categoria')
                        ->selectRaw('SUM(despesa.valor) AS valorTotal')
                        ->GROUPBY('categoria')
                        ->get();
    }
}