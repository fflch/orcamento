<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContaRequest extends FormRequest
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
            'tipoconta_id' => 'required',
            'area_id'      => 'required',
            'nome'         => 'required',
            'email'        => 'email|nullable',
            'numero'       => 'integer|nullable',
            'ativo'        => 'boolean',
        ];
    }

    public function messages(){
        return [
            'tipoconta_id.required' => 'Informe o Tipo de Conta.',
            'area_id.required'      => 'Informe o Nome da Área.',
            'nome.required'         => 'Informe o Nome da Conta.',
            //'nome.unique'           => 'Já existe uma conta com esse nome.',
            'email.email'           => 'Informe um endereço de E-mail válido.',
            //'numero.required'       => 'Digite o Número da Conta.',
            'numero.integer'        => 'O Número deve ser um número inteiro.',
            //'numero.unique'         => 'Já existe uma conta com esse número.',
            'ativo.boolean'         => 'O campo Ativo deve estar marcado ou desmarcado.',
        ];
    }
}
