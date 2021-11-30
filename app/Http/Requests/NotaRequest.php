<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Nota;

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
            'tipo'         => ['required', Rule::in(Nota::lista_tipos())],
        ];
    }

    public function messages(){
        return [
            'tipoconta_id.required' => 'Informe o Tipo de Conta.',
            'texto.required'        => 'Informe o Texto.',
            //'texto.unique'          => 'Já existe uma nota com esse texto.',
            'tipo.required'         => 'Informe o Tipo.',
            'tipo.in'               => 'Informe uma das opções diponíveis.',
        ];
    }
}
