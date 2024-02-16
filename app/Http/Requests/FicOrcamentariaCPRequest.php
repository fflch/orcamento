<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ValorRule;

class FicOrcamentariaCPRequest extends FormRequest
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
            'contas'   => 'required',
            'grupo' => 'required',
            'ficorcamentaria_id' => 'required|integer',
            'debito'     => 'required_without:credito',
            'credito'    => 'required_without:debito',
        ];
    }

    public function messages(){
        return [
            'contas.required' => 'Informe a Conta',
            'grupo.required' => 'Informe o Grupo'
        ];
    }
}
