<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserRequest extends Request
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

        switch ($this->method) {
            case 'GET':
            case 'POST':
                $rules = [
                    'name' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:users',
                    'password' => 'required|min:6|confirmed',
                    'password_confirmation' => 'min:6|same:password',
                    'role' => 'required'
                ];
                break;
            case 'PUT':
            case 'PATCH':
                $rules = [
                    'name' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:users',
                ];
                break;

            default:
                $rules = [
                    'name' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:users,email,'.$this->id,
                ];
                break;
        }
        return $rules;
    }

    public function messages(){
        return [
            'name.required' => 'Insira o nome do usuário',
            'name.max' => 'Nome não pode ter mais de 255 caracteres',
            'email.required' => 'Insira um email para o usuário',
            'email.email' => 'Formato não válido para email',
            'email.unique' => 'Email já cadastrado',
            'email.max' => 'Email não pode ter mais de 255 caracteres',
            'password.required' => 'Insira uma senha para o usuário',
            'password.min' => 'Senha deve ter no mínimo 6 caracteres',
            'password.confirmed' => 'Senhas não são idênticas',
            'role.required' => 'Escolha o tipo de usuário'
        ];
    }
}
?>