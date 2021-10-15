<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lancamento;
use PDF;

class RelatorioController extends Controller
{
    public function relatorios(){
        $this->authorize('Todos');
        return view('relatorios.index');
    }


    public function balancete(Request $request){
        //dd("aqui de novo");
        if($request->data != null){
            //dd($request->data);
            $balancete = Lancamento::All();
        }

        $pdf = PDF::loadView('pdfs.balancete', [
            'balancete'    => $balancete,
            //'conveniado'  => $conveniado,
        ])->setPaper('a4', 'landscape');
        return $pdf->download("balancete.pdf");


    }
}
