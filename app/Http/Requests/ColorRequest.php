<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ColorRequest extends Request
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
                    'code' => 'required|unique:colors,code,NULL,NULL,brand_id,'.$this->brand_id.'|integer',
                    'description' => 'required'
                ];
                break;
            case 'PUT':
            case 'PATCH':
                $rules = [
                    'code' => 'required|integer', 
                    'description' => 'required', 
                    'color' => 'required', 
                ];
                break;
            
            default:
                $rules = [
                    'code' => 'required|unique:colors,code,NULL,NULL,brand_id,'.$this->brand_id.'|integer',
                    'description' => 'required', 
                    'color' => 'required', 
                ];
                break;
        }


        return $rules;
    }

    public function messages(){
        return [
            'code.required' => 'Você precisa inserir o código da cor',
            'code.unique' => 'Este código já está vinculado à uma cor',
            'code.integer' => 'O Código precisa ser um número',
            'description.required' => 'Você precisa inserir uma descrição para a cor',
            'color.required' => 'Você precisa inserir a cor'
        ];
    }
}
