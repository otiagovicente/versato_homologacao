<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use App\Http\RequestsOrder;
use App\Order;
use App\Mail\NewOrderMail;
use League\Flysystem\Exception;
use Mail;
use Illuminate\Support\Facades\DB;
use Excel;

class OrdersController extends Controller
{
	public function index(Request $request)
	{
		$orders = Order::with('products')
			->with('representative')
			->with('customer')
			->paginate(20);
		if($request->ajax()){
			return response()->json($orders);
		}
		return view('orders.index');
	}
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('orders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        $order = new Order;
        $order->fill($request->all());
        $order->save();
        $order->products()->sync($request->products);

        $this->sendNewOrderMail($order->id);
        return response()->json($order);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        return view('orders.edit', compact('order'));
    }
    public function reportByCustomer(){

        return view('orders.reports.byCustomer');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @ret/urn \Illuminate\Http\Response
     */
    public function update(OrderRequest $request, Order $order)
    {
        $order->fill($request->all());
        $order->save();
        $order->products()->sync($request->products);
        return response()->json($order);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {

    }


    /**
     * @param $id
     */
    public function sendNewOrderMail($id){
        $order = Order::
        with('products', 'representative', 'customer')
            ->find($id);
        
        if($order->representative && $order->representative->user && $order->representative->user->email){
            Mail::to($order->representative->user->email)->send(new NewOrderMail($order));    
        }else{
            Mail::to('jorge@magnaestrategia.com')->send(new NewOrderMail($order));
            Mail::to('bruno@magnaestrategia.com')->send(new NewOrderMail($order));
            Mail::to('roger@magnaestrategia.com')->send(new NewOrderMail($order));
            Mail::to('tiago@magnaestrategia.com')->send(new NewOrderMail($order));    
        }
        
        if($order->customer && $order->customer->email){
            Mail::to($order->customer->email)->send(new NewOrderMail($order));
        }else{
            Mail::to('jorge@magnaestrategia.com')->send(new NewOrderMail($order));
            Mail::to('bruno@magnaestrategia.com')->send(new NewOrderMail($order));
            Mail::to('roger@magnaestrategia.com')->send(new NewOrderMail($order));
            Mail::to('tiago@magnaestrategia.com')->send(new NewOrderMail($order));
        }
    }

   public function api_list(){
        $orders = Order::all();
        return $orders;
    }
    public function api_selectList(){
        $orders = Order::all();
        foreach($orders as $order){
            $selectItem['value'] = $order->id;
            $selectItem['label'] = $order->name;
            $selectList[] = $selectItem;
        }
        return response()->json($selectList);
    } 

    public function api_listByRepresentive($idRepresentative){
        $orders = Order::
                    with('OrderProducts')
                    ->where('representative_id',$idRepresentative)
                    ->get();

        return response()->json($orders);
    }
    public function api_getProducts($id){
        $order = Order::with('products')->where('id', $id)->get();
        return response()->json($order);
    }
    public function api_listOrdersByRepresentative($id){
        $orders = Order::where('representative_id', $id)
            ->with('products', 'representative', 'customer')
            ->get();
        return response()->json($orders);
    }
    
    public function api_getOrdersByBrand($dtInicio, $dtFim){
        $totalOrdersByBrand = Order::
                                select('brands.name', DB::raw('SUM(order_product.total) as Total, COUNT(order_product.code) as qtd_pedidos'))
                                ->join('order_product', 'orders.id', '=', 'order_product.order_id')                       
                                ->join('products', 'products.id', '=', 'order_product.product_id')
                                ->join('brands', 'brands.id', '=', 'products.brand_id')
                                ->whereBetween('order_product.created_at', [$dtInicio, $dtFim])
                                ->groupBy('brands.id')
                                ->get();
        
        return response()->json($totalOrdersByBrand);
    }
    public function api_getOrdersByCustomer($dtInicio, $dtFim){
        $totalOrdersByCustomer = Order::
                                select('customers.name', DB::raw('SUM(orders.total) as Total, COUNT(orders.id) as qtd_pedidos'))
                                ->join('order_product', 'orders.id', '=', 'order_product.order_id')
                                ->join('customers', 'customers.id', '=', 'orders.customer_id')                       
                                ->whereBetween('orders.created_at', [$dtInicio, $dtFim])
                                ->groupBy('orders.customer_id')
                                ->get();
        return response()->json($totalOrdersByCustomer);
    }
    public function api_getOrdersByRepresentative($dtInicio, $dtFim){
        $totalOrdersByRepresentative = Order::
                                select('users.name', DB::raw('SUM(orders.total) as Total, COUNT(orders.id) as qtd_pedidos'))
                                ->join('order_product', 'orders.id', '=', 'order_product.order_id')
                                ->join('representatives', 'representatives.id', '=', 'orders.representative_id')
                                ->join('users', 'users.id', '=', 'representatives.user_id')                       
                                ->whereBetween('orders.created_at', [$dtInicio, $dtFim])
                                ->groupBy('representatives.id')
                                ->get();
        return response()->json($totalOrdersByRepresentative);
    }
    public function api_getOrderListByBrand($dtInicio, $dtFim, $idBrand){
        $ordersListByBrand = Order::where('brand_order.brand_id', $idBrand)
                                ->join('brand_order', 'orders.id', '=', 'brand_order.order_id')
                                ->join('brand', 'brand.id', '=', 'brand_order.brand_id')
                                ->whereBetween('orders.created_at', [$dtInicio, $dtFim])
                                ->get();
        return response()->json($ordersListByBrand);
    }
    public function api_getOrderTotalByRegion($dtInicio, $dtFim){
        $ordersListByRegion = Order::select('regions.description', DB::raw('regions.id, SUM(orders.total) as Total, COUNT(orders.id) as qtd_pedidos'))
                                ->join('customers', 'customers.id', '=', 'orders.customer_id')
                                ->join('regions', 'regions.id', '=', 'customers.region_id')
                                ->whereBetween('orders.created_at', [$dtInicio, $dtFim])
                                ->groupBy('regions.description')
                                ->groupBy('regions.id')
                                ->get();
        return response()->json($ordersListByRegion);
    }
    public function api_getOrderListByRegion($dtInicio, $dtFim, $idRegion){
        $ordersListByRegion = Order::
                                join('customers', 'customers.id', '=', 'orders.customer_id')
                                ->join('regions', 'regions.id', '=', 'customers.region_id')
                                ->where('regions.id', $idRegion)
                                ->whereBetween('orders.created_at', [$dtInicio, $dtFim])
                                ->with('products', 'representative', 'customer')
                                ->get();
        return response()->json($ordersListByRegion);
    }
    
    public function api_exportListOrdersByDate($dtInicio, $dtFim){
        $ordersList = Order::whereBetween('orders.created_at', [$dtInicio, $dtFim])
                                ->with('products', 'customer')
                                ->get();
        $arrData = [];
        foreach ($ordersList as $order) {
            foreach ($order->products as $product) {
                array_push($arrData, [$order->id, $order->customer->code, $product->code, $product->pivot->amount, $product->pivot->total]);
            }
        }
        return response()->json($arrData);
    }
    public function api_exportOrdersByDate($dtInicio, $dtFim){
        $ordersList = Order::whereBetween('orders.created_at', [$dtInicio, $dtFim])
                                ->with('products', 'customer')
                                ->get();
        return Excel::create('orders', function($excel) use ($ordersList) {
			$excel->sheet('pedidos', function($sheet) use ($ordersList)
	        {
                $intI = 1;
                $sheet->row($intI++, array(
                    'NUMERO', 'CLIENTE', 'COD_ALFA', 'CANTIDAD', 'PRECIO'
                ));
				foreach ($ordersList as $order) {
                    foreach ($order->products as $product) {
                        $sheet->row($intI++, array(
                            $order->id, $order->customer->code, $product->code, $product->pivot->amount, $product->pivot->total
                        ));
                    }
                }
	        });
		})->download('xls');
    }
}