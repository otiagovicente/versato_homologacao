<?php
/**
 * Created by PhpStorm.
 * User: otiagovicente
 * Date: 21/01/17
 * Time: 19:09
 */

namespace App\Services;
use Illuminate\Support\Facades\Auth;
use App\Contracts\OrderConformer;

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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SalesmanOrderConformer implements OrderConformer {

	protected $order = null;
	protected $products;

	public function order($order = null){
		switch ($order){

			case ($order === null):
				$this->create();
			break;
			case (is_array($order)):
				$this->setOrder($order);
			break;
			case (is_integer($order)):
				$this->open($order);
			break;

		}

		if(!isset($this->order['brands'])){
			$this->order['brands'] = [];
		}
		if(!isset($this->order['products'])){
			$this->order['products'] = [];
		}

//		$this->conform($order);
		return $this;
	}

	public function create(){

		if($this->isClosed()) {

			$order = new Order();
			$order['status_id'] = 1;
			$order['products'] = [];
			$order['brands'] = [];
			$this->updateOrder($order);

		}else{
			$this->calculateProductsValues();
		}

		return $this;
	}

	private function open($order_id){

		$order =  Order::with('products', 'customer', 'representative', 'representative.brands')->find($order_id);

		$this->close();
		if(!isset($order['products'])){
			$order['products'] = [];
		}

		$this->setOrder($order);
		$this->calculateProductsValues();
		return $this;
	}

	public function save(){


		if(!$this->isNew()){
			$order = Order::find($this->get()['id']);
		}else{
			$order = new Order;
		}

		$order->fill($this->get());
		$order->save();
		if($this->hasProducts()){
			$this->saveProducts($order);
		}

		$representative = Representative::find($this->get()['representative_id']);
		$representative->notify(new NewOrderPlaced($order['id']));

		$customer = Customer::find($this->get()['customer_id']);
		$customer->notify(new NewOrderPlaced($order['id']));

		return $this;


	}

	public function conform()
	{
		$this->calculateProductsValues();
		return $this;
	}


	private function setOrder($order){
		$this->order = collect($order)->toArray();

	}

	private function updateOrder($order)
	{
		$this->setOrder($order);
		$this->calculateProductsValues();
		return $this->get();
	}

	public function get(){
		return collect($this->order)->toArray();
	}

	public function isNew(){

		if(isset($this->get()['id'])){
			return false;
		}else{
			return true;
		}

	}
	private function close(){
		$this->order = null;
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

	public function saveBrands($order){

		$brands = $this->getBrands();
		foreach ($brands as $key => $brand) {
			$saveableBrands[$key] = $brand['pivot'];
		}
		return $order->brands()->sync($saveableBrands);

	}

	public function hasProducts(){

		$order = $this->order;
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
		$this->order['status_id'] = $status_id;
	}

	public function getStatus()
	{
		return $this->order['status_id'];
	}

	public function isOpened(){
		$order = $this->order;
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
		$this->order['products'] = collect($products)->toArray();
	}
	public function getProducts(){
		return collect($this->order['products'])->toArray();
	}
	public function addProduct($product_id, $grid_id ,$amount = 1, $customer_discount = 0.00, $representative_discount = 0.00){

		$brand_id = Product::find($product_id)->brand->id;
		$this->addBrand($brand_id);
		if(!$this->checkBrand($product_id)){
			return false;
		}

		if($this->productExists($product_id, $grid_id)){
			dd('é que cai aqui');
			$product = $this->getProduct($product_id, $grid_id);
			$product['pivot']['amount'] += $amount;
			$this->updateProduct($product);
			$this->calculateProductsValues();
			return $product;
		}

		$product = Product::find($product_id)->toArray();
		$product['pivot']['product_id'] = $product_id;
		$product['pivot']['grid_id'] = $grid_id;
		$product['pivot']['grid'] = Grid::find($grid_id);
		$product['pivot']['customer_discount'] = $customer_discount;
		$product['pivot']['amount'] = $amount;
		$product['pivot']['representative_discount'] = $representative_discount;
		$product['pivot']['grid']['total'] = $product['pivot']['grid']->total;

		$order = $this->get();
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


		$total = 0.00; /* Total do pedido a ser pago*/
		$price = 0.00; /* Total do pedido sem descontos*/
		$overalliscount = 0.00; /* Valor total de descontos */
		$cost = 0.00; /* Custo para a empresa do pedido */
		$representativeCommission = 0.00; /* Total de comissão do representante */
		$representativeCommissionDiscount = 0.00; /* Total de comissão perdida no desconto */
		$reoresentativePercentage = 0.00; /* Percentual ganho de comissão no pedido */

		$brands = $this->getBrands();
		foreach($brands as $brand){
			$updatedBrand = $this->calculateBrand($brand['id']);

		}


		$this->order['total'] = $total;
		$this->order['price'] = $price;
		$this->order['representative_commission'] = $representativeCommission;
		$this->order['overalldiscount'] = $overalliscount;
		$this->order['cost'] = $cost;
		$this->order['representative_commission_discount'] = $representativeCommissionDiscount;
		$this->order['representative_percentage'] = $reoresentativePercentage;

	}
	public function calculateBrand($brand_id){

		$products = $this->getBrandProducts($brand_id);
		$brand['total'] = 0.00;
		$brand['price'] = 0.00;
		$brand['discount'] = 0.00;
		$brand['overalldiscount'] = 0.00;
		$brand['cost'] = 0.00;
		$brand['representative_commission'] = 0.00;
		$brand['representative_commission_discount'] = 0.00;
		$brand['representative_percentage'] = 0.00;
		$brand['amount'] = 0;

		foreach ($products as $index => $product) {
			$updated_product = $this->calculateProductValue($product['id'], $product['pivot']['grid_id']);

			$brand['total'] += $updated_product['pivot']['total'];
			$brand['price'] += $updated_product['pivot']['price'];
			$brand['overalldiscount'] += $updated_product['pivot']['total_discount'];
			$brand['cost'] += $updated_product['pivot']['cost'];
			$brand['representative_commission'] += $updated_product['pivot']['representative_commission'];
			$brand['representative_commission_discount'] += $updated_product['pivot']['representative_commission_discount'];
			$brand['discount'] += $updated_product['pivot']['customer_discount'];
			$brand['amount'] += $updated_product['pivot']['amount'];

		}

		$representativePercentage = 0.00;
		$brand['discount'] = 0.00;
		$brand['customer_discount'] = 0.00;
		$brand['representative_percentage'] = $representativePercentage;
		$brand['representative_commission_percentage'] = $representativePercentage;

	}
	public function calculateProductValue($product_id, $grid_id){

		$product = $this->getProduct($product_id, $grid_id);

		if(isset($this->order['representative_id'])){
			$product['pivot']['representative_id'] = $this->order['representative_id'];
		}else{
			$product['pivot']['representative_id'] = Auth::user()->load('representative')['representative']['id'];
		}


		$productRepresentativeDiscount = $product['pivot']['representative_discount'];

		if($productRepresentativeDiscount <= 0){
			if($this->getRepresentativeDiscount()) {
				$productRepresentativeDiscount = $this->getRepresentativeDiscount();
			}else{
				$productRepresentativeDiscount = 0;
			}

		}

		$productCustomerDiscount = $product['pivot']['customer_discount'];
		if($productCustomerDiscount <= 0){
			if($this->getCustomerDiscount()){
				$productCustomerDiscount = $this->getCustomerDiscount();
			}else{
				$productCustomerDiscount = 0;
			}

		}

		$productAmount = $product['pivot']['amount'];
		$representativeBrandCommission = Representative::find($product['pivot']['representative_id'])->brands()->wherePivot('brand_id', $product['brand_id'])->first()['pivot']['commission'];
		$product['pivot']['representative_commission_percentage'] = $representativeBrandCommission - $productRepresentativeDiscount;

		$productCost = $product['cost'];
		$productPrice = $product['price'];

		$product['pivot']['grid'] = Grid::find($product['pivot']['grid_id']);
		$gridTotal = $product['pivot']['grid']['total'];



		$product['pivot']['cost'] = (($productCost * $gridTotal) * $productAmount);
		$product['pivot']['price'] = (($productPrice * $gridTotal) * $productAmount);
		$product['pivot']['discount'] = ($product['pivot']['price'] * ($productCustomerDiscount / 100));
		$product['pivot']['representative_commission_discount'] = $product['pivot']['price'] * ($productRepresentativeDiscount / 100);
		$product['pivot']['representative_commission_percentage'] = $product['pivot']['price'] * ($productRepresentativeDiscount / 100);
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
		return $this;

	}

	/*
	 *   MULTI BRANDS FAZER
	 */

	private function addBrand($brand_id){
		if (!$this->brandExists($brand_id)){
			array_push($this->order['brands'], Brand::find($brand_id));
		}
		return $this;
	}

	private function brandExists($brand_id){

		if(!isset($this->order['brands'])){
			$this->order['brands'] = [];
		}
		$brands = collect($this->order['brands']);
		foreach ($brands as $index => $brand) {
			if($brand['id'] == $brand_id) {
				return $index;
			}
		}
		return false;

	}

	private function checkBrand($product_id)
	{

		$product = Product::with('brand')->find($product_id);
		$brand_id = $product->brand->id;
		return !$this->brandExists($brand_id);

	}

	private function getBrand($brand_id){
		$brands = $this->getBrands();
		foreach ($brands as $brand) {
			if($brand['id'] == $brand_id){
				return $brand;
			}
		}
		return false;
	}

	public function getBrands()
	{
		if(isset($this->order['brands'])){
			return collect($this->order['brands'])->toArray();
		}
		return [];

	}

	public function getBrandProducts($brand_id){
		if(!isset($this->order['products'])){
			return [];
		}
		return collect($this->order['products'])->where('brand_id', $brand_id)->toArray();
	}

	public function setRepresentative($representative_id){
		$this->order['representative_id'] = $representative_id;
		return $this;
	}
	public function getRepresentative(){
		if(!isset($this->order['representative_id'])){
			return false;
		}
		$representative_id = $this->order['representative_id'];
		return Representative::with('user')->find($representative_id);

	}

	public function setCustomer($customer_id){
		$this->order['customer_id'] = $customer_id;
		return $this;
	}
	public function getCustomer(){
		if(!isset($this->order['customer_id'])){
			return false;
		}
		$customer_id = $this->order['customer_id'];
		return Customer::find($customer_id);
	}

	public function setComment($value){
		$this->order['comment'] = $value;
		return $this;
	}

	public function getComment(){
		if(!isset($this->order['comment'])){
			return '';
		}
		return $this->order['comment'];
	}

	public function getDiscount(){
		if(!isset($this->order['discount'])){
			return 0.00;
		}
		return $this->order['discount'];
	}


	public function getCustomerDiscount(){
		if(isset($this->order['customer_discount'])){
			return $this->order['customer_discount'];
		}
		return 0.00;

	}
	public function setCustomerDiscount($value){

		$this->order['customer_discount'] = $value;
		$this->calculateProductsValues();

		return $this;
	}

	public function getRepresentativeDiscount(){
		if(isset($this->order['representative_discount'])){
			return $this->order['representative_discount'];
		}
		return 0.00;
	}
	public function setRepresentativeDiscount($value){
		$this->order['representative_discount'] = $value;
		$this->calculateProductsValues();

		return $this;
	}
}