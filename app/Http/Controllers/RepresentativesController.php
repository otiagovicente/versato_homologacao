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
    public function update(Request $request, Representative $representative)
    {
        $representative->fill($request->all());
        $representative->save();
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

        $representatives = Representative::with('user', 'region')->get();
        return $representatives;
    }

    public function api_show($id){

        $representative = Representative::
        where('id', $id)
            ->with('user', 'region', 'brands')
            ->first();

        //carrega os atributos extras
        $representative->user_id = $representative->user->id;
        $representative->region_id = $representative->region->id;
        $representative->brands_list = $representative->brands->pluck('id');
        return $representative;
    }

    public function api_selectList(){
        $lstAll = Representative::all();
        
        foreach($lstAll as $item){
            $selectItem['value'] = $item->id;
            $selectItem['label'] = $item->code;
            $selectList[] = $selectItem;
        }
        return response()->json($selectList);
    }
}
