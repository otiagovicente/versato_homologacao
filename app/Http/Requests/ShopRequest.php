<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopRequest extends FormRequest
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
        switch ($this->method()) {
            case 'GET':
            case 'POST':
                $rules = [
                    'name' => 'required',
                    'address' => 'required',
                    'geo' => 'required',
                    'customer_id' => 'required'
                ];
                break;
            case 'PUT':
            case 'PATCH':
                $rules = [
                    'name' => 'required',
                    'address' => 'required',
                    'geo' => 'required',
                    'customer_id' => 'required'
                ];
                break;

            default:
                $rules = [
                    'name' => 'required',
                    'address' => 'required',
                    'geo' => 'required',
                    'customer_id' => 'required'
                ];
                break;
        }


        return $rules;
    }
    public function messages()
    {
        return [
            'name.required' => 'necesita poner el nombre de la tienda',
            'address.required' => 'necesita poner la ubicación de la tienda',
            'geo.required' => 'necesita el geocode de la tienda',
            'customer_id.required' => 'la tienda necesita que sea de un cliente'
        ];
    }
}
