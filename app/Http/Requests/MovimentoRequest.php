<?php

namespace App\Http\Requests;

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
        return [
            'ano'       => 'required|integer|between:1,9999',
            'concluido' => 'boolean',
            'ativo'     => 'boolean',
        ];
    }

    public function messages(){
        return [
            'ano.required'      => 'Informe o Ano.',
            'ano.integer'       => 'O Ano deve ser um número inteiro.',
            'ano.between'       => 'O Ano deve ter, no máximo, quatro dígitos.',
            //'ano.unique'        => 'Já existe um movimento com esse ano.',
            'concluido.boolean' => 'O campo Concluído deve estar marcado ou desmarcado.',
            'ativo.boolean'     => 'O campo Ativo deve estar marcado ou desmarcado.',
        ];
    }
}
