<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
					'cost' => 'required|Numeric',
					'price' => 'required|Numeric',
					'overalldiscount' => 'required|Numeric',
					'customer_id' => 'required|integer',
					'status_id' => 'required|integer',
					'representative_id' => 'required|integer',
					'customer_discount' => 'required|Numeric',
					'representative_discount' => 'required|Numeric',
					'representative_commission' => 'required|Numeric',
					'total' => 'required|Numeric',
				];
				break;
			case 'PUT':
			case 'PATCH':
				$rules = [
					'id' => 'required',
					'cost' => 'required|Numeric',
					'price' => 'required|Numeric',
					'overalldiscount' => 'required|Numeric',
					'customer_id' => 'required|integer',
					'status_id' => 'required|integer',
					'representative_id' => 'required|integer',
					'customer_discount' => 'required|Numeric',
					'representative_discount' => 'required|Numeric',
					'representative_commission' => 'required|Numeric',
					'total' => 'required|Numeric',
				];
				break;

			default:
				$rules = [
					'cost' => 'required|Numeric',
					'price' => 'required|Numeric',
					'overalldiscount' => 'required|Numeric',
					'customer_id' => 'required|integer',
					'status_id' => 'required|integer',
					'representative_id' => 'required|integer',
					'customer_discount' => 'required|Numeric',
					'representative_discount' => 'required|Numeric',
					'representative_commission' => 'required|Numeric',
					'total' => 'required|Numeric',
				];
				break;
		}


		return $rules;
	}
	public function messages()
	{
		return [

			'cost.required' => 'necesita el costo total del pedido',
			'cost.Numeric' => 'el costo necesita ser un numero',
			'price.required' => 'necesita el precio total del pedido',
			'price.Numeric' => 'el costo necesita ser un numero',
			'overalldiscount.required' => 'necesita saber el descuento',
			'overalldiscount.Numeric' => 'necesita que el descuento sea un numero',
			'customer_id.required' => 'debes tener un cliente',
			'customer_id.integer' => 'cliente necesita ser tener un id',
			'status_id.required' => 'el pedido necesita status',
			'status_id.integer' => 'el status necesita ser un numero',
			'representative_id.required' => 'necesita de un representante',
			'representative_id.integer' => 'necesita el id del representante',
			'customer_discount.required' => 'necesita saber la percentage de descuento',
			'customer_discount.Numeric' => 'la percentage de descuento necesita ser un numero',
			'representative_discount.required' => 'necesita informar el descuento de representante',
			'representative_discount.Numeric' => 'el descuento de representante necesita ser un numero',
			'representative_commission.required' => 'necesita informar la comission de representante',
			'representative_commission.Numeric' => 'la comission del representante necesita ser un numero',
			'total.required' => 'necesita el total del pedido',
			'total.Numeric' => 'el total necesita que sea un numero',
		];
	}
}
