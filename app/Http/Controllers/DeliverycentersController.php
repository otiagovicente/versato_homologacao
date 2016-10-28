<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Deliverycenter;
use Illuminate\Http\Request;
use App\Http\Requests\DeliverycenterRequest;

use App\Http\Requests;

class DeliverycentersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('deliverycenters.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('deliverycenters.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeliverycenterRequest $request)
    {

        $deliveryCenter = new Deliverycenter($request->all());
        $deliveryCenter->save();

        return response()->json($deliveryCenter);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('deliverycenters.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('deliverycenters.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DeliverycenterRequest $request, Deliverycenter $deliverycenter)
    {
        $deliverycenter->fill($request->all());
        $deliverycenter->save();

        return response()->json($deliverycenter);
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

    public function api_index(Customer $customer){



    }

    public function api_show(Deliverycenter $deliverycenter){
        return response()->json($deliverycenter);
    }


}
