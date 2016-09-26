<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MacroregionRequest extends FormRequest
{
    private $messages = [
        'code.required'        => 'Você precisa inserir um nome.',
        'code.unique'          => 'Já existe uma linha de mesmo nome.',
        'description.required' => 'Você precisa inserir uma descrição',
    ];

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
         switch ($this->method) {
            case 'GET':
            case 'POST':
                $rules = [
                    'code' => 'required|unique:macroregions,code,NULL,NULL,brand_id,'.$this->brand_id.'',
                    'description' => 'required'
                ];
                break;
            case 'PUT':
            case 'PATCH':
                $rules = [
                    'code' => 'required',
                    'description' => 'required'
                ];
                break;
            
            default:
                $rules = [
                    'code' => 'required|unique:macroregions,code,NULL,NULL,brand_id,'.$this->brand_id.'',
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
