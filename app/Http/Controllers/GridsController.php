<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Grid;

class GridsController extends Controller
{

    /*
     * Executa toda vez que a classe é instanciada/chamada
     */
     public function __construct(){

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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Grid $grid)
    {
        return view('grids.show', compact('grid'));
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
    public function update(Request $request, $id)
    {
        //
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


    public function api_list(){

        $products = Grid::get();

        return $products;


    }

    public function api_show(Grid $grid){

        return $grid->load('sizes');


    }

    public function api_selectList($brand_id){

        $grids = Grid::where('brand_id', $brand_id)->get();

        foreach($grids as $grid){

            $selectItem['value'] = $grid->id;
            $selectItem['label'] = $grid->description;
            $selectList[] = $selectItem;
        }

        return response()->json($selectList);

    }

}
