<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnidadeRequest extends FormRequest
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
            'numero'       => 'required',
            'nome'         => 'required',
            'departamento' => 'required',
        ];
    }

    public function messages(){
        return [
            'numero.required'       => 'Digite o Número da Unidade.',
            'nome.required'         => 'Digite o Nome da Unidade.',
            'departamento.required' => 'Digite o Departamento da Unidade.',
        ];
    }
}
