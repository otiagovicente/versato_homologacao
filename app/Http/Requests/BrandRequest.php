<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class BrandRequest extends Request
{

    private $messages = [
        'name.required'    => 'Você precisa inserir um nome para a marca.',
        'description.required' => 'Você precisa inserir uma descrição',
    ];
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
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'logo' => 'required',
            'image' => 'required'
        ];
        return $rules;
    }

    public function messages(){

        $messages = [
            'name.required' => 'che, olvidaste del nombre de la marca',
            'description.required' => 'ops, olvidaste de describir la marca',
            'logo.required' => 'ops, olvidaste del logo',
            'image.required' => 'olvidaste de la inmagen de pantalla'
        ];

        return $messages;
    }

}
