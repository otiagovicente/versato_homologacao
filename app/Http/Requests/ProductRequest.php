<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProductRequest extends Request
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
                    'code' => 'required|unique:products,code,NULL,NULL,brand_id,'.$this->brand_id.'',
                    'code_beirario' => 'required|unique:products,code_beirario,NULL,NULL,brand_id,'.$this->brand_id.'',
                    'brand_id' => 'required',
                    'line_id' => 'required',
                    'reference_id' => 'required',
                    'material_id' => 'required',
                    'color_id' => 'required',
                    'photo' => 'required',
                    'cost' => 'required|numeric|price',
                    'price' => 'required|numeric|price',
                    'grids' => 'required'
                ];
            break;
            case 'PUT':
            case 'PATCH':
                $rules = [
                    'code' => 'required',
                    'code_beirario' => 'required',
                    'brand_id' => 'required',
                    'line_id' => 'required',
                    'reference_id' => 'required',
                    'material_id' => 'required',
                    'color_id' => 'required',
                    'photo' => 'required',
                    'cost' => 'required|numeric|price',
                    'price' => 'required|numeric|price',
                    'grids' => 'required'
                ];
            break;
            
            default:
                $rules = [
                    'code' => 'required',
                    'brand_id' => 'required',
                    'line_id' => 'required',
                    'reference_id' => 'required',
                    'material_id' => 'required',
                    'color_id' => 'required',
                    'photo' => 'required',
                    'cost' => 'required|numeric',
                    'price' => 'required|numeric',
                    'grids' => 'required'
                ];
            break;
        }

       return $rules;
    }
    public function messages(){
         $messages = [
            'code.required'    => 'Você precisa inserir um código.',
            'code.unique'    => 'Já existe um produto de mesmo código.',
            'code_beirario.required'    => 'Necesita de un codigo Beira Rio.',
            'code_beirario.unique'    => 'Já existe um produto de mesmo código.',
            'brand_id.required' => 'Você precisa especificar a marca do produto',
            'line_id.required' => 'Você precisa especificar a linha do produto',
            'reference_id.required' => 'Você precisa especificar a referencia do produto',
            'material_id.required' => 'Você precisa especificar o material do produto',
            'color_id.required' => 'Você precisa especificar a cor do produto',
            'photo.required' => 'Você precisa especificar a foto do produto',
            'cost.required' => 'Você precisa especificar o custo do produto',
            'cost.numeric' => 'Você precisa especificar um número como custo do produto',
            'cost.price' => 'O custo deve ser maior que zero',
            'price.price' => 'El precio necesita ser más grande que zero',
            'price.required' => 'Você precisa especificar o preço do produto',
            'price.numeric' => 'Você precisa especificar um número como preço do produto',
            'grids.required' => 'Você precisa especificar a grade do produto'
        ];
        return $messages;
    }
}
