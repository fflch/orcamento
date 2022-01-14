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
        $rules = [
            'tipoconta_id' => 'required',
            'area_id'      => 'required',
            'nome'         => 'required',
            'email'        => 'email|nullable',
            'numero'       => 'integer|nullable',
            'ativo'        => 'boolean',
        ];
        if ($this->method() == 'POST'){
            $rules['nome']   .= "|unique:contas,tipoconta_id,area_id";
            $rules['numero'] .= "|unique:contas";
        }
        dd($rules);
        return $rules;
    }

    public function messages(){
        return [
            'tipoconta_id.required' => 'Informe o Tipo de Conta.',
            'area_id.required'      => 'Informe o Nome da Área.',
            'nome.required'         => 'Informe o Nome da Conta.',
            'nome.unique'           => 'Já existe uma conta com o nome ' . $this->nome . '.',
            'email.email'           => 'Informe um endereço de E-mail válido.',
            'numero.integer'        => 'O Número deve ser um número inteiro.',
            'numero.unique'         => 'Já existe uma conta com o número ' . $this->numero . '.',
            'ativo.boolean'         => 'O campo Ativo deve estar marcado ou desmarcado.',
        ];
    }
}
