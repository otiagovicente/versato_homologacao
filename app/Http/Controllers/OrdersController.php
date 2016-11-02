<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\RequestsOrder;
use App\OrderProduct;
use App\Order;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = Order::all();
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @ret/urn \Illuminate\Http\Response
     */
    public function update(OrderRequest $request, Order $order)
    {
        $order->update($request->all());
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
        //
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
}