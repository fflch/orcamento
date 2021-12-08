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
        return [
            'descricao'          => 'required',
            'cpfo'               => 'boolean',
            'relatoriobalancete' => 'boolean',
        ];
    }

    public function messages(){
        return [
            'descricao.required'         => 'Informe a Descrição.',
            //'descricao.unique'           => 'Já existe um tipo de conta com essa descrição.',
            'cpfo.boolean'               => 'O campo [ Faz Contra-Partida com a Ficha Orçamentária ] deve estar marcado ou desmarcado.',
            'relatoriobalancete.boolean' => 'O campo [ Deve constar no relatório Balancete ] deve estar marcado ou desmarcado.',
        ];
    }
}
