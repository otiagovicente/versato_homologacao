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
        if($order == null)
            $this->create();
	    else
	        $this->setOrder($order);


		if(!isset($this->order['brands'])){
			$this->order['brands'] = [];
		}
		if(!isset($this->order['products'])){
			$this->order['products'] = [];
		}

		$this->conform($order);
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
			$this->calculateValues();
		}

		return $this;
	}

	private function open($order_id){

		$order =  Order::find($order_id);

		$this->close();
		if(!isset($order['products'])){
			$order['products'] = [];
		}

		$this->setOrder($order);
		$this->calculateValues();
		//return $this;
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

		//$representative = Representative::find($this->get()['representative_id']);
		//$representative->notify(new NewOrderPlaced($order['id']));

		//$customer = Customer::find($this->get()['customer_id']);
		//$customer->notify(new NewOrderPlaced($order['id']));

		return $this;


	}

	public function conform()
	{
		$this->calculateValues();
		return $this;
	}

	private function setOrder($order){
		if(!isset($order['products']) and $order['id'] != null){
			 $order['products'] = Order::find($order['id'])->products;
		}

		$this->order = collect($order)->toArray();
		return $this;
	}

	private function updateOrder($order)
	{
		$this->setOrder($order);
		$this->calculateValues();
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
        //return collect(Session::get('ShoppingCart.products'));

        return collect($this->order['products'])->toArray();
	}
    public function addProduct($product_id, $grid_id ,$products_amount = 1, $grids_amount, $company_discount = 0.00, $representative_discount = 0.00, $representative_commission_total = 0.00, $representative_commission_price = 0.00, $representative_commission_company = 0.00 ){

		$brand_id = Product::find($product_id)->brand->id;
		$this->addBrand($brand_id);
		if(!$this->checkBrand($product_id)){
			return false;
		}


		if($this->productExists($product_id, $grid_id)){
			$product = $this->getProduct($product_id, $grid_id);
			$product['pivot']['products_amount'] += $products_amount;
			$this->updateProduct($product);
			$this->calculateValues();
			return $product;
		}

		$product = Product::find($product_id)->toArray();
		$product['pivot']['product_id'] = $product_id;
		$product['pivot']['grid_id'] = $grid_id;
		$product['pivot']['grid'] = Grid::find($grid_id);
		$product['pivot']['company_discount'] = $company_discount;
		$product['pivot']['products_amount'] = $products_amount;
        $product['pivot']['grids_amount'] = $grids_amount;
		$product['pivot']['representative_discount'] = $representative_discount;
		$product['pivot']['representative_commission_total'] = $representative_commission_total;
        $product['pivot']['representative_commission_price'] = $representative_commission_price;
        $product['pivot']['representative_commission_company'] = Representative::find($this->order['representative_id'])->brands->find($brand_id)->pivot['commission'];
        $product['pivot']['representative_commission_percentage'] = 0;

        $order = $this->get();
		$order['products'][] = $product;
		$this->setOrder($order);

        Session::push('ShoppingCart.products', $product);

		$this->calculateValues();

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

		$this->calculateValues();
	}
	public function getProductCustomerDiscount($product_id, $grid_id){

		$product = $this->getProduct($product_id, $grid_id);
		return $product['pivot']['discount'];

	}
	public function setProductCustomerDiscount($product_id, $grid_id, $value){

		$product = $this->getProduct($product_id, $grid_id);
		$product['pivot']['discount'] = $value;

		$this->updateProduct($product);

		$this->calculateValues();


	}

	public function getProductRepresentativeDiscount($product_id, $grid_id){
		$product = $this->getProduct($product_id, $grid_id);
		return $product['pivot']['representative_discount'];
	}

	public function setProductRepresentativeDiscount($product_id, $grid_id, $value){

		$product = $this->getProduct($product_id, $grid_id);
		$product['pivot']['representative_discount'] = $value;

		$this->updateProduct($product);

		$this->calculateValues();

	}
	public function calculateValues(){

        if (!isset($this->order['representative_discount'])){
            $this->order['representative_discount'] = 0;
        }

        if (!isset($this->order['company_discount'])){
            $this->order['company_discount'] = 0;
        }


        //Declarando order
        $this->order['cost'] = 0; // é a soma do custo de todos os produtos
        $this->order['price'] = 0; // é a soma do preço de totos os produtos
        $this->order['representative_commission_total'] = 0; // total à receber pelo representante
        $this->order['representative_commission_discount'] = 0; // valor total sedido pelo representate
        $this->order['representative_commission_percentage'] = 0; // porcentagem ganha pelo representante
        $this->order['representative_commission_price'] = 0; // total sem desconto
        $this->order['grids_amount'] = 0; //
        $this->order['products_amount'] = 0; // soma de todas as quantidades
        $this->order['representative_commission_company'] = 0;
        $this->order['total_without_discount'] = 0; //total sem desconto
        $this->order['total'] = 0; //valor total
        $this->order['company_total_discount'] = 0; // valor total de desconto da empresa
        $this->order['total_discount'] = 0; //soma dos descontos
        $this->order['company_real_discount'] = 0; //porcentagem real de desconto


        $products = $this->order['products'];
	    for ($i=0; $i< count($products); $i++){

            //pegando representative_discount geral se o do produto estiver nulo
            if ($products[$i]['pivot']['representative_discount'] == null){
                $products[$i]['pivot']['representative_discount'] = $this->order['representative_discount'];
            }

            //pegando company_discount geral se o do produto estiver nulo
            if ($products[$i]['pivot']['company_discount'] == null){
                $products[$i]['pivot']['company_discount'] = $this->order['company_discount'];
            }

            //calculos basicos
            $products[$i]['pivot']['total_without_discount'] = $products[$i]['price'] * $products[$i]['pivot']['products_amount'];
            $products[$i]['pivot']['representative_commission_percentage'] = $products[$i]['pivot']['representative_commission_company'] - $products[$i]['pivot']['representative_discount'];
            $products[$i]['pivot']['representative_commission_total'] = $products[$i]['pivot']['total_without_discount'] * $products[$i]['pivot']['representative_commission_percentage']/100;
            $products[$i]['pivot']['representative_commission_discount'] = $products[$i]['pivot']['total_without_discount'] * $products[$i]['pivot']['representative_discount']/100;
            $products[$i]['pivot']['representative_commission_price'] = $products[$i]['pivot']['total_without_discount'] * $products[$i]['pivot']['representative_commission_company']/100;
            $products[$i]['pivot']['company_total_discount'] = $products[$i]['pivot']['total_without_discount'] * $products[$i]['pivot']['company_discount']/100;
            $products[$i]['pivot']['cost'] = $products[$i]['cost'] * $products[$i]['pivot']['products_amount'];
            $products[$i]['pivot']['price'] = $products[$i]['price'] * $products[$i]['pivot']['products_amount'];
            $products[$i]['pivot']['total'] = $products[$i]['pivot']['total_without_discount'] - $products[$i]['pivot']['company_total_discount'] - $products[$i]['pivot']['representative_commission_discount'];

            //soma de produtos pra ordem
            $this->order['cost'] = $this->order['cost'] + $products[$i]['pivot']['cost'];
            $this->order['price'] = $this->order['price'] + $products[$i]['pivot']['price'];
            $this->order['representative_commission_total'] = $this->order['representative_commission_total'] + $products[$i]['pivot']['representative_commission_total'];
            $this->order['representative_commission_discount'] = $this->order['representative_commission_discount'] + $products[$i]['pivot']['representative_commission_discount'];
            $this->order['representative_commission_price'] = $this->order['representative_commission_price'] + $products[$i]['pivot']['representative_commission_price'];
            $this->order['products_amount'] = $this->order['products_amount'] + $products[$i]['pivot']['products_amount'];
            $this->order['total_without_discount'] = $this->order['total_without_discount'] + $products[$i]['pivot']['total_without_discount'];;
            $this->order['total'] = $this->order['total'] + $products[$i]['pivot']['total'];
            $this->order['company_total_discount'] = $this->order['company_total_discount'] + $products[$i]['pivot']['company_total_discount'];

	        // maximo de desconto possivel
	        if($products[$i]['pivot']['representative_commission_company'] >= $this->order['representative_commission_company'])
                $this->order['representative_commission_company'] = $products[$i]['pivot']['representative_commission_company'];
         }

        //calculos basicos ordem
        if ($this->order['total_without_discount'] != 0) {
            $this->order['representative_commission_percentage'] = $this->order['representative_commission_total'] * 100 / $this->order['total_without_discount'];
            $this->order['total_discount'] = $this->order['representative_commission_discount'] + $this->order['company_total_discount'];
            $this->order['company_real_discount'] = $this->order['company_total_discount'] * 100 / $this->order['total_without_discount'];
            $this->order['products'] = $products;
        }
    }
	public function calculateBrand($brand_id){

		$products = $this->getBrandProducts($brand_id);
		$brand['total'] = 0.00;
		$brand['price'] = 0.00;
		$brand['cost'] = 0.00;
		$brand['representative_discount'] = 0.00;
		$brand['representative_commission_total'] = 0.00;
		$brand['representative_commission_discount'] = 0.00;
		$brand['representative_commission_price'] = 0.00;
		$brand['representative_commission_percentage'] = 0.00;
		$brand['representative_commission_company'] = 0.00;
		$brand['grids_amount'] = 0;
		$brand['products_amount'] = 0;

		foreach ($products as $index => $product) {
			$updated_product = $this->calculateProductValue($product['id'], $product['pivot']['grid_id']);

			$brand['total'] += $updated_product['pivot']['total'];;
			$brand['price'] += $updated_product['pivot']['price'];
            $brand['cost'] += $updated_product['pivot']['cost'];
			$brand['representative_discount'] += $updated_product['pivot']['representative_discount'];
			$brand['representative_commission_total'] += $updated_product['pivot']['representative_commission_total'];
			$brand['representative_commission_discount'] += $updated_product['pivot']['representative_commission_discount'];
            $brand['representative_commission_price'] += $updated_product['pivot']['representative_commission_price'];
			$brand['representative_commission_percentage'] += $updated_product['pivot']['representative_commission_percentage'];
			$brand['grids_amount'] += $updated_product['pivot']['grids_amount'];
            $brand['products_amount'] += $updated_product['pivot']['products_amount'];
            $brand['representative_commission_company'] = $updated_product['pivot']['representative_commission_company'];

		}

        return $brand;
	}
	public function calculateProductValue($product_id, $grid_id){

		$product = $this->getProduct($product_id, $grid_id);

		if(isset($this->order['representative_id'])){
			$product['pivot']['representative_id'] = $this->order['representative_id'];
		}else{
			$product['pivot']['representative_id'] = Auth::user()->load('representative')['representative']['id'];
		}


		$representativeDiscount = $product['pivot']['representative_discount'];

		if($representativeDiscount <= 0){
			if($this->getRepresentativeDiscount()) {
				$representativeDiscount = $this->getRepresentativeDiscount();
			}else{
				$representativeDiscount = 0;
			}

		}

		$companyDiscount = $product['pivot']['company_discount'];
		if($companyDiscount <= 0){
			if($this->getCompanyDiscount()){
                $companyDiscount = $this->getCompanyDiscount();
			}else{
                $companyDiscount = 0;
			}

		}

		$productAmount = $product['pivot']['grids_amount'];

        $product['pivot']['representative_commission_company'] = Representative::find($product['pivot']['representative_id'])->brands()->wherePivot('brand_id', $product['brand_id']);
        //dd($product['pivot']['representative_commission_company']);
		//$product['pivot']['representative_commission_percentage'] =  - $representativeDiscount;

		$productCost = $product['cost'];
		$productPrice = $product['price'];

		$product['pivot']['grid'] = Grid::find($product['pivot']['grid_id']);
		$gridTotal = $product['pivot']['grid']['total'];



		$product['pivot']['cost'] = (($productCost * $gridTotal) * $productAmount);
		$product['pivot']['price'] = (($productPrice * $gridTotal) * $productAmount);
		$product['pivot']['discount'] = ($product['pivot']['price'] * ($companyDiscount / 100));
		$product['pivot']['representative_commission_discount'] = $product['pivot']['price'] * ($representativeDiscount / 100);
		$product['pivot']['representative_commission_percentage'] = $product['pivot']['price'] * ($representativeDiscount / 100);
		$product['pivot']['total_discount'] = $product['pivot']['representative_commission_discount'] + $product['pivot']['discount'];

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
		$this->calculateValues();
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


	public function getCompanyDiscount(){
		if(isset($this->order['company_discount'])){
			return $this->order['company_discount'];
		}
		return 0.00;

	}
	public function setCompanyDiscount($value){

		$this->order['company_discount'] = $value;
		$this->calculateValues();

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
		$this->calculateValues();

		return $this;
	}
}
