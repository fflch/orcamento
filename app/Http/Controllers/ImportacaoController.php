<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MovimentoService;
use App\Models\Movimento;
use App\Models\Lancamento;
use App\Services\Query;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ImportacaoController extends Controller
{

    public function index() {
        Gate::authorize('Administrador');

        $ano = MovimentoService::anomovimento();
        $anoanterior = Movimento::select('id')
            ->where('ano', ($ano->ano - 1))->first();
        $projetos = Query::SaldoProjetosEspeciais($anoanterior->id);

        return view('importacao.index', [
            'ano' => $ano->ano,
            'projetos' => $projetos
            ]
        );
    }

    public function store() {
        Gate::authorize('Administrador');

        $ano = MovimentoService::anomovimento();
        $importacao = Lancamento::select('id')->where('observacao', "Importação")
            ->where('movimento_id', $ano->id)->first();

        if(!$importacao) {
            $anoanterior = Movimento::select('id')
                ->where('ano', ($ano->ano -1))->first();
            $projetos = Query::SaldoProjetosEspeciais($anoanterior->id);
            $user_id = Auth::user()->id;

            foreach($projetos as $projeto) {
                DB::transaction(function() use($ano, $user_id, $projeto): void {
                    $lancamento = Lancamento::create([
                        'movimento_id' => $ano->id,
                        'grupo'        => $projeto->grupo,
                        'data'         => now()->format('Y-m-d'),
                        'credito'      => $projeto->total,
                        'descricao'    => "Transferência Saldo Exercício Anterior",
                        'observacao'   => "Importação",
                        'user_id'      => $user_id
                    ]);
                    $lancamento->contas()->attach($projeto->id,['percentual' => '100']);
                });
            }
            return back()->with('alert-success', 'Importação efetuada!');
        }
        else {
            return back()->with('alert-danger', 'Não foi efetuada a importação porque já foi executada uma vez!');
        };

    }
}
