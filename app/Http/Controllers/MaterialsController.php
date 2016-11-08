<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\MaterialRequest;
use App\Material;
class MaterialsController extends Controller
{

    private $materials;
    private $imagesPath;

    public function __construct(){
        $this->imagesPath = "images/materials";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->materials = Material::where('brand_id', session()->get('brand')->id)->get();
        return view('materials.index', ['materials' => $this->materials]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('materials.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MaterialRequest $request)
    {
        $material = new Material($request->all());
        $material->brand_id = (int) $request->session()->get('brand')->id;
        $material->save();
        return response()->json($material);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Material $material)
    {
        return view('materials.show', compact('material'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Material $material)
    {
        return view('materials.edit', compact('material'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MaterialRequest $request, Material $material)
    {
        $material->fill($request->all());
        $material->brand_id = (int) session()->get('brand')->id;
        $material->save();
        return response()->json($material);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Material $material)
    {
        //
    }
    public function addPhoto(Request $request){
        $this->validate($request,[
            'photo' => 'required|mimes:jpg,png,jpeg'
        ]);

        $file = $request->file('photo');

        $name= time().'.jpg';

        $file->move($this->imagesPath, $name);

        //atualiza o path da imagem
        $image = "/".$this->imagesPath."/".$name;

        return $image;
    }

    public function search(Request $request){
        $query = $request->get('search');
        $results = Material::where('code', 'like', "%$query%")->orWhere('description', 'like', "%$query%")->get();

        return response()->json($results);
    }

   public function api_list(){

        $products = Material::
                    groupBy('brand_id')
                    ->get();

        return $products;


    }
    public function api_products(Material $material){
        return $material->products()->get();
    }

}
