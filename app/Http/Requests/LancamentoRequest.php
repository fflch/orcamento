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
            'conta_id'   => 'required',
            'grupo'      => 'required',
            'receita'    => 'boolean',
            'data'       => 'required',
            'empenho'    => 'required',
            'descricao'  => 'required',
            //'debito'     => 'required',
            //'credito'    => 'required',
            'observacao' => 'required',
            'debito' => 'required_without:credito',
            'credito' => 'required_without:debito',
        ];
    }

    public function messages(){
        return [
            'conta_id.required'   => 'Escolha uma Conta',
            'grupo.required'      => 'Informe o Grupo',
            'receita.required'    => 'O campo Receita deve estar marcado ou desmarcado.',
            'data.required'       => 'Informe a Data',
            'empenho.required'    => 'Informe o Empenho',
            'descricao.required'  => 'Informe a Descrição',
            'debito.required_without'        => 'O Débito ou o Crédito deve ser informado',
            'credito.required_without'       => 'O Débito ou o Crédito deve ser informado',
            'debito.float'        => 'O Débito deve ser um valor monetário',
            'credito.float'       => 'O Crédtio deve ser um valor monetário',
            'observacao.required' => 'Informe a Observação',
        ];
    }
}
