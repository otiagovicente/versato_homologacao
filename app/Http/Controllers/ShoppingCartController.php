<?php

namespace App\Http\Controllers;

use App\Order;
use App\Representative;
use App\Shop;
use Illuminate\Http\Request;
use App\Http\Requests\AddProductToOrderRequest;
use App\Http\Requests\ShoppingCartSaveRequest;
use App\Contracts\ShoppingCart;

use App\Product;
use App\Customer;

class ShoppingCartController extends Controller
{

	public function addProduct(AddProductToOrderRequest $request, ShoppingCart $shoppingCart){

		$product = $request;

		$shoppingCart->addProduct($product->product, $product->grid, $product->amount, $product->discount, $product->representativeDiscount);
		return response()->json($shoppingCart->getProducts());

	}

	public function getProducts(ShoppingCart $shoppingCart){
		return response()->json($shoppingCart->getProducts());
	}

	public function getOrder(ShoppingCart $shoppingCart){
		return response()->json($shoppingCart->getOrder());
	}

	public function deleteProduct(Product $product, ShoppingCart $shoppingCart){
		$deleted = $shoppingCart->deleteProduct($product->id);
		return response()->json($deleted);
	}

	public function setCustomer(Customer $customer, ShoppingCart $shoppingCart){

		$shoppingCart->setCustomer($customer->id);

		return response()->json();
	}
	public function getCustomer(ShoppingCart $shoppingCart){
		return response()->json($shoppingCart->getCustomer());
	}

	public function setRepresentative(Representative $representative, ShoppingCart $shoppingCart){
		$shoppingCart->setRepresentative($representative->id);
	}
	public function getRepresentative(ShoppingCart $shoppingCart){
		return response()->json($shoppingCart->getRepresentative());
	}

	public function setComment(Request $request, ShoppingCart $shoppingCart){
		$shoppingCart->setComment($request->comment);
	}

	public function getComment(ShoppingCart $shoppingCart){
		return response()->json($shoppingCart->getComment());
	}

	public function setCustomerDiscount(Request $request, ShoppingCart $shoppingCart){
		$shoppingCart->setCustomerDiscount(round($request->customer_discount));

		return response()->json($shoppingCart->getCustomerDiscount());
	}
	public function setRepresentativeDiscount(Request $request, ShoppingCart $shoppingCart){
		$shoppingCart->setRepresentativeDiscount(round($request->representative_discount));
		return response()->json($shoppingCart->getRepresentativeDiscount());
	}


	public function setProductAmount(Request $request, ShoppingCart $shoppingCart){
		$shoppingCart->setProductAmount($request->id, round($request->pivot['amount']));
		return response()->json($shoppingCart->getProductAmount($request->id));
	}

	public function setProductCustomerDiscount(Request $request, ShoppingCart $shoppingCart){
		$shoppingCart->setProductCustomerDiscount($request->id, round($request->pivot['discount']));
		return response()->json($shoppingCart->getProductCustomerDiscount($request->id));

	}
	public function setProductRepresentativeDiscount(Request $request, ShoppingCart $shoppingCart){
		$shoppingCart->setProductRepresentativeDiscount($request->id, round($request->pivot['representative_discount']));
		return response()->json($shoppingCart->getProductRepresentativeDiscount($request->id));

	}

	public function setStatus(Request $request, ShoppingCart $shoppingCart){
		$shoppingCart->setStatus($request->status_id);
		return $shoppingCart->getStatus();
	}
	public function getStatus(ShoppingCart $shoppingCart){
		return $shoppingCart->getStatus();
	}

	public function loadOrder($order_id, ShoppingCart $shoppingCart){
		return response()->json($shoppingCart->loadOrder($order_id));
	}
	public function updateOrder(Request $request, ShoppingCart $shoppingCart){
		return $shoppingCart->updateOrder($request);
	}

	public function stopShopping(ShoppingCart $shoppingCart){
		$shoppingCart->stopShopping();
	}

	public function save(ShoppingCartSaveRequest $request, ShoppingCart $shoppingCart){
		return response()->json($shoppingCart->save($request));
	}

}
