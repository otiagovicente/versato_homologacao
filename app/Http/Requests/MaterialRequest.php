<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class MaterialRequest extends Request
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

    public function messages(){

        $messages = [
            'code.required' => 'Você precisa inserir o código do material',
            'code.unique' => 'Outro material já possui esse código',
            'code.integer' =>'o código do material precisa ser um número inteiro',
            'description' => 'Você precisa inserir o nome do material',
            'sample.mimes' => 'a amostra do material precisa ser .jpeg, .jpg ou .png',
            'sample.required' => 'Você precisa inserir uma amostra do material'
        ];
        return $messages;
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
                    'code' => 'required|unique:materials,code,NULL,NULL,brand_id,'.$this->brand_id.'|integer',
                    'description' => 'required',

                ];
                break;
            case 'PUT':
            case 'PATCH':
                $rules = [
                    'code' => 'required|integer',
                    'description' => 'required',


                ];
                break;
            
            default:
                $rules = [
                    'code' => 'required|unique:materials,code,NULL,NULL,brand_id,'.$this->brand_id.'integer',
                    'description' => 'required'
                ];
                break;
        }

        return $rules;
    }
}
