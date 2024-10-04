<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Conta;
use App\Models\Lancamento;
use App\Services\FormataDataService;
use App\Services\LancamentoService;
use App\Http\Requests\LancamentoUserRequest;
use Carbon\Carbon;
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
        $this->authorize('Todos');
        return view('lancamentosuser.index',[
            'user' => auth()->user(),
            'contas' => $this->contas
        ]);
    }

    public function lancamentos(LancamentoUserRequest $request){
        $this->authorize('Todos');

        $lancamentos = LancamentoService::saldo(null, $request->conta_id, null,
            FormataDataService::handle($request->data_inicial),
            FormataDataService::handle($request->data_final));

        return view('lancamentosuser.index',[
            'user' => auth()->user(),
            'contas' => $this->contas,
            'conta_id' => $request->conta_id,
            'hoje' => Carbon::now()->format('d/m/Y'),
            'lancamentos' => $lancamentos,
            'total_debito'        => $lancamentos->sum('valor_debito'),
            'total_credito'       => $lancamentos->sum('valor_credito')
        ]);
    }

    public function lancamentos_pdf(LancamentoUserRequest $request){
        $this->authorize('Todos');

        $lancamentos = LancamentoService::saldo(null, $request->conta_id, null,
            FormataDataService::handle($request->data_inicial),
            FormataDataService::handle($request->data_final));

        $pdf = PDF::loadView('pdfs.lancamentos', [
            'conta_id'    => $request->conta_id,
            'lancamentos' => $lancamentos,
            'nome_conta'  => Conta::nome_conta($request->conta_id),
            'total_debito'        => $lancamentos->sum('valor_debito'),
            'total_credito'       => $lancamentos->sum('valor_credito')
        ])->setPaper('a4', 'landscape');

        return $pdf->download("lancamentos.pdf");
    }
}
