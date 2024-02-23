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
use DB;

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
        $contas = Conta::with('conta_usuarios')->where(function ($query) use ($user) {
            $query->whereHas('conta_usuarios', function ($query) use ($user) {
                $query->where('id_usuario', $user->id);
            });
        })->get();

        $lancamentos = [];

        if(($request->data_inicial != null) and ($request->data_final != null) and ($request->conta_id != null)){

            $lancamentos_id = DB::table('conta_lancamento')->where('conta_id', $request->conta_id)->pluck('lancamento_id')->toArray();
            $lancamentos = Lancamento::find($lancamentos_id);    
            $dti = Carbon::createFromFormat('d/m/Y', $request->data_inicial)->format('d-m-Y');
            $dtf = Carbon::createFromFormat('d/m/Y', $request->data_final)->format('d-m-Y');
            $inicio = Carbon::parse($dti);
            $fim = Carbon::parse($dtf);  
            $periodo = $fim->diffInDays($inicio);
            if($periodo > 30){
                request()->session()->flash('alert-info','O período deve ser de no máximo 30 dias entre data inicial e final');
                return back();
            } else {
                $lancamentos = $lancamentos->whereBetween('data', [$dti, $dtf]);
            }
        }

        return view('index_usuario',[
            'user' => $user,
            'contas' => $contas,
            'lancamentos' => $lancamentos
        ]);
    }
}
