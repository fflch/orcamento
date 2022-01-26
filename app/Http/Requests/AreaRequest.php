<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
//use App\Models\User;

use Illuminate\Foundation\Http\FormRequest;

class AreaRequest extends FormRequest
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
                     Rule::unique('areas')->where(function ($query) {
                         $query->where('nome', $this->nome);
                     })
                ],    
            ];
        }
        else{
            $rules = [
                'nome' => [
                    'required',
                     Rule::unique('areas')->where(function ($query) {
                         $query->where('nome', $this->nome);
                     })->ignore($this->area->id)
                ],
            ];
        }
        return $rules;
    }

    public function messages(){
        return [
            'nome.required' => 'Informe o Nome.',
            'nome.unique'   => 'Já existe uma Área com o nome [ ' . $this->nome . ' ].',
        ];
    }
}
