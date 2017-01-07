<?php
/**
 * Created by PhpStorm.
 * User: otiagovicente
 * Date: 19/12/16
 * Time: 20:23
 */

namespace App\Services;

use App\Contracts\ShoppingCart;

use App\Material;
use App\Order;
use App\Customer;
use App\Product;
use App\Representative;
use App\Brand;
use App\Grid;
use App\Line;
use App\Color;
use Illuminate\Support\Facades\Session;

class SalesmanShoppingCart implements ShoppingCart{


	protected $order = null;
	protected $products;

	public function startShopping(Order $order = null){

		if($this->isClosed()) {
			if($order == null){
				$order = new Order();
				$order->status_id = 1;
			}
				$this->order = $order;

			Session::put(['ShoppingCart.Order'=> $this->order]);
			Session::put(['ShoppingCart.products' => collect([])]);
			$this->calculateProductsValues();
			return true;
		}else{
			$this->calculateProductsValues();
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
		$order = session('ShoppingCart.Order');
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

		$order = $this->getOrder();
		$order = new Order(collect($order)->toArray());
		$order->save();
		Session::put('ShoppingCart.Order', $order);
		$this->saveProducts();
		return $order;


	}

	public function saveProducts(){

		$order = $this->getOrder();
		$order = new Order(collect($order)->toArray());
		$products = $this->getProducts()->toArray();
		$savingProducts = [];
		foreach ($products as $key => $product) {


			unset($product['grid']);
			unset($product['product']);

			$savingProducts.push($product);
		}

		$order->products()->sync($savingProducts);

	}

	public function setStatus($status_id)
	{
		session(['ShoppingCart.Order.status_id'=> $status_id]);
	}

	public function getStatus()
	{
		return session('ShoppingCart.Order.status_id');
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

		$this->setStatus(1);
		if($this->startShopping()){


			$brand_id = Product::find($product_id)->brand->id;

			$this->setBrand($brand_id);
		}

		if(!$this->checkBrand($product_id)){
			return false;
		}

		$product = [
			'product' => Product::find($product_id),
			'product_id' => $product_id,
			'grid' => Grid::find($grid_id),
			'grid_id' => $grid_id,
			'amount' => $amount,
			'discount' => $discount,
			'representative_discount' => $representative_discount
		];

		$product['grid']['total'] = $product['grid']->total;
		Session::push('ShoppingCart.products', $product);

		$this->calculateProductsValues();
	}

	public function getProduct($product_id){
		$products = $this->getProducts();
		foreach ($products as $product) {
			if($product['product']['id'] == $product_id){
				return $product;
			}
		}
	}

	public function getProductAmount($product_id){

		$products = $this->getProducts();
		foreach ($products as $product) {
			if($product['product']['id'] == $product_id){
				return $product['amount'];
			}
		}
	}

	public function getProductPrice($product_id){

		$products = $this->getProducts();
		foreach ($products as $product) {
			if($product['product']['id'] == $product_id){
				return $product['product']['price'];
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
		$this->calculateProductsValues();
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
		$this->calculateProductsValues();
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
	public function calculateProductsValues(){

		$orderTotal = 0.00;
		$orderTotalSum = 0.00;
		$orderTotalDiscount = 0.00;
		$orderTotalCost = 0.00;
		$orderTotalRepresentativeComission = 0.00;

		$products = $this->getProducts()->toArray();
		foreach ($products as $index => $product) {
			$updatedProduct = $this->calculateProductValue($product['product']['id']);
			$orderTotal += $updatedProduct['total'];
			$orderTotalSum += $updatedProduct['price'];
			$orderTotalDiscount += $updatedProduct['total_discount'];
			$orderTotalCost += $updatedProduct['cost'];
			$orderTotalRepresentativeComission += $updatedProduct['representative_commission'];
		}

		$order = $this->getOrder();
		$order['total'] = $orderTotal;
		$order['price'] = $orderTotalSum;
		$order['representative_commission'] = $orderTotalRepresentativeComission;
		$order['overalldiscount'] = $orderTotalDiscount;
		$order['cost'] = $orderTotalCost;
		Session::put('ShoppingCart.Order', $order);

	}
	public function calculateProductValue($product_id){

		$product = collect($this->getProduct($product_id));

		$productRepresentativedDiscount = $product['representative_discount'];
		if($productRepresentativedDiscount <= 0){
			$productRepresentativedDiscount = $this->getRepresentativeDiscount();
		}

		$productCustomerDiscount = $product['discount'];
		if($productCustomerDiscount <= 0){
			$productCustomerDiscount = $this->getCustomerDiscount();
		}

		$productAmount = $product['amount'];

		$productCost = $product['product']['cost'];
		$productPrice = $product['product']['price'];

		$gridTotal = $product['grid']['total'];



		$product['cost'] = (($productCost * $gridTotal) * $productAmount);
		$product['price'] = (($productPrice * $gridTotal) * $productAmount);
		$product['discount'] = ($product['price'] * ($productCustomerDiscount / 100));
		$product['representative_commission'] = $product['price'] * ($productRepresentativedDiscount / 100);
		$product['total_discount'] = $product['representative_commission'] + $product['discount'];

		$product['strLine'] = Line::find($product['product']['line_id'])['description'];
		$product['strMaterial'] = Material::find($product['product']['material_id'])['description'];
		$product['strColor'] = Color::find($product['product']['color_id'])['description'];
		$product['strGrid'] = $product['grid']['description'];


		$product['total'] = $product['price'] - $product['total_discount'];

		$this->updateProduct($product);
		return $product;

	}

	public function updateProduct($updatedProduct){
		$product_id = $updatedProduct['product']['id'];
		$products = $this->getProducts()->toArray();
		foreach ($products as $index => $product) {
			if($product['product']['id'] == $product_id){
				$products[$index] = $updatedProduct;
			}
		}

		Session::put('ShoppingCart.products', $products);
	}

	public function setProductRepresentativeDiscount($product_id, $value){

		$products = $this->getProducts()->toArray();
		foreach ($products as $index => $product) {
			if($product['product']['id'] == $product_id){
				$products[$index]['representative_discount'] = $value;
			}
		}
		Session::put('ShoppingCart.products', $products);
		$this->calculateProductsValues();
		return $products;

	}

	public function productExists($product_id){
		$products = $this->getProducts()->toArray();
		foreach ($products as $index => $product) {
			if($product['product']['id'] == $product_id){
				return true;
			}
		}
		return false;
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

		if($this->getBrand()){
			if($this->getBrand()->id != $brand_id){

				return false;
			}
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
		$this->calculateProductsValues();
	}
	public function getRepresentative(){
		$representative_id = Session::get('ShoppingCart.Order.representative_id');
		return Representative::with('user')->find($representative_id);

	}

	public function setCustomer($customer_id){
		Session::put('ShoppingCart.Order.customer_id', $customer_id);
		$this->calculateProductsValues();
	}
	public function getCustomer(){
		$customer_id = Session::get('ShoppingCart.Order.customer_id');
		return Customer::find($customer_id);
	}

	public function setComment($value)
	{
		Session::put('ShoppingCart.Order.comment', $value);
	}

	public function getComment()
	{
		return Session::get('ShoppingCart.Order.comment');
	}

	public function getCustomerDiscount(){
		return Session::get('ShoppingCart.Order.customer_discount');
	}
	public function setCustomerDiscount($value){
		Session::put('ShoppingCart.Order.customer_discount', $value);
		$this->calculateProductsValues();
	}

	public function getRepresentativeDiscount(){
		return Session::get('ShoppingCart.Order.representative_discount');
	}
	public function setRepresentativeDiscount($value){
		Session::put('ShoppingCart.Order.representative_discount', $value);
		$this->calculateProductsValues();
	}
	public function test(){
		echo "ola";
	}

}