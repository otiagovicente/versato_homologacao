<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RepresentativeRequest extends FormRequest
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
                    'code' => 'required|unique:representatives,code',
                    'user_id' => 'required|integer|unique:representatives,user_id',
                ];
                break;
            case 'PUT':
            case 'PATCH':
                $rules = [
                    'code' => 'required',
                    'user_id' => 'required|integer',
                ];
                break;

            default:
                $rules = [
                    'code' => 'required|unique:representatives,code',
                    'user_id' => 'required|integer|unique:representatives,user_id',
                ];
                break;
        }

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'code.required'    => 'Necesitas poner un código.',
            'code.unique'    => 'Codigo de representante ya existe.',
            'user_id.required' => 'Necesitas tener un usuario',
            'user_id.integer' => 'Necesita ser un numero entero',
            'user_id.unique' => 'Ya hay representante agriegado al usuario'
        ];
        return $messages;
    }
}
