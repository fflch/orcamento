<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LancamentoUserRequest extends FormRequest
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
            'data_inicial' => 'required|date_format:"d/m/Y"',
            'data_final' => 'required|date_format:"d/m/Y"|after:data_inicial',
            'conta_id' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'data_inicail.required' => 'Data inicial é requerida.',
            'data_final.required' => 'Data final é requerida.',
            'conta_id.required' => 'A conta é requerida.',
            'data_final.after' => 'Data final tem que ser posterior a data de início',
        ];
    }
}
