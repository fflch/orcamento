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
            'empenho'    => 'nullable',
            'descricao'  => 'required',
            'debito'     => 'required_without:credito',
            'credito'    => 'required_without:debito',
            'observacao' => 'required',
        ];
    }

    public function messages(){
        return [
            'dotacao_id.required'      => 'Informe a Dotação',
            'data.required'            => 'Informe a Data',
            'descricao.required'       => 'Informe a Descrição',
            'debito.float'             => 'O Débito deve ser um valor monetário',
            'credito.float'            => 'O Crédtio deve ser um valor monetário',
            'debito.required_without'  => 'O Débito ou o Crédito deve ser informado.',
            'credito.required_without' => 'O Crédito ou o Débito deve ser informado.',
            'observacao.required'      => 'Informe a Observação',
        ];
    }
}
