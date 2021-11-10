<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\User;

class UserRequest extends FormRequest
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
            'perfil' => ['required', Rule::in(User::lista_perfis())],
        ];
    }

    public function messages(){
        return [
            'perfil.required' => 'Escolha o perfil do Usuário.',
            'perfil.in'       => 'Escolha um dos perfis diponíveis.',
        ];
    }
}
