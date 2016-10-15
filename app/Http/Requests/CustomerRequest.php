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
        switch ($this->method) {
            case 'GET':
            case 'POST':
                $rules = [
                    'code' => 'required|unique:customers,code',
                    'cuit' => 'required|unique:customers,cuit',
                    'company' => 'required',
                    'name' => 'required',
                    'address' => 'required'
                ];
                break;
            case 'PUT':
            case 'PATCH':
                $rules = [
                    'code' => 'required',
                    'cuit' => 'required',
                    'company' => 'required',
                    'name' => 'required',
                    'address' => 'required'
                ];
                break;

            default:
                $rules = [
                    'code' => 'required',
                    'cuit' => 'required',
                    'company' => 'required',
                    'name' => 'required',
                    'address' => 'required'
                ];
                break;
        }


        return $rules;
    }
}
