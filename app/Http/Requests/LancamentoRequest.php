<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LancamentoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'conta_id'    => 'required',
            'grupo'       => 'required',
            'receita'     => 'boolean',
            'data'        => 'required',
            'empenho'     => 'required',
            'descricao'   => 'required',
            'debito'      => 'required_without:credito',
            'credito'     => 'required_without:debito',
            'observacao'  => 'required',
            'percentual1' => 'required|integer',
            'percentual2' => 'required|integer',
            'percentual3' => 'required|integer',
            'percentual4' => 'required|integer',
            'total_precentuais'  => 'size:100',
        ];
    }

    public function messages(){
        return [
            'conta_id.required'        => 'Escolha uma Conta.',
            'grupo.required'           => 'Informe o Grupo.',
            'receita.required'         => 'O campo Receita deve estar marcado ou desmarcado.',
            'data.required'            => 'Informe a Data.',
            'empenho.required'         => 'Informe o Empenho.',
            'descricao.required'       => 'Informe a Descrição.',
            'debito.required_without'  => 'O Débito ou o Crédito deve ser informado.',
            'credito.required_without' => 'O Crédito ou o Débito deve ser informado.',
            //'debito.float'             => 'O Débito deve ser um valor monetário.',
            //'credito.float'            => 'O Crédtio deve ser um valor monetário.',
            'observacao.required'      => 'Informe a Observação.',
            'percentual1.required'     => 'Informe o Percentual #1.',
            'percentual2.required'     => 'Informe o Percentual #2.',
            'percentual3.required'     => 'Informe o Percentual #3.',
            'percentual4.required'     => 'Informe o Percentual #4.',
            'percentual1.integer'      => 'O Percentual #1 deve ser um inteiro.',
            'percentual2.integer'      => 'O Percentual #2 deve ser um inteiro.',
            'percentual3.integer'      => 'O Percentual #3 deve ser um inteiro.',
            'percentual4.integer'      => 'O Percentual #4 deve ser um inteiro.',
        ];
    }
}
