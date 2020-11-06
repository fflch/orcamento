<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FicOrcamentariaRequest extends FormRequest
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
    public function rules(){
        return [
            'dotacao_id' => 'required',
            'data'       => 'required',
            'empenho'    => 'required',
            'descricao'  => 'required',
            'debito'     => 'required',
            'credito'    => 'required',
            'observacao' => 'required',
        ];
    }

    public function messages(){
        return [
            'dotacao_id.required' => 'Escolha uma Conta',
            'data.required'       => 'Informe a Data',
            'empenho.required'    => 'Informe o Empenho',
            'descricao.required'  => 'Informe a Descrição',
            'debito.float'        => 'O Débito deve ser um valor monetário',
            'credito.float'       => 'O Crédtio deve ser um valor monetário',
            'observacao.required' => 'Informe a Observação',
        ];
    }
}
