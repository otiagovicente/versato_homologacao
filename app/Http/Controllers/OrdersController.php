<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use App\Http\RequestsOrder;
use App\Order;
use App\Mail\NewOrderMail;
use League\Flysystem\Exception;
use Mail;
use \Excel;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = Order::with('products')
            ->with('representative')
            ->with('customer')
            ->paginate(20);
        $statuses = [['id' => 1, 'label' => 'Activos'], ['id' => 0, 'label' => 'Inactivos']];
        $exportToExcel = true;
        //$token = Form::token();
        return view('orders.index', compact('orders', 'exportToExcel'));
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
        //return $order;
        Mail::to('jorge@magnaestrategia.com')->send(new NewOrderMail($order));
        Mail::to('bruno@magnaestrategia.com')->send(new NewOrderMail($order));
        Mail::to('roger@magnaestrategia.com')->send(new NewOrderMail($order));
        Mail::to('tiago@magnaestrategia.com')->send(new NewOrderMail($order));
    }

   public function api_list(){
        $orders = Order::with('products')
            ->with('representative')
            ->with('customer')
            ->paginate(20);
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

    public function api_generateSheet(Request $request){
        //\DB::enableQueryLog();

        $search = $request->input('search');
        $requestBrand = $request->input('brand');
        $requestMacroregion = $request->input('macroregion');
        $requestRegion = $request->input('region');
        $requestRepresentative = $request->input('representative');
        $requestStatus = $request->input('status_id');

        $orders = Order::with('representative')
            ->with('representative.regions')
            ->with('representative.regions.macroregion')
            ->with('customer')
            ->with('products')
            ->where(function($q) use($request, $search) {
                return $q->where('id', 'like', '%'. $search .'%')
                    //->orWhere('representative.user.name', 'like', '%'. $request->input('search') .'%')
                    //->orWhere('customer.name', 'like', '%'. $request->input('search') .'%')
                    ->orWhere('cost', 'like', '%'. $search .'%')
                    ->orWhere('price', 'like', '%'. $search .'%')
                    ->orWhere('cost', 'like', '%'. $search .'%')
                    ->orWhere('company_discount', 'like', '%'. $search .'%')
                    ->orWhere('representative_discount', 'like', '%'. $search .'%')
                    ->orWhere('products_amount', 'like', '%'. $search .'%')
                    ->orWhere('total', 'like', '%'. $search .'%');
            });

        if (!empty($requestRepresentative) && is_numeric($requestRepresentative) && (int)$requestRepresentative > 0) {
            $orders->where('representative_id', '=', $requestRepresentative);
        }

        if (!empty($requestStatus) && is_numeric($requestStatus) && (int)$requestStatus > 0) {
            $orders->where('status_id', '=', $requestStatus);
        }

        if (!empty($requestBrand) && is_numeric($requestBrand) && (int)$requestBrand > 0) {
            $orders->whereHas('products', function($q) use($requestBrand) {
                $q->where('brand_id', '=', $requestBrand);
            });
        }

        if (!empty($requestMacroregion) && is_numeric($requestMacroregion) && (int)$requestMacroregion > 0) {
            if (!empty($requestRegion) && is_numeric($requestRegion) && (int)$requestRegion > 0) {
                $orders->whereHas('representative.regions', function($q) use($requestRegion) {
                    $q->where('regions.id', '=', $requestRegion);
                });
            }

            $orders->whereHas('representative.regions.macroregion', function($q) use($requestMacroregion) {
                $q->where('id', '=', $requestMacroregion);
            });
        }

        $orders = $orders
            ->orderBy($request->input('campo'), $request->input('sequence'))
            ->get()
            /*->paginate($request->input('entries'))*/;

        //$d = \DB::getQueryLog();

        Excel::create('Pedidos', function($excel) use ($orders) {
            $excel->sheet('Planilha de Pedidos', function($sheet) use ($orders) {
                $ordersArray = $orders->toArray();

                foreach ($ordersArray as &$order) {
                    $order = [
                        'Pedido' => $order['id'],
                        'Representante' => !empty($order['representative']) && !empty($order['representative']['user']) ? $order['representative']['user']['name'] : '',
                        'Cliente' => !empty($order['customer']) ? $order['customer']['name'] : '',
                        'Costo' => $order['cost'],
                        'Precio' => $order['price'],
                        'Desc.' => $order['company_discount'],
                        'Desc. Representante' => $order['representative_discount'],
                        'Qtd. Productos' => $order['products_amount'],
                        'Total' => $order['total'],
                    ];
                }

                if (count($ordersArray) == 0) {
                    $ordersArray = [
                        [
                            'Pedido' => '',
                            'Representante' => '',
                            'Cliente' => '',
                            'Costo' => '',
                            'Precio' => '',
                            'Desc.' => '',
                            'Desc. Representante' => '',
                            'Qtd. Productos' => '',
                            'Total' => '',
                        ]
                    ];
                }

                $sheet->fromArray($ordersArray, null,  'A1', true, true);
            });
        })->export('xlsx');
    }

    public function api_index(Request $request){
        \DB::enableQueryLog();

        $search = $request->input('search');
        $requestBrand = $request->input('brand');
        $requestMacroregion = $request->input('macroregion');
        $requestRegion = $request->input('region');
        $requestRepresentative = $request->input('representative');
        $requestStatus = $request->input('status_id');

        $orders = Order::with('representative')
            ->with('representative.regions')
            ->with('representative.regions.macroregion')
            ->with('customer')
            ->with('products')
            ->where(function($q) use($request, $search) {
                return $q->where('id', 'like', '%'. $search .'%')
                    //->orWhere('representative.user.name', 'like', '%'. $request->input('search') .'%')
                    //->orWhere('customer.name', 'like', '%'. $request->input('search') .'%')
                    ->orWhere('cost', 'like', '%'. $search .'%')
                    ->orWhere('price', 'like', '%'. $search .'%')
                    ->orWhere('cost', 'like', '%'. $search .'%')
                    ->orWhere('company_discount', 'like', '%'. $search .'%')
                    ->orWhere('representative_discount', 'like', '%'. $search .'%')
                    ->orWhere('products_amount', 'like', '%'. $search .'%')
                    ->orWhere('total', 'like', '%'. $search .'%');
            });

        if (!empty($requestRepresentative) && is_numeric($requestRepresentative) && (int)$requestRepresentative > 0) {
            $orders->where('representative_id', '=', $requestRepresentative);
        }

        if (!empty($requestStatus) && is_numeric($requestStatus) && (int)$requestStatus > 0) {
            $orders->where('status_id', '=', $requestStatus);
        }

        if (!empty($requestBrand) && is_numeric($requestBrand) && (int)$requestBrand > 0) {
            $orders->whereHas('products', function($q) use($requestBrand) {
                $q->where('brand_id', '=', $requestBrand);
            });
        }

        if (!empty($requestMacroregion) && is_numeric($requestMacroregion) && (int)$requestMacroregion > 0) {
            if (!empty($requestRegion) && is_numeric($requestRegion) && (int)$requestRegion > 0) {
                $orders->whereHas('representative.regions', function($q) use($requestRegion) {
                    $q->where('regions.id', '=', $requestRegion);
                });
            }

            $orders->whereHas('representative.regions.macroregion', function($q) use($requestMacroregion) {
                $q->where('id', '=', $requestMacroregion);
            });
        }

        $orders = $orders
            ->orderBy($request->input('campo'), $request->input('sequence'))
            ->paginate($request->input('entries'));

        $d = \DB::getQueryLog();

        $response = response()->json($orders);

        //print_r($d);

        return $response;
    }
}
