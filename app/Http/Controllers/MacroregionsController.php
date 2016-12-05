<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MacroregionRequest;

use App\Http\Requests;
use App\Macroregion;

class MacroregionsController extends Controller
{
    public function __construct(){
       
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $macroregions = Macroregion::all();
        return view('macroregions.index', compact('macroregions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('macroregions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MacroregionRequest $request)
    {
        $macroregion = new Macroregion();
        $macroregion->fill($request->all());
        $macroregion->save();
        return response($macroregion);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Macroregion $macroregion)
    {
        return view('macroregions.show', compact('macroregion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Macroregion $macroregion)
    {
        return view('macroregions.edit', compact('macroregion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MacroregionRequest $request, Macroregion $macroregion)
    {
        $macroregion->fill($request->all());
        $macroregion->save();
        return response($macroregion);
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
    
    public function selectList(){
        $macroregions = Macroregion::all();
        
        foreach($macroregions as $macroregion){
            $selectItem['value'] = $macroregion->id;
            $selectItem['label'] = $macroregion->description;
            $selectList[] = $selectItem;
        }
        return response()->json($selectList);
    }
    
    public function getMacroregionGeo($id){
        $macroregion = Macroregion::with('regions')->find($id);
        return response()->json($macroregion);
    }

    public function api_regions(Macroregion $macroregion){
        return response()->json($macroregion->regions()->get());
    }
}
