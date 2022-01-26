<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        if ($this->method() == 'POST'){
            $rules = [
                'nome' => [
                    'required',
                     Rule::unique('contas')->where(function ($query) {
                         $query->where('nome', $this->nome)
                            ->where('tipoconta_id', $this->tipoconta_id)
                            ->where('area_id', $this->area_id);
                     })
                ],    
                'numero' => [
                    'integer',
                    'nullable',
                     Rule::unique('contas')->where(function ($query) {
                         $query->where('numero', $this->numero);
                     })
                ],
            ];
        }
        else{
            $rules = [
                'nome' => [
                    'required',
                     Rule::unique('contas')->where(function ($query) {
                         $query->where('nome', $this->nome)
                            ->where('tipoconta_id', $this->tipoconta_id)
                            ->where('area_id', $this->area_id);
                     })->ignore($this->conta->id)
                ],
                'numero' => [
                    'integer',
                    'nullable',
                     Rule::unique('contas')->where(function ($query) {
                         $query->where('numero', $this->numero);
                     })->ignore($this->conta->id)
                ],
            ];
        }
        $rules['tipoconta_id'] = 'required';
        $rules['area_id']      = 'required';
        $rules['email']        = 'email|nullable';
        $rules['ativo']        = 'boolean';
        return $rules;
    }

    public function messages(){
        return [
            'tipoconta_id.required' => 'Informe o Tipo de Conta.',
            'area_id.required'      => 'Informe o Nome da Área.',
            'nome.required'         => 'Informe o Nome da Conta.',
            'nome.unique'           => 'Já existe uma Conta com o nome [ ' . $this->nome . ' ] no mesmo Tipo de Conta/Área.',
            'email.email'           => 'Informe um endereço de E-mail válido.',
            'numero.integer'        => 'O Número deve ser um número inteiro.',
            'numero.unique'         => 'Já existe uma Conta com o número ' . $this->numero . '.',
            'ativo.boolean'         => 'O campo Ativo deve estar marcado ou desmarcado.',
        ];
    }
}
