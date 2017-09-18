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

interface OrderConformer
{

	public function order($order);

	public function get();
	public function isNew();

	public function create();
	public function save();
	public function conform();

	public function getStatus();
	public function setStatus($status_id);

	public function setProducts($products);
	public function getProducts();
    public function addProduct($product_id, $grid_id ,$products_amount = 1, $grids_amount, $company_discount = 0.00, $representative_discount = 0.00, $representative_commission_total = 0.00, $representative_commission_price = 0.00, $representative_commission_company = 0.00 );
	public function getProduct($product_id,$grid_id);
	public function updateProduct($updated_product);
	public function deleteProduct($product_id, $grid_id);


	public function getProductPrice($product_id,$grid_id);
	public function getProductAmount($product_id,$grid_id);
	public function setProductAmount($product_id,$grid_id, $value);
	public function getProductCustomerDiscount($product_id,$grid_id);
	public function setProductCustomerDiscount($product_id,$grid_id, $value);
	public function getProductRepresentativeDiscount($product_id,$grid_id);
	public function setProductRepresentativeDiscount($product_id,$grid_id, $value);

	public function getComment();
	public function setComment($value);


	public function setRepresentative($representative_id);
	public function getRepresentative();

	public function setCustomer($customer_id);
	public function getCustomer();

	public function setCompanyDiscount($value);
	public function getCompanyDiscount();
	public function setRepresentativeDiscount($value);
	public function getRepresentativeDiscount();

}
