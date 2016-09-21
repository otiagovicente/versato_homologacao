<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class LineRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    private $messages = [
        'code.required'        => 'Você precisa inserir um código.',
        'code.unique'          => 'Já existe uma linha de mesmo código.',
        'code.integer'         => 'Uma linha deve possuir um número como código',
        'description.required' => 'Você precisa inserir uma descrição',
    ];

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
                    'code' => 'required|unique:lines,code,NULL,NULL,brand_id,'.$this->brand_id.'|integer',
                    'description' => 'required'
                ];
                break;
            case 'PUT':
            case 'PATCH':
                $rules = [
                    'code' => 'required|integer',
                    'description' => 'required'
                ];
                break;
            
            default:
                $rules = [
                    'code' => 'required|unique:lines,code,NULL,NULL,brand_id,'.$this->brand_id.'|integer',
                    'description' => 'required'
                ];
                break;
        }

        return $rules;
    }

    public function messages(){

        return $this->messages;
    }
}
