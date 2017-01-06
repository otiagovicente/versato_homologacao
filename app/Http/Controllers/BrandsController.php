<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Requests\BrandRequest;
use Illuminate\Support\Facades\Storage;

//load model
use App\Brand;

class BrandsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $brands = Brand::all();
        return view('brands.index', ['brands' => $brands]);
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

    public function addPhoto(Request $request){

        //Valida Mimes para garantir que é uma imagem
        $this->validate($request,[
            'photo' => 'required|mimes:jpg,png,jpeg'
        ]);

        //Faz upload da imagem para o Driver AWS S3
        $image = $request->file('photo')->store('brands','s3');
        //Torna acessível publicamente a imagem
        Storage::disk('s3')->setVisibility($image, 'public');
//        Espera 5 segundos para garantir que a visibilidade do
//        arquivo no driver S3 seja público para que a imagem
//        seja exibida
        sleep(5);

        //Retorna a url completa da imagem que será salva no campo photo do produto
        return Storage::disk('s3')->url($image);

    }

    public function addLogo(Request $request){

        //Valida Mimes para garantir que é uma imagem
        $this->validate($request,[
            'logo' => 'required|mimes:jpg,png,jpeg'
        ]);

        //Faz upload da imagem para o Driver AWS S3
        $image = $request->file('logo')->store('brands','s3');
        //Torna acessível publicamente a imagem
        Storage::disk('s3')->setVisibility($image, 'public');
//        Espera 5 segundos para garantir que a visibilidade do
//        arquivo no driver S3 seja público para que a imagem
//        seja exibida
        sleep(5);

        //Retorna a url completa da imagem que será salva no campo photo do produto
        return Storage::disk('s3')->url($image);

    }



    public function select(){
        $brands = Brand::all();
        return view('brands.select', compact('brands'));
    }

    public function setSelected(Request $request, Brand $brand){
        $request->session()->put('brand', $brand);
        return redirect('/');

    }




    public function api_index(){
        $brands = Brand::all();
        return response()->json($brands);
    }

    public function api_list(){
        return $this->api_index();
    }

    public function api_show(Brand $brand){
        return response()->json($brand);
    }

    public function api_selectList(){
        $brands = Brand::all();
        foreach($brands as $brand){
            $selectItem['value'] = $brand->id;
            $selectItem['label'] = $brand->name;
            $selectList[] = $selectItem;
        }
        return response()->json($selectList);
    }
    public function api_selectListByRepresentativeId($id){
        $brands = Brand::all();
        
        foreach($brands as $brand){
            $selectItem['value'] = $brand->id;
            $selectItem['label'] = $brand->name;
            $selectList[] = $selectItem;
        }
        return response()->json($selectList);
    }

    public function api_products(Brand $brand){
	    $products = $brand->products()->with('brand')
		    ->with('line')
		    ->with('material')
		    ->with('color')
		    ->with('grids')
		    ->with('tags')
		    ->paginate(50);

	    return response()->json($products);
    }

}
