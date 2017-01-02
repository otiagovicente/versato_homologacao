<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\RequestsOrder;
use App\Order;
use App\Product;
use App\Customer;
use App\Representative;
use App\Mail\NewOrderMail;
use App\Mail\FavoritesMail;
use League\Flysystem\Exception;
use Mail;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = Order::with('products')
            ->with('representative')
            ->with('customer')
            ->paginate(20);
        return view('orders.index', compact('orders'));
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
    public function store(Request $request)
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
    public function update(Request $request, Order $order)
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
        with('products', 'representative', 'customer')->find($id);
        
        /*if($order->customer && $order->customer->email){
            Mail::to($order->customer->email)->send(new NewOrderMail($order));    
        }
        if($order->representative && $order->representative->user && $order->representative->user->email){
            Mail::to($order->representative->user->email)->send(new NewOrderMail($order));
        }*/
        
        //Mail::to('jorge@magnaestrategia.com')->send(new NewOrderMail($order));
        Mail::to('bruno@magnaestrategia.com')->send(new NewOrderMail($order));
        //Mail::to('roger@magnaestrategia.com')->send(new NewOrderMail($order));
        //Mail::to('tiago@magnaestrategia.com')->send(new NewOrderMail($order));
    }
    public function api_sendFavoritesMail($idRep, $idCustomer, $lstProducts){
        $products = Product::
                with('line')
                ->with('material')
                ->with('color')
                ->whereIn('id', explode(',', $lstProducts))->get();
        
        $representative = Representative::with('user')->find($idRep);
        $customer       = Customer::find($idCustomer);
 
        if($representative && $customer && $products)
            Mail::to('bruno@magnaestrategia.com')->send(new FavoritesMail($products, $representative, $customer));
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
    public function api_getSalesByBrand(){
        $totalSalesByBrand = Order::
                                select('brands.name', DB::raw('SUM(order_product.total) as Total, COUNT(order_product.code) as qtd_pedidos'))
                                ->join('order_product', 'orders.id', '=', 'order_product.order_id')                       
                                ->join('products', 'products.id', '=', 'order_product.product_id')
                                ->join('brands', 'brands.id', '=', 'products.brand_id')
                                ->whereBetween('order_product.created_at', ['2016-12-01 00:00:00', '2016-12-31 23:59:59'])
                                ->groupBy('brands.id')
                                ->get();
        
        return response()->json($totalSalesByBrand);
    }
}