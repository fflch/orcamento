<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;
use MyValidator;

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
        $rules = [
            'grupo'       => 'required',
            'receita'     => 'boolean',
            'data'        => 'required',
            'empenho'     => 'required',
            'descricao'   => 'required',
            'debito'      => 'required_without:credito|nullable',
            'credito'     => 'required_without:debito|nullable',
            'observacao'  => 'required',
            'contas.*' => [
                'string',
            ],
            'contas' => [
                'required',
                'array',
            ],
            'percentual' => 'required'
        ];
        return $rules;

    }

    public function messages(){
        return [
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
        ];
    }
}
