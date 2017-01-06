<?php

namespace App\Http\Controllers;

use App\Shop;
use Illuminate\Http\Request;
use App\Http\Requests\AddProductToOrderRequest;
use App\Contracts\ShoppingCart;

use App\Product;
use App\Customer;

class ShoppingCartController extends Controller
{

	public function addProduct(AddProductToOrderRequest $request, ShoppingCart $shoppingCart){

//		return response()->json($request);
		$product = $request;
		$shoppingCart->addProduct($product->product, $product->grid, $product->amount, $product->discount, $product->representativeDiscount);
		return response()->json($shoppingCart->getProducts());

	}

	public function getProducts(ShoppingCart $shoppingCart){
		$products = $shoppingCart->getProducts();

		return response()->json($products);
	}
	public function getOrder(ShoppingCart $shoppingCart){
		$order = $shoppingCart->getOrder();
		return response()->json($order);
	}

	public function deleteProduct(Product $product, ShoppingCart $shoppingCart){
		$deleted = $shoppingCart->deleteProduct($product->id);
		return response()->json($deleted);
	}

	public function selectCustomer(Customer $customer, ShoppingCart $shoppingCart){

		$shoppingCart->setCustomer($customer->id);

		return response()->json();
	}
	public function getCustomer(ShoppingCart $shoppingCart){
		return response()->json($shoppingCart->getCustomer());
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
		$shoppingCart->setProductAmount($request->product['id'], round($request->amount));
		return response()->json($shoppingCart->getProductAmount($request->product['id']));
	}

	public function setProductCustomerDiscount(Request $request, ShoppingCart $shoppingCart){
		$shoppingCart->setProductCustomerDiscount($request->product['id'], round($request->discount));
		return response()->json($shoppingCart->getProductCustomerDiscount($request->product['id']));

	}
	public function setProductRepresentativeDiscount(Request $request, ShoppingCart $shoppingCart){
		$shoppingCart->setProductRepresentativeDiscount($request->product['id'], round($request->representative_discount));
		return response()->json($shoppingCart->getProductRepresentativeDiscount($request->product['id']));

	}

}
