<?php
/**
 * Created by PhpStorm.
 * User: otiagovicente
 * Date: 19/12/16
 * Time: 20:23
 */

namespace App\Services;

use App\Contracts\ShoppingCart;

use App\Order;
use App\Customer;
use App\Product;
use App\Representative;
use App\Brand;
use App\Grid;
use Illuminate\Support\Facades\Session;

class SalesmanShoppingCart implements ShoppingCart{


	protected $order = null;
	protected $products;

	public function startShopping(Order $order = null){

		if($this->isClosed()) {
			if($order == null){
				$order = new Order();
			}
				$this->order = $order;

			Session::put(['ShoppingCart.Order'=> $this->order]);
			Session::put(['ShoppingCart.products' => collect([])]);
			return true;
		}else{
			return false;
		}
	}
	public function stopShopping(){
		$this->order = null;
		$this->save();

	}

	public function loadOrder(Order $order){
		$this->startShopping($order);
	}
	public function getOrder(){
		$order = Session::get('ShoppingCart.Order');
		return $order;
	}

	public function isNew(){

		if(!is_int($this->order->id)){
			return true;
		}else{
			return false;
		}

	}
	public function save(){
		session(['ShoppingCart.products' => $this->products]);
		session(['ShoppingCart.Order'=> $this->order]);
	}


	public function setStatus()
	{
		// TODO: Implement setStatus() method.
	}

	public function getStatus()
	{
		// TODO: Implement getStatus() method.
	}

	public function isOpened(){
		if(is_null(Session::get('ShoppingCart.Order'))){
			return false;
		}else{
			return true;
		}
	}
	public function isClosed(){
		return (!$this->isOpened());
	}

	public function getProducts(){

		return collect(Session::get('ShoppingCart.products'));

	}
	public function addProduct($product_id, $grid_id ,$amount = 1, $discount = 0.00, $representative_discount = 0.00){

		if($this->startShopping()){
			$brand_id = Product::find($product_id)->brand->id;

			$this->setBrand($brand_id);
		}


		if(!$this->checkBrand($product_id)){
			return false;
		}

		$product = [
			'product' => Product::find($product_id),
			'grid' => Grid::find($grid_id),
			'amount' => $amount,
			'discount' => $discount,
			'representative_discount' => $representative_discount
		];

		$product['grid']['total'] = $product['grid']->total;
		Session::push('ShoppingCart.products', $product);
	}

	public function getProductAmount($product_id){

		$products = $this->getProducts();
		foreach ($products as $product) {
			if($product['product']['id'] == $product_id){
				return $product['amount'];
			}
		}
	}
	public function setProductAmount($product_id, $value){

		$products = $this->getProducts()->toArray();
		foreach ($products as $index => $product) {
			if($product['product']['id'] == $product_id){
				$products[$index]['amount'] = $value;
			}
		}
		Session::put('ShoppingCart.products', $products);
		return $products;

	}
	public function getProductCustomerDiscount($product_id){

		$products = $this->getProducts();
		foreach ($products as $product) {
			if($product['product']['id'] == $product_id){
				return $product['discount'];
			}
		}
	}
	public function setProductCustomerDiscount($product_id, $value){

		$products = $this->getProducts()->toArray();
		foreach ($products as $index => $product) {
			if($product['product']['id'] == $product_id){
				$products[$index]['discount'] = $value;
			}
		}
		Session::put('ShoppingCart.products', $products);
		return $products;

	}
	public function getProductRepresentativeDiscount($product_id){

		$products = $this->getProducts();
		foreach ($products as $product) {
			if($product['product']['id'] == $product_id){
				return $product['representative_discount'];
			}
		}
	}
	public function setProductRepresentativeDiscount($product_id, $value){

		$products = $this->getProducts()->toArray();
		foreach ($products as $index => $product) {
			if($product['product']['id'] == $product_id){
				$products[$index]['representative_discount'] = $value;
			}
		}
		Session::put('ShoppingCart.products', $products);
		return $products;

	}

	public function deleteProduct($product_id){

			$products = $this->getProducts();
			$filtered = $products->where('product.id','!=', $product_id);

			Session::put('ShoppingCart.products', $filtered);

	}

	public function setBrand($brand_id){
		Session::put('ShoppingCart.Order.brand_id', $brand_id);

	}

	public function checkBrand($product_id)
	{
		$product = Product::with('brand')->find($product_id);
		$brand_id = $product->brand->id;
		if($this->getBrand()->id != $brand_id){
			return false;
		}
		return true;
	}

	public function getBrand(){
		$brand_id = Session::get('ShoppingCart.Order.brand_id');

		return Brand::find($brand_id);
	}

	public function setCommission($comission = 0.00){
		Session::put('ShoppingCart.Order.comission', $comission);

	}
	public function getComission(){
		Session::get('ShoppingCart.Order.comission');
	}

	public function setRepresentative($representative_id){
		Session::put('ShoppingCart.Order.representative_id', $representative_id);
	}
	public function getRepresentative(){
		$representative_id = Session::get('ShoppingCart.Order.representative_id');
		return Representative::find($representative_id);

	}

	public function setCustomer($customer_id){
		Session::put('ShoppingCart.Order.customer_id', $customer_id);
	}
	public function getCustomer(){
		$customer_id = Session::get('ShoppingCart.Order.customer_id');
		return Customer::find($customer_id);
	}

	public function getCustomerDiscount(){
		return Session::get('ShoppingCart.Order.customer_discount');
	}
	public function setCustomerDiscount($value){
		Session::put('ShoppingCart.Order.customer_discount', $value);
	}

	public function getRepresentativeDiscount(){
		return Session::get('ShoppingCart.Order.representative_discount');
	}
	public function setRepresentativeDiscount($value){
		Session::put('ShoppingCart.Order.representative_discount', $value);
	}
	public function test(){
		echo "ola";
	}

}