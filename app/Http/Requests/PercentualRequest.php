<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\PercentualRule;

class PercentualRequest extends FormRequest
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
            'contas.*' => [
                'string',
            ],
            'contas' => [
                'required',
            ],
            'percentual' => ['required', new PercentualRule($this->id)]
        ];
    }

    public function messages(){
        return [
            'contas.required'           => 'Informe a Conta.',
            'percentual.required'         => 'Informe o Percentual.'
        ];
    }
}
