<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\RepresentativeRequest;
use App\Http\Requests;
use App\Representative;
use App\User;

class RepresentativesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('representatives.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('representatives.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RepresentativeRequest $request)
    {

        $representative = new Representative($request->all());
        $representative->save();
        $representative->regions()->sync($request->regions);
        $representative->brands()->sync($request->brands);
        return $representative;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Representative $representative)
    {
        return view('representatives.edit', compact('representative'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RepresentativeRequest $request, Representative $representative)
    {


        $representative->fill($request->all());
        $representative->save();
        $representative->regions()->sync($request->regions);

        $representative->brands()->sync($request->brands);
        return $representative;
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


    public function api_index(){

        $representatives = Representative::with('user', 'regions')->get();
        return $representatives;
    }

    public function api_show(Representative $representative){

        return response()->json($representative);

    }

    public function api_brands(Representative $representative){

        foreach ($representative->brands()->get() as $brand) {
            $brand['comission'] = $brand->pivot->comission;
            $brands[] = $brand;
        }

        return response()->json($brands);

    }

    public function api_regions(Representative $representative){
        return response()->json($representative->regions()->get());
    }

    public function api_user(Representative $representative){
        return response()->json($representative->user()->first());
    }



    public function api_selectList(){
        $listAll = Representative::all();
        $selectList = [];

        foreach($listAll as $item){
            $selectItem['value'] = $item->id;
            $selectItem['label'] = $item->code;
            $selectList[] = $selectItem;
        }
        return response()->json($selectList);
    }
}
