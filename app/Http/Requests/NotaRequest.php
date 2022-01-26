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
        if ($this->method() == 'POST'){
            $rules = [
                'texto' => [
                    'required',
                     Rule::unique('notas')->where(function ($query) {
                         $query->where('texto', $this->texto)
                            ->where('tipoconta_id', $this->tipoconta_id)
                            ->where('tipo', $this->tipo);
                     })
                ],    
            ];
        }
        else{
            $rules = [
                'texto' => [
                    'required',
                     Rule::unique('notas')->where(function ($query) {
                         $query->where('texto', $this->texto)
                            ->where('tipoconta_id', $this->tipoconta_id)
                            ->where('tipo', $this->tipo);
                     })->ignore($this->nota->id)
                ],
            ];
        }
        $rules['tipoconta_id'] = 'required';
        $rules['tipo']         = ['required', Rule::in(Nota::lista_tipos())];
        return $rules;
    }

    public function messages(){
        return [
            'tipoconta_id.required' => 'Informe o Tipo de Conta.',
            'texto.required'        => 'Informe o Texto.',
            'texto.unique'          => 'Já existe uma Nota com o texto [ ' . $this->texto . ' ] para o mesmo Tipo de Conta/Tipo.',
            'tipo.required'         => 'Informe o Tipo.',
            'tipo.in'               => 'Informe uma das opções diponíveis.',
        ];
    }
}
