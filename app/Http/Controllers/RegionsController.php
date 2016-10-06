<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Http\Requests\RegionRequest;

use App\Http\Requests;
use App\Macroregion;
use App\Region;

class RegionsController extends Controller
{
    private $brand_id;

    public function __construct(){
        $this->middleware(function ($request, $next) {
             $this->brand_id = session()->get('brand')->id;
            return $next($request);
        });
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $macroregions = Macroregion::where('brand_id', $this->brand_id)->get();
        return view('regions.create', compact('macroregions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $region = new Region();
        $region->fill($request->all());
        $region->save();
        return response($region);
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Region $region)
    {
        $region->fill($request->all());
        $region->save();
        return response($region);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $region = Region::find($id);
        $region->delete();
    }

    public function api_selectList(){
        $regions = Region::all();
        foreach($regions as $region){
            $selectItem['value'] = $region->id;
            $selectItem['label'] = $region->description;
            $selectList[] = $selectItem;
        }
        return response()->json($selectList);
    }
}
