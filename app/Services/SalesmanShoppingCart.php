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
				$order['products'] = [];
			}
				$this->order = $order;

			Session::put('ShoppingCart.Order',collect($this->order)->toArray());

			$this->calculateProductsValues();
			return true;
		}else{
			$this->calculateProductsValues();
			return false;
		}
	}
	public function stopShopping(){
		Session::put('ShoppingCart.Order', null);
		$this->startShopping();
	}

	public function loadOrder(Order $order){
		if($order == null){
			$order = new Order();
			$order->status_id = 1;
		}

		Session::put('ShoppingCart.Order',collect($order)->toArray());
		$this->calculateProductsValues();
		return $order;
	}
	public function setOrder($order){
		Session::put('ShoppingCart.Order', $order);
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


		$order = new Order();
		$order->fill($this->getOrder());
		$order->save();
		return $this->saveProducts($order);
		return $order;


	}

	public function saveProducts($order){

		$products = $this->getProducts();
		return $order->products()->sync($products);

	}

	public function setStatus($status_id)
	{
		$order = $this->getOrder();
		$order['status_id'] = $status_id;
		$this->setOrder($order);
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

	public function setProducts($products){
		$order = $this->getOrder();
		$order['products'] = $products;
		$this->setOrder($order);
	}
	public function getProducts(){

		$order = $this->getOrder();
		return collect($order['products'])->toArray();

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

		$product = Product::find($product_id)->toArray();
		$product['pivot']['product_id'] = $product_id;
		$product['pivot']['grid_id'] = $product_id;
		$product['pivot']['grid'] = Grid::find($grid_id);
		$product['pivot']['discount'] = $discount;
		$product['pivot']['amount'] = $amount;
		$product['pivot']['representative_discount'] = $representative_discount;

		$product['pivot']['grid']['total'] = $product['pivot']['grid']->total;

		$order = $this->getOrder();
		$order['products'][] = $product;
		$this->setOrder($order);
		$this->calculateProductsValues();
	}

	public function getProduct($product_id){
		$products = $this->getProducts();
		foreach ($products as $product) {
			if($product['id'] == $product_id){
				return $product;
			}
		}
	}

	public function getProductAmount($product_id){

		$products = $this->getProducts();
		foreach ($products as $product) {
			if($product['id'] == $product_id){
				return $product['pivot']['amount'];
			}
		}
	}

	public function getProductPrice($product_id){

		$products = $this->getProducts();
		foreach ($products as $product) {
			if($product['id'] == $product_id){
				return $product['price'];
			}
		}
	}
	public function setProductAmount($product_id, $value){

		$products = $this->getProducts();
		foreach ($products as $index => $product) {
			if($product['id'] == $product_id){
				$products[$index]['pivot']['amount'] = $value;
			}
		}
		$this->setProducts($products);
		$this->calculateProductsValues();
		return $products;

	}
	public function getProductCustomerDiscount($product_id){

		$products = $this->getProducts();
		foreach ($products as $product) {
			if($product['id'] == $product_id){
				return $product['pivot']['discount'];
			}
		}

	}
	public function setProductCustomerDiscount($product_id, $value){

		$products = $this->getProducts();
		foreach ($products as $index => $product) {
			if($product['id'] == $product_id){
				$products[$index]['pivot']['discount'] = $value;
			}
		}
		$this->setProducts($products);
		$this->calculateProductsValues();
		return $products;

	}

	public function getProductRepresentativeDiscount($product_id){

		$products = $this->getProducts();
		foreach ($products as $product) {
			if($product['id'] == $product_id){
				return $product['pivot']['representative_discount'];
			}
		}

	}
	public function setProductRepresentativeDiscount($product_id, $value){

		$products = $this->getProducts();
		foreach ($products as $index => $product) {
			if($product['id'] == $product_id){
				$products[$index]['representative_discount'] = $value;
			}
		}
		$this->setProducts($products);
		$this->calculateProductsValues();
		return $products;

	}
	public function calculateProductsValues(){

		$orderTotal = 0.00;
		$orderTotalSum = 0.00;
		$orderTotalDiscount = 0.00;
		$orderTotalCost = 0.00;
		$orderTotalRepresentativeComission = 0.00;

		$products = $this->getProducts();
		foreach ($products as $index => $product) {
			$updatedProduct = $this->calculateProductValue($product['id']);
			$orderTotal += $updatedProduct['pivot']['total'];
			$orderTotalSum += $updatedProduct['pivot']['price'];
			$orderTotalDiscount += $updatedProduct['pivot']['total_discount'];
			$orderTotalCost += $updatedProduct['pivot']['cost'];
			$orderTotalRepresentativeComission += $updatedProduct['pivot']['representative_commission'];
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

		$product = $this->getProduct($product_id);

		$productRepresentativeDiscount = $product['pivot']['representative_discount'];
		if($productRepresentativeDiscount <= 0){
			$productRepresentativeDiscount = $this->getRepresentativeDiscount();
		}

		$productCustomerDiscount = $product['pivot']['discount'];
		if($productCustomerDiscount <= 0){
			$productCustomerDiscount = $this->getCustomerDiscount();
		}

		$productAmount = $product['pivot']['amount'];

		$productCost = $product['cost'];
		$productPrice = $product['price'];

		$product['pivot']['grid'] = Grid::find($product['pivot']['grid_id']);
		$gridTotal = $product['pivot']['grid']['total'];



		$product['pivot']['cost'] = (($productCost * $gridTotal) * $productAmount);
		$product['pivot']['price'] = (($productPrice * $gridTotal) * $productAmount);
		$product['pivot']['customer_discount'] = ($product['pivot']['price'] * ($productCustomerDiscount / 100));
		$product['pivot']['representative_commission'] = $product['pivot']['price'] * ($productRepresentativeDiscount / 100);
		$product['pivot']['total_discount'] = $product['pivot']['representative_commission'] + $product['pivot']['discount'];

		$product['pivot']['strLine'] = Line::find($product['line_id'])['description'];
		$product['pivot']['strMaterial'] = Material::find($product['material_id'])['description'];
		$product['pivot']['strColor'] = Color::find($product['color_id'])['description'];
		$product['pivot']['strGrid'] = $product['pivot']['grid']['description'];


		$product['pivot']['total'] = $product['pivot']['price'] - $product['pivot']['total_discount'];

		$this->updateProduct($product);
		return $product;

	}

	public function updateProduct($updatedProduct){
		$product_id = $updatedProduct['id'];
		$products = $this->getProducts();
		foreach ($products as $index => $product) {
			if($product['id'] == $product_id){
				$products[$index] = $updatedProduct;
			}
		}

		$this->setProducts($products);
	}


	public function productExists($product_id){
		$products = $this->getProducts();
		foreach ($products as $index => $product) {
			if($product['id'] == $product_id){
				return true;
			}
		}
		return false;
	}
	public function deleteProduct($product_id){

			$products = collect($this->getProducts());
			$filtered = $products->where('product.id','!=', $product_id);

			$this->setProducts($filtered->toArray());

	}

	public function setBrand($brand_id){
		$order = $this->getOrder();
		$order['brand_id'] = $brand_id;
		$this->setOrder($order);
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

	public function setRepresentative($representative_id){
		$order = $this->getOrder();
		$order['representative_id'] = $representative_id;
		$this->setOrder($order);
		$this->calculateProductsValues();
	}
	public function getRepresentative(){
		$representative_id = Session::get('ShoppingCart.Order.representative_id');
		return Representative::with('user')->find($representative_id);

	}

	public function setCustomer($customer_id){
		$order = $this->getOrder();
		$order['customer_id'] = $customer_id;
		$this->setOrder($order);
		$this->calculateProductsValues();
	}
	public function getCustomer(){
		$customer_id = Session::get('ShoppingCart.Order.customer_id');
		return Customer::find($customer_id);
	}

	public function setComment($value)
	{
		$order = $this->getOrder();
		$order['comment'] = $value;
		$this->setOrder($order);
	}

	public function getComment()
	{
		return Session::get('ShoppingCart.Order.comment');
	}

	public function getCustomerDiscount(){
		return Session::get('ShoppingCart.Order.customer_discount');
	}
	public function setCustomerDiscount($value){
		$order = $this->getOrder();
		$order['customer_discount'] = $value;
		$this->setOrder($order);
		$this->calculateProductsValues();
	}

	public function getRepresentativeDiscount(){
		return Session::get('ShoppingCart.Order.representative_discount');
	}
	public function setRepresentativeDiscount($value){
		$order = $this->getOrder();
		$order['representative_discount'] = $value;
		$this->setOrder($order);
		$this->calculateProductsValues();
	}
	public function test(){
		echo "ola";
	}

}