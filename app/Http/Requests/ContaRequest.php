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
            'email'        => 'required|email',
            'numero'       => 'required|integer',
            'ativo'        => 'boolean',
        ];
    }

    public function messages(){
        return [
            'tipoconta_id.required' => 'Escolha o Tipo de Conta.',
            'area_id.required'      => 'Escolha o Nome da Área.',
            'nome.required'         => 'Digite o Nome da Conta.',
            'email.required'        => 'Digite o E-mail da Conta.',
            'email.email'           => 'Informe um endereço de E-mail válido.',
            'numero.required'       => 'Digite o Número da Conta.',
            'nmumero.integer'       => 'O Número deve ser um número inteiro.',
            'ativo.boolean'         => 'O campo Ativo deve estar marcado ou desmarcado.',
        ];
    }
}
