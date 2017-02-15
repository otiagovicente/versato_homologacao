<?php
/**
 * Created by PhpStorm.
 * User: otiagovicente
 * Date: 19/12/16
 * Time: 20:09
 */

namespace App\Contracts;

use App\Representative;
use App\Order;
use App\Product;
use App\Customer;
use App\Grid;
use App\Brand;

interface ShoppingCart{

	public function startShopping(Order $order = null);
	public function stopShopping();

	public function loadOrder($order_id);
	public function setOrder($order);

	public function updateOrder($order);

	public function getOrder();

	public function isNew();
	public function save();

	public function setStatus($status_id);
	public function getStatus();

	public function isOpened();

	public function isClosed();
	public function getProducts();
	public function getProduct($product_id, $grid_id);
	public function addProduct($product_id, $grid_id ,$amount = 1, $customer_discount = 0.00, $representative_discount = 0.00);
	public function deleteProduct($product_id, $grid_id);

	public function getProductAmount($product_id, $grid_id);
	public function getProductPrice($product_id, $grid_id);
	public function setProductAmount($product_id, $grid_id, $value);
	public function getProductCustomerDiscount($product_id, $grid_id);
	public function setProductCustomerDiscount($product_id, $grid_id, $value);
	public function getProductRepresentativeDiscount($product_id, $grid_id);
	public function setProductRepresentativeDiscount($product_id, $grid_id, $value);


	public function setRepresentative($representative_id);
	public function getRepresentative();

	public function setCustomer($customer_id);
	public function getCustomer();

	public function setComment($value);
	public function getComment();

	public function getCustomerDiscount();
	public function setCustomerDiscount($value);

	public function getRepresentativeDiscount();
	public function setRepresentativeDiscount($value);


}


