<?php
/**
 * Created by PhpStorm.
 * User: otiagovicente
 * Date: 19/12/16
 * Time: 20:23
 */

namespace App\Services;

use App\Contracts\ShoppingCart;

use App\Notifications\NewOrderPlaced;

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
use Illuminate\Support\Facades\DB;

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
			if(!isset($order['products'])){
				$order['products'] = [];
			}

			Session::put('ShoppingCart.Order',collect($order)->toArray());

			$this->calculateProductsValues();
			return true;
		}else{
			$this->calculateProductsValues();
			return false;
		}
	}
	public function stopShopping(){
		Session::put('ShoppingCart', null);
	}

	public function loadOrder($order_id){

		$order =  Order::with('products', 'customer', 'representative')->find($order_id);

		$this->stopShopping();
		if(!isset($order['products'])){
			$order['products'] = [];
		}

		$this->setOrder($order);
		$this->calculateProductsValues();
		return $this->getOrder();
	}
	public function setOrder($order){
		Session::put('ShoppingCart.Order', collect($order)->toArray());
	}

	public function updateOrder($order)
	{
		$this->setOrder($order);
		$this->calculateProductsValues();
		return $this->getOrder();
	}

	public function getOrder(){
		return collect(Session::get('ShoppingCart.Order'))->toArray();
	}

	public function isNew(){

		if(isset($this->getOrder()['id'])){
			return false;
		}else{
			return true;
		}

	}
	public function save(){


		if(!$this->isNew()){
			$order = Order::find($this->getOrder()['id']);
		}else{
			$order = new Order;
		}

		$order->fill($this->getOrder());
		$order->save();
		if($this->hasProducts()){
			 $this->saveProducts($order);
		}

		$representative = Representative::find($this->getOrder()['representative_id']);
		$representative->notify(new NewOrderPlaced($order['id']));

		$customer = Customer::find($this->getOrder()['customer_id']);
		$customer->notify(new NewOrderPlaced($order['id']));

		return $order;


	}
	public function saveProducts($order){

		$products = $this->getProducts();
		foreach ($products as $key => $product) {
			unset($product['pivot']['grid']);
			$saveableProducts[$key] = $product['pivot'];
		}
		DB::table('order_product')->where('order_id', '=', $order['id'])->delete();
		return $order->products()->attach($saveableProducts);

	}

	public function hasProducts(){

		$order = Session::get('ShoppingCart.Order');
		if(isset($order['products'])){
			return count($order['products']);
		}else{
			$order['products'] = [];
			$this->setOrder($order);
			return false;
		}
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
		$order = Session::get('ShoppingCart.Order');
		if(isset($order)){
			return true;
		}else{
			return false;
		}
	}
	public function isClosed(){
		return (!$this->isOpened());
	}

	public function setProducts($products){
		Session::put('ShoppingCart.Order.products',  collect($products)->toArray());
	}
	public function getProducts(){
		return collect(Session::get('ShoppingCart.Order.products'))->toArray();

	}
	public function addProduct($product_id, $grid_id ,$amount = 1, $discount = 0.00, $representative_discount = 0.00){

		if($this->startShopping()){


			$brand_id = Product::find($product_id)->brand->id;

			$this->setBrand($brand_id);
		}

		if(!$this->checkBrand($product_id)){
			return false;
		}

		if($this->productExists($product_id, $grid_id)){
			$product = $this->getProduct($product_id, $grid_id);
			if($product['pivot']['grid_id'] == $grid_id){
				$product['pivot']['amount'] += $amount;
				$this->updateProduct($product);
				$this->calculateProductsValues();
				return $product;
			}
		}

		$product = Product::find($product_id)->toArray();
		$product['pivot']['product_id'] = $product_id;
		$product['pivot']['grid_id'] = $grid_id;
		$product['pivot']['grid'] = Grid::find($grid_id);
		$product['pivot']['discount'] = $discount;
		$product['pivot']['amount'] = $amount;
		$product['pivot']['representative_discount'] = $representative_discount;

		$product['pivot']['grid']['total'] = $product['pivot']['grid']->total;

		$order = $this->getOrder();
		$order['products'][] = $product;
		$this->setOrder($order);

		$this->calculateProductsValues();

		return $product;
	}

	public function getProduct($product_id, $grid_id){
		$products = $this->getProducts();
		foreach ($products as $product) {
			if(($product['id'] == $product_id) && ($product['pivot']['grid_id'] == $grid_id)){
				return $product;
			}
		}
		return false;
	}

	public function getProductAmount($product_id, $grid_id){

		$product = $this->getProduct($product_id, $grid_id);
		return $product['pivot']['amount'];
	}

	public function getProductPrice($product_id, $grid_id){

		$product = $this->getProduct($product_id, $grid_id);
		return $product['price'];

	}
	public function setProductAmount($product_id, $grid_id, $value){

		$product = $this->getProduct($product_id, $grid_id);
		$product['pivot']['amount'] = $value;

		$this->updateProduct($product);

		$this->calculateProductsValues();
	}
	public function getProductCustomerDiscount($product_id, $grid_id){

		$product = $this->getProduct($product_id, $grid_id);
		return $product['pivot']['discount'];

	}
	public function setProductCustomerDiscount($product_id, $grid_id, $value){

		$product = $this->getProduct($product_id, $grid_id);
		$product['pivot']['discount'] = $value;

		$this->updateProduct($product);

		$this->calculateProductsValues();


	}

	public function getProductRepresentativeDiscount($product_id, $grid_id){
		$product = $this->getProduct($product_id, $grid_id);
		return $product['pivot']['representative_discount'];
	}

	public function setProductRepresentativeDiscount($product_id, $grid_id, $value){

		$product = $this->getProduct($product_id, $grid_id);
		$product['pivot']['representative_discount'] = $value;

		$this->updateProduct($product);

		$this->calculateProductsValues();

	}
	public function calculateProductsValues(){

		$orderTotal = 0.00;
		$orderTotalSum = 0.00;
		$orderTotalDiscount = 0.00;
		$orderTotalCost = 0.00;
		$orderTotalRepresentativeComission = 0.00;

		$products = $this->getProducts();

		foreach ($products as $index => $product) {
			$updated_product = $this->calculateProductValue($product['id'], $product['pivot']['grid_id']);
			$orderTotal += $updated_product['pivot']['total'];
			$orderTotalSum += $updated_product['pivot']['price'];
			$orderTotalDiscount += $updated_product['pivot']['total_discount'];
			$orderTotalCost += $updated_product['pivot']['cost'];
			$orderTotalRepresentativeComission += $updated_product['pivot']['representative_commission'];
		}

		$order = $this->getOrder();
		$order['total'] = $orderTotal;
		$order['price'] = $orderTotalSum;
		$order['representative_commission'] = $orderTotalRepresentativeComission;
		$order['overalldiscount'] = $orderTotalDiscount;
		$order['cost'] = $orderTotalCost;

		$this->setOrder($order);

	}
	public function calculateProductValue($product_id, $grid_id){

		$product = $this->getProduct($product_id, $grid_id);

		$product['pivot']['representative_id'] = Session::get('ShoppingCart.Order.representative_id');
		$productRepresentativeDiscount = $product['pivot']['representative_discount'];

		if($productRepresentativeDiscount <= 0){
			if($this->getRepresentativeDiscount()) {
				$productRepresentativeDiscount = $this->getRepresentativeDiscount();
			}else{
				$productRepresentativeDiscount = 0;
			}

		}

		$productCustomerDiscount = $product['pivot']['discount'];
		if($productCustomerDiscount <= 0){
			if($this->getCustomerDiscount()){
				$productCustomerDiscount = $this->getCustomerDiscount();
			}else{
				$productCustomerDiscount = 0;
			}

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

	public function updateProduct($updated_product){
		$product_id = $updated_product['id'];
		$grid_id = $updated_product['pivot']['grid_id'];
		$products = $this->getProducts();
		foreach ($products as $index => $product) {
			if(($product['id'] == $product_id) && ($product['pivot']['grid_id'] == $grid_id)){
				$products[$index] = $updated_product;
			}
		}


		$this->setProducts($products);
	}


	public function productExists($product_id, $grid_id){
		$products = $this->getProducts();
		foreach ($products as $index => $product) {
			if(($product['id'] == $product_id) && ($product['pivot']['grid_id'] == $grid_id)){
				return $index;
			}
		}
		return false;
	}
	public function deleteProduct($product_id, $grid_id){


			$products = collect($this->getProducts());
			$products->pull($this->productExists($product_id, $grid_id));
			$this->setProducts($products->toArray());
			$this->calculateProductsValues();

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
	}
	public function getRepresentative(){
		$representative_id = Session::get('ShoppingCart.Order.representative_id');
		return Representative::with('user')->find($representative_id);

	}

	public function setCustomer($customer_id){
		$order = $this->getOrder();
		$order['customer_id'] = $customer_id;
		$this->setOrder($order);
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