<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\LineRequest;

//load model
use App\Line;
use App\Product;

class LinesController extends Controller
{

    private $lines;

    public function __construct(){

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->lines = Line::where('brand_id', session()->get('brand')->id)->get();
        return view('lines.index', ['lines' => $this->lines]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('lines.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LineRequest $request)
    {
        $line = new Line($request->all());
        $line->brand_id = (int) $request->session()->get('brand')->id;
        $line->save();
        return response()->json($line);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Line $line)
    {
        $products = Product::all();
        return view('lines.show', ['line' => $line, 'products' => $products]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Line $line)
    {
        return view('lines.edit', compact('line'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LineRequest $request, Line $line)
    {
        $line->fill($request->all());
        $line->brand_id = (int) session()->get('brand')->id;
        $line->save();
        return response($line);
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

    public function getLineByCode($code){
        $Line = Line::find($code);
        return response()->json($Line);
    }

    public function search(Request $request){
        $query = $request->get('search');
        $results = Line::where('code', 'like', "%$query%")->orWhere('description', 'like', "%$query%")->get();

        return response()->json($results);
    }
   public function api_list(){
        $products = Line::
                    groupBy('brand_id')
                    ->get();
        return $products;
    }

    public function api_products(Line $line){
        return $line->products()->get();
    }


}
