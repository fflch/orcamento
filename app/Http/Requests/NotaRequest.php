<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotaRequest extends FormRequest
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
            'tipoconta_id' => 'required',
            'texto'        => 'required',
            'tipo'         => 'required',
        ];
    }

    public function messages(){
        return [
            'tipoconta_id.required' => 'Escolha o Tipo de Conta.',
            'texto.required'        => 'Digite o Texto da Nota.',
            'tipo.required'         => 'Escolha o tipo da Nota.',
        ];
    }
}
