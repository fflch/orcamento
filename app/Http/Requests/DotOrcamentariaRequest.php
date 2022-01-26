<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        if ($this->method() == 'POST'){
            $rules = [
                'dotacao' => [
                    'required',
                     Rule::unique('dot_orcamentarias')->where(function ($query) {
                         $query->where('dotacao', $this->dotacao);
                     })
                ],    
            ];
        }
        else{
            $rules = [
                'dotacao' => [
                    'required',
                     Rule::unique('dot_orcamentarias')->where(function ($query) {
                         $query->where('dotacao', $this->dotacao);
                     })->ignore($this->dotorcamentaria->id)
                ],
            ];
        }
        $rules['grupo']          = 'required';
        $rules['descricaogrupo'] = 'required';
        $rules['item']           = 'required';
        $rules['descricaoitem']  = 'required';
        $rules['receita']        = 'boolean';
        $rules['ativo']          = 'boolean';
        return $rules;
    }

    public function messages(){
        return [
            'dotacao.required'        => 'Informe a Dotação.',
            'dotacao.integer'         => 'A Dotação deve ser um número inteiro.',
            'dotacao.unique'          => 'Já existe uma Dotação com o número [ ' . $this->dotacao . ' ].',
            'grupo.required'          => 'Informe o Grupo.',
            'descricaogrupo.required' => 'Informe a Descrição do Grupo.',
            'item.required'           => 'Informe o Item.',
            'descricaoitem.required'  => 'Informe a Descrição do Item.',
            'receita.boolean'         => 'O campo Receita deve estar marcado ou desmarcado.',
            'ativo.boolean'           => 'O campo Ativo deve estar marcado ou desmarcado.',
        ];
    }
}
