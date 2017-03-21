<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Requests\CustomerRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests;

use App\Customer;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::paginate(10);

        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        $customer = new Customer();
        $customer->fill($request->all());
        $customer->save();
        return response($customer);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, Customer $customer)
    {
        $customer->fill($request->all());
        $customer->save();
        return response($customer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function addPhoto(Request $request){
        //Valida Mimes para garantir que é uma imagem
        $this->validate($request,[
            'photo' => 'required|mimes:jpg,png,jpeg'
        ]);

        //Faz upload da imagem para o Driver AWS S3
        $image = $request->file('photo')->store('customers','s3');
        //Torna acessível publicamente a imagem
        Storage::disk('s3')->setVisibility($image, 'public');
//        Espera 5 segundos para garantir que a visibilidade do
//        arquivo no driver S3 seja público para que a imagem
//        seja exibida
        sleep(5);

        //Retorna a url completa da imagem que será salva no campo photo do produto
        return Storage::disk('s3')->url($image);
    }






    public function api_index(Request $request){
        $customers = Customer::where('name', 'like', '%'. $request->input('search') .'%')
        ->orWhere('company', 'like', '%'. $request->input('search') .'%' )
        ->orderBy($request->input('campo'), $request->input('sequence'))
        ->paginate($request->input('entries'));
        return response()->json($customers);
    }

    public function api_show(Customer $customer){
        return response()->json($customer);
    }

    public function api_selectList(){
        $listAll = Customer::all();

        foreach($listAll as $item){
            $selectItem['value'] = $item->id;
            $selectItem['label'] = $item->name;
            $selectList[] = $selectItem;
        }
        return response()->json($selectList);
    }




    public function api_getShops(Customer $customer){
        return $customer->shops()->get();
    }

    public function api_getDeliveryCenters(Customer $customer){
        return $customer->deliverycenters()->get();
    }
    public function api_aggregates(Customer $customer){
        $aggregates = Customer::where('id', $customer->id)->with('deliverycenters')->with('shops')->get();
        return response()->json($aggregates);
    }
    public function api_sync($dtSincronizacao){
        $date = date_create($dtSincronizacao);
        $customers = Customer::where('updated_at', '>=',date_format($date, 'Y-m-d H:i:s'))
            ->get();

        return response()->json($customers);
    }

    public function api_search(Request $request){


	    $customers = Customer::search($request->search)->get();

	    return response()->json($customers);


    }
}
