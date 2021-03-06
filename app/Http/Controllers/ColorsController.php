<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\ColorRequest;

//load model
use App\Color;
use App\Brand;

class ColorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colors = Color::where('brand_id', session()->get('brand')->id)->get();
        return view('colors.index', ['colors' => $colors]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('colors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ColorRequest $request)
    {

        $color = new Color($request->all());
        $color->brand_id = (int) $request->session()->get('brand')->id;
        $color->save();
        return response()->json($color);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Color $color)
    {
        return view('colors.show', compact('color'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Color $color)
    {
        return view('colors.edit', compact('color'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ColorRequest $request, Color $color)
    {
        $color->fill($request->all());
        $color->brand_id = (int) session()->get('brand')->id;
        $color->save();
        return response()->json($color);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Color $color)
    {
        //
    }

    public function search(Request $request){
        $query = $request->get('search');
        $results = Color::where('code', 'like', "%$query%")->orWhere('description', 'like', "%$query%")->get();
        
        return response()->json($results);
    //    return response()->json(Color::all());
    }

   public function api_index(Request $request, $brand_id){
       $colors = Color::where('brand_id', $brand_id)
       ->where('description', 'like', '%'. $request->input('search') .'%')
       ->orWhere('code', 'like', '%'. $request->input('search') .'%' )
       ->orderBy($request->input('campo'), $request->input('sequence'))
       ->paginate($request->input('entries'));
       return response()->json($colors);
   }
   public function api_list(Request $request){
        $colors = Color::select()
            ->where('description', 'like', '%'. $request->input('search') .'%')
            ->orWhere('code', 'like', '%'. $request->input('search') .'%' )
            ->orderBy('description')
            ->orderBy('code')
            ->paginate(20);
        return $colors;
    }

    public function api_products(Color $color){
        $products = $color->products()->with('brand')
				    ->with('line')
				    ->with('material')
				    ->with('color')
				    ->with('grids')
				    ->with('tags')
				    ->paginate(10);

        return response()->json($products);
    }

}
