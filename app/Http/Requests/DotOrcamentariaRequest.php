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
        ];
    }

    public function messages(){
        return [
            'dotacao.required'        => 'Digite a Dotação.',
            'dotacao.integer'         => 'A Dotação deve ser um número inteiro.',
            'grupo.required'          => 'Digite o Grupo.',
            'descricaogrupo.required' => 'Digite a Descrição do Grupo.',
            'item.required'           => 'Digite o Item.',
            'descricaoitem.required'  => 'Digite a Descrição do Item.',
        ];
    }
}
