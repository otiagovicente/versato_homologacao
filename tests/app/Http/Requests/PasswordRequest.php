<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PasswordRequest extends Request
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
           'email' => 'required|email|max:255|exists:users,email',
           'password' => 'required|min:6|confirmed',
        ];
    }
    public function messages(){

        return [

            'password.required' => 'Insira uma senha para o usuário',
            'password.min' => 'Senha deve ter no mínimo 6 caracteres',
            'password.confirmed' => 'Senhas não são idênticas',

        ];

    }
}
