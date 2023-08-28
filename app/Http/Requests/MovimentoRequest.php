<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class MovimentoRequest extends FormRequest
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
            'ano' => 'required|integer|between:1,9999',
            'ativo'     => 'boolean',
        ];

        if ($this->method() == 'POST'){
            $rules['ano'] .= "|unique:movimentos";
        }

        return $rules;
    }

    public function messages(){
        return [
            'ano.required'      => 'Informe o Ano.',
            'ano.integer'       => 'O Ano deve ser um número inteiro.',
            'ano.between'       => 'O Ano deve ter, no máximo, quatro dígitos.',
            'ano.unique'        => 'Já existe um Movimento com o ano [ ' . $this->ano . ' ].',
            'ativo.boolean'     => 'O campo Ativo deve estar marcado ou desmarcado.',
        ];
    }
}
