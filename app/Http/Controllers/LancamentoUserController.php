<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Conta;
use App\Models\Lancamento;
use App\Services\FormataDataService;
use App\Services\LancamentoService;
use App\Http\Requests\LancamentoUserRequest;
use PDF;

class LancamentoUserController extends Controller
{
    protected $contas;

    public function __construct(){
        $this->middleware(function ($request, $next) {
            $user_id = auth()->user()->id;
            $this->contas = Conta::whereHas('conta_usuarios', function ($query) use ($user_id) {
                $query->where('id_usuario', $user_id);
            })->get();

            return $next($request);
        });
    }

    public function index(){
        return view('lancamentosuser.index',[
            'user' => auth()->user(),
            'contas' => $this->contas
        ]);
    }


    public function lancamentos(LancamentoUserRequest $request){
        $this->authorize('Todos');

        $lancamentos = LancamentoService::handle(FormataDataService::handle($request->data_inicial),
                                                FormataDataService::handle($request->data_final),
                                                $request->conta_id);
        //$lancamentos->load('contas');

        $total_debito  = 0.00;
        $total_credito = 0.00;
        $concatena_debito = '';

        foreach($lancamentos as $lancamento){
            $total_debito     += $lancamento->debito_raw;
            $concatena_debito .= $lancamento->debito_raw . ' -  ';
            $total_credito    += $lancamento->credito_raw;
            /*
            foreach($lancamento->contas as $conta){
                //dump($lancamento->credito_raw * $conta->pivot->percentual/100);
                //dump($lancamento->credito_raw);
                //dump($conta->pivot->percentual);
                $total_debito     += $lancamento->debito_raw * $conta->pivot->percentual/100;
                $concatena_debito .= $lancamento->debito_raw . ' -  ';
                $total_credito    += $lancamento->credito_raw * $conta->pivot->percentual/100;
                //dump($total_credito);
            }
              */
        }

        return view('lancamentosuser.index',[
            'user' => auth()->user(),
            'contas' => $this->contas,
            'conta_id' => $request->conta_id,
            'lancamentos' => $lancamentos,
            'total_debito'        => $total_debito,
            'total_credito'       => $total_credito
        ]);
    }

    public function lancamentos_pdf(LancamentoUserRequest $request){
        $this->authorize('Todos');

        $lancamentos = LancamentoService::handle(FormataDataService::handle($request->data_inicial),
                                                FormataDataService::handle($request->data_final),
                                                $request->conta_id);

        $nome_conta  = Conta::nome_conta($request->conta_id);
        $pdf = PDF::loadView('pdfs.lancamentos', [
            'conta_id'    => $request->conta_id,
            'lancamentos' => $lancamentos,
            'nome_conta'  => $nome_conta[0]->nome,
        ])->setPaper('a4', 'landscape');

        return $pdf->download("lancamentos.pdf");
    }
}
