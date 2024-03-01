<?php

namespace App\Http\Controllers;

use App\Models\Conta;
use App\Models\Lancamento;
use App\Models\Movimento;
use App\Models\TipoConta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Services\FormataDataService;
use App\Services\LancamentoService;
use DB;
use PDF;

class indexController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->except(['index']);
    }

    public function index(){

        $perfil_logado = '';
        $movimento_ativo = null;
        if(auth()->user()){
            $perfil_logado = auth()->user()->perfil;
            $movimento_ativo = Movimento::movimento_ativo()->ano;
            if (session('ano') == null) {
                session(['ano' => $movimento_ativo]);
            }
        }
        return view('index',[
                    'movimento_ativo' => $movimento_ativo,
                    'perfil_logado'   => $perfil_logado,
                    'movimento_anos'  => Movimento::movimento_anos(),
        ]);
    }

    public function mudaAno(Request $request){
        $this->authorize('Todos');

        # A validação ainda precisa passar para um local mais apropriado
        $validator = Validator::make(['ano' => $request->ano], [
            'ano' => 'required|integer|in:' . implode(',', Movimento::anos()),
        ]);

        if ($validator->fails()) {
            return back()
                 ->withErrors($validator)
                 ->withInput();
        }

        session(['ano' => $request->ano]);
        return back();
    }

    public function index_usuario(Request $request){
        $this->authorize('Todos');

        $user = auth()->user();
        $contas = Conta::whereHas('conta_usuarios', function ($query) use ($user) {
            $query->where('id_usuario', $user->id);
        })->get();

        $lancamentos = [];
        
        if(($request->data_inicial != null) and ($request->data_final != null) and ($request->conta_id != null)){
            $inicial = FormataDataService::handle($request->data_inicial);
            $final = FormataDataService::handle($request->data_final);
            $lancamentos = LancamentoService::handle($inicial, $final, $request->conta_id);
        }

        return view('index_usuario',[
            'user' => $user,
            'contas' => $contas,
            'lancamentos' => $lancamentos
        ]);
    }

    public function lancamentos_por_usuario(Request $request){

        $lancamentos = [];

        if(($request->data_inicial != null) and ($request->data_final != null) and ($request->conta_id != null)){
            $inicial = FormataDataService::handle($request->data_inicial);
            $final = FormataDataService::handle($request->data_final);
            $lancamentos = LancamentoService::handle($inicial, $final, $request->conta_id);
        }

        $nome_conta  = Conta::nome_conta($request->conta_id);
        $pdf = PDF::loadView('pdfs.lancamentos', [
            'lancamentos' => $lancamentos,
            'nome_conta'  => $nome_conta[0]->nome,
        ])->setPaper('a4', 'landscape');
        return $pdf->download("lancamentos.pdf");
    }
}
