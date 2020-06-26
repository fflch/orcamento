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
}
