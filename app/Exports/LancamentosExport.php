<?php

namespace App\Exports;

use App\Models\Lancamento;
use App\Services\LancamentoService;
use App\Services\MovimentoService;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LancamentosExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {
        
        $campos = Lancamento::campos()->keys()->splice(0, -1);
        $lancamento = Lancamento::select($campos->toArray())
        ->join('conta_lancamento','conta_lancamento.lancamento_id','lancamentos.id')
        ->where('data', '>=', session('ano').'-01-01');

        $lancamento->when(request()->_token, function($lancamento){
            $lancamento->when(request()->grupo, function($lancamento){
                $lancamento->whereRaw('lancamentos.grupo = ? ', [request()->grupo]);
            }
            )->when(request()->conta_id, function($lancamento){
                $lancamento->whereRaw('conta_lancamento.conta_id = ?', [request()->conta_id]);
            });
        });
        $lancamento = $lancamento
        ->orderBy('data','asc')
        ->get()
        ->map(function ($lancamento) use (&$saldo){
            $saldo += (int)$lancamento->credito - (int)$lancamento->debito;
            $lancamento->saldo = $saldo;
            return $lancamento;
        });

        return $lancamento;
    }

    public function headings(): array
    {
        return[
            Lancamento::campos()
            ->values()
            ->toArray()
        ];
    }

}