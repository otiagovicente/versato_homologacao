<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
                    'code' => 'required|unique:customers,code',
                    'cuit' => 'required|unique:customers,cuit',
                    'company' => 'required',
                    'name' => 'required',
                    'address' => 'required',
                    'email' => 'required'
                ];
                break;
            case 'PUT':
            case 'PATCH':
                $rules = [
                    'code' => 'required',
                    'cuit' => 'required',
                    'company' => 'required',
                    'name' => 'required',
                    'address' => 'required',
                    'email' => 'required'
                ];
                break;

            default:
                $rules = [
                    'code' => 'required',
                    'cuit' => 'required',
                    'company' => 'required',
                    'name' => 'required',
                    'address' => 'required',
                    'email' => 'required'
                ];
                break;
        }


        return $rules;
    }

    public function messages()
    {
        return [
            'code.required' => 'necesita poner el codigo del cliente',
            'cuit.required' => 'necesita poner el cuit del cliente',
            'company.required' => 'necesita poner la razón social del cliente',
            'address.required' => 'necesita poner la ubicación del cliente',
            'email.required' => 'necesita poner el email del cliente',
            'geo.required' => 'necesita el geocode del cliente',
        ];
    }
}
