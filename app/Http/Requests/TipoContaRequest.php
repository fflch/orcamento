<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipoContaRequest extends FormRequest
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
            'descricao'          => 'required',
            'cpfo'               => 'boolean',
            'relatoriobalancete' => 'boolean',
        ];
        if ($this->method() == 'POST')
            $rules['descricao'] .= "|unique:tipo_contas";
        return $rules;
    }

    public function messages(){
        return [
            'descricao.required'         => 'Informe a Descrição.',
            'descricao.unique'           => 'Já existe um Tipo de Conta com a descrição ' . $this->descricao . '.',
            'cpfo.boolean'               => 'O campo [ Faz Contra-Partida com a Ficha Orçamentária ] deve estar marcado ou desmarcado.',
            'relatoriobalancete.boolean' => 'O campo [ Deve constar no relatório Balancete ] deve estar marcado ou desmarcado.',
        ];
    }
}
