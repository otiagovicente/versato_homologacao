<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddProductToOrderRequest extends FormRequest
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
        return [
		'product' => 'required|integer',
		'amount' => 'required|integer|min:1',
		'grid' => 'required|integer',
        ];
    }
    public function messages()
    {
	    $messages = [
		    'product.required' => 'Necesita eligir un producto',
		    'product.integer' => 'No esta bueno la información del producto, necesita que sea el id',
		    'amount.required' => 'ops, necesita poner la cantidad',
		    'amount.integer' => 'No esta bueno la información de cantidad, necesita que sea un numero más grande que 0',
		    'amount.min' => 'ops, necesita que sea más grande que 0',
		    'grid.required' => 'ops, olvidaste de eligir la tarea',
		    'grid.integer' => 'Ops, necesita que sea el id de la tarea'
	    ];

	    return $messages;
    }
}
