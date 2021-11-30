<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DotOrcamentariaRequest extends FormRequest
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
            'dotacao'        => 'required|integer',
            'grupo'          => 'required',
            'descricaogrupo' => 'required',
            'item'           => 'required',
            'descricaoitem'  => 'required',
            'receita'        => 'boolean',
            'ativo'          => 'boolean',
        ];
    }

    public function messages(){
        return [
            'dotacao.required'        => 'Informe a Dotação.',
            'dotacao.integer'         => 'A Dotação deve ser um número inteiro.',
            //'dotacao.unique'          => 'Já existe uma Dotação com esse número.',
            'grupo.required'          => 'Informe o Grupo.',
            'descricaogrupo.required' => 'Informe a Descrição do Grupo.',
            'item.required'           => 'Informe o Item.',
            'descricaoitem.required'  => 'Informe a Descrição do Item.',
            'receita.boolean'         => 'O campo Receita deve estar marcado ou desmarcado.',
            'ativo.boolean'           => 'O campo Ativo deve estar marcado ou desmarcado.',
        ];
    }
}
