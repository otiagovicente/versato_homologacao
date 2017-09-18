<?php
/**
 * Created by PhpStorm.
 * User: otiagovicente
 * Date: 19/12/16
 * Time: 20:23
 */

namespace App\Services;

use App\Contracts\ShoppingCart;
use App\Services\SalesmanOrderConformer;


use App\Order;
use Illuminate\Support\Facades\Session;

class SalesmanShoppingCart implements ShoppingCart{


	protected $order = null;
	protected $products;
	protected $conformer;

	public function __construct()
	{
		$this->conformer = new SalesmanOrderConformer();
	}

	public function startShopping(Order $order = null){
		return $this->updateOrder($this->conformer->order($this->getOrder())->create()->get());
	}
	public function stopShopping(){
		Session::put('ShoppingCart', null);
	}

	public function loadOrder($order){
		return $this->setOrder($this->conformer->order($order)->get());
	}
	public function setOrder($order){
		Session::put('ShoppingCart.order', collect($order)->toArray());
		return collect($order)->toArray();
	}

	public function updateOrder($order)
	{
		return $this->setOrder($this->conformer->order($order)->get());
	}

	public function getOrder(){
		return collect(Session::get('ShoppingCart.order'))->toArray();
	}

	public function isNew(){
		return $this->conformer->order($this->getOrder())->isNew();
	}
	public function save(){
		return $this->conformer->order($this->getOrder())->save()->get();
	}

	public function setStatus($status_id){
		return $this->setOrder($this->conformer->order($this->getOrder())->setStatus($status_id)->get());
	}

	public function getStatus(){
		return $this->conformer->order($this->getOrder())->getStatus();
	}

	public function isOpened(){
		return $this->conformer->order($this->getOrder())->isOpened();
	}

	public function isClosed(){
		return (!$this->isOpened());
	}

	public function getProducts(){
        return collect(Session::get('ShoppingCart.products'));
		//return $this->conformer->order($this->getOrder())->getProducts();

	}
    public function addProduct($product_id, $grid_id ,$products_amount = 1, $grids_amount, $company_discount = 0.00, $representative_discount = 0.00, $representative_commission_total = 0.00, $representative_commission_price = 0.00, $representative_commission_company = 0.00 ){

//		if($this->conformer->order(Order::with('products', 'representative.brands', 'customer')->first()->toArray())->addProduct($product_id, $grid_id ,$amount, $discount, $representative_discount)){
		if($this->conformer->order($this->getOrder())->addProduct($product_id, $grid_id ,$products_amount, $grids_amount, $company_discount, $representative_discount, $representative_commission_total, $representative_commission_company)){
			$this->setOrder($this->conformer->get());
		}
		return false;
	}

	public function getProduct($product_id, $grid_id){
		return $this->conformer->order($this->getOrder())->getProduct($product_id, $grid_id);
	}

	public function getProductAmount($product_id, $grid_id){
		return $this->conformer->order($this->getOrder())->getProductAmount($product_id, $grid_id);
	}

	public function getProductPrice($product_id, $grid_id){
		return $this->conformer->order($this->getOrder())->getProductPrice($product_id, $grid_id);

	}
	public function setProductAmount($product_id, $grid_id, $value){
		$this->setOrder($this->conformer->order($this->getOrder())->setProductAmount($product_id, $grid_id, $value)->get());
	}
	public function getProductCustomerDiscount($product_id, $grid_id){

		return $this->conformer->order($this->getOrder())->getCustomerDiscount($product_id, $grid_id);

	}
	public function setProductCustomerDiscount($product_id, $grid_id, $value){
		$this->setOrder($this->conformer->order($this->getOrder())->setProductCustomerDiscount($product_id, $grid_id, $value)->get());
	}

	public function getProductRepresentativeDiscount($product_id, $grid_id){
		return $this->conformer->order($this->getOrder())->getProductCustomerDiscount($product_id, $grid_id);
	}

	public function setProductRepresentativeDiscount($product_id, $grid_id, $value){
		$this->setOrder($this->conformer->order($this->getOrder())->setProductRepresentativeDiscount($product_id, $grid_id, $value)->get());
	}


	public function deleteProduct($product_id, $grid_id){
		$this->setOrder($this->conformer->order($this->getOrder())->deleteProduct($product_id, $grid_id)->get());
	}


	public function setRepresentative($representative_id){
		$this->setOrder($this->conformer->order($this->getOrder())->setRepresentative($representative_id)->get());
	}

	public function getRepresentative(){
		return $this->conformer->order($this->getOrder())->getRepresentative();
	}

	public function setCustomer($customer_id){
		$this->setOrder($this->conformer->order($this->getOrder())->setCustomer($customer_id)->get());
	}

	public function getCustomer(){
		return $this->conformer->order($this->getOrder())->getCustomer();
	}

	public function setComment($value){
		$this->setOrder($this->conformer->order($this->getOrder())->setComment($value)->get());
	}

	public function getComment(){
		return $this->conformer->order($this->getOrder())->getComment();
	}

	public function getCustomerDiscount(){
		return $this->conformer->order($this->getOrder())->getCustomerDiscount();
	}

	public function setCustomerDiscount($value){
		$this->setOrder($this->conformer->order($this->getOrder())->setCustomerDiscount($value)->get());
	}

	public function getRepresentativeDiscount(){
		return $this->conformer->order($this->getOrder())->getRepresentativeDiscount();
	}
	public function setRepresentativeDiscount($value){
		$this->setOrder($this->conformer->order($this->getOrder())->setRepresentativeDiscount($value)->get());
	}

}
