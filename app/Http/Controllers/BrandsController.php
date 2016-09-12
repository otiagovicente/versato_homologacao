<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Requests\BrandRequest;

//load model
use App\Brand;

class BrandsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $brands;
    private $imagesPath;

    public function __construct(){
        $this->brands = Brand::all();
        $this->imagesPath = "images/brands";
    }

    public function index()
    {
        return view('brands.index', ['brands' => $this->brands]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('brands.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandRequest $request)
    {
        $brand = new Brand;
        $brand->create($request->all());
        return response()->json($brand);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        return view('brands.show', compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        return view('brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BrandRequest $request, Brand $brand)
    {
        $brand->update($request->all());
        return response()->json($brand);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        //
    }

    public function addPhoto(Request $request, Brand $brand){
        $this->validate($request,[
            'photo' => 'required|mimes:jpg,png,jpeg'
        ]);

        $file = $request->file('photo');

        $name= $brand->name.time().'.jpg';

        $file->move($this->imagesPath, $name);

        //atualiza o path da imagem
        $brand->image = "/".$this->imagesPath."/".$name;
        $brand->save();

        return $brand->image;
    }

    public function select(){
        $brands = Brand::all();
        return view('brands.select', compact('brands'));
    }

    public function setSelected(Request $request, Brand $brand){

        $request->session()->put('brand', $brand);

        return redirect('/');

    }
   public function api_list(){

        $products = Brand::all();

        return $products;


    }

}
