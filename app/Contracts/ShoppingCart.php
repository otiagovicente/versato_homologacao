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

	public function getOrder();
	public function loadOrder(Order $order);


	public function isOpened();
	public function isClosed();
	public function isNew();
	public function save();

	public function getStatus();
	public function setStatus();

	public function getProducts();
	public function addProduct($product_id, $grid_id ,$amount = 1, $discount = 0.00, $representative_discount = 0.00);
	public function getProductAmount($product_id);
	public function setProductAmount($product_id, $value);
	public function getProductCustomerDiscount($product_id);
	public function setProductCustomerDiscount($product_id, $value);
	public function getProductRepresentativeDiscount($product_id);
	public function setProductRepresentativeDiscount($product_id, $value);
	public function deleteProduct($product_id);

	public function setBrand($brand_id);
	public function checkBrand($product_id);
	public function getBrand();

	public function setCommission($comission = 0.00);
	public function getComission();

	public function setRepresentative($representative_id);
	public function getRepresentative();

	public function setCustomer($customer_id);
	public function getCustomer();

	public function setCustomerDiscount($value);
	public function getCustomerDiscount();
	public function setRepresentativeDiscount($value);
	public function getRepresentativeDiscount();
	public function test();
}


