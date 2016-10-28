<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliverycenterRequest extends FormRequest
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
                    'name' => 'required',
                    'address' => 'required',
                    'city' => 'required',
                    'state' => 'required',
                    'zip' => 'required',
                    'geo' => 'required',
                    'customer_id' => 'required'
                ];
                break;
            case 'PUT':
            case 'PATCH':
                $rules = [
                    'name' => 'required',
                    'address' => 'required',
                    'city' => 'required',
                    'state' => 'required',
                    'zip' => 'required',
                    'geo' => 'required',
                    'customer_id' => 'required'
                ];
                break;

            default:
                $rules = [
                    'name' => 'required',
                    'address' => 'required',
                    'city' => 'required',
                    'state' => 'required',
                    'zip' => 'required',
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
            'name.required' => 'necesita poner el nombre del Centro de Entrega',
            'address.required' => 'necesita poner la ubicación completa del Centro de Entrega',
            'city.required' => 'necesita poner la ubicación completa del Centro de Entrega',
            'state.required' => 'necesita poner la ubicación completa del Centro de Entrega',
            'zip.required' => 'necesita poner la ubicación completa del Centro de Entrega',
            'geo.required' => 'necesita el geocode del Centro de Entrega',
            'customer_id.required' => ' El Centro de Entrega necesita que sea de un cliente'
        ];
    }
}
