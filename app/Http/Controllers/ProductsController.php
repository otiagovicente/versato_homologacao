<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;

use App\Product;
use App\Brand;
use App\Grid;
use App\Tag;

class ProductsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::
            with('brand')
            ->with('line')
            ->with('material')
            ->with('color')
            ->with('grids')
            ->with('tags')
            ->where('brand_id', session()->get('brand')->id)
            ->paginate(50);

        return view('products.index', compact('products'));


    }


    public function search(Request $request){

        $products = Product::search($request->search)->where('brand_id',session()->get('brand')->id)->paginate();
        return view('products.index', compact($products));

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $grids  = Grid::where('brand_id', session()->get('brand')->id)->get();
        $tags = Tag::where('brand_id', session()->get('brand')->id)->get();
        return view('products.create',[
            'grids' =>$grids,
            'tags' => $tags
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {

        //instancia um novo Produto com os dados do request
        $product = new Product();
        $product->fill($request->all());
        $product->brand_id = (int) session()->get('brand')->id;
//        dump($product);
        $product->save();

        //algo muda o código do produto


        $tags = $request->tags;
        foreach ($tags as $tag){
            $product->tags()->attach($tag);
    }

        foreach ($request->grids as $grid) {
            $product->grids()->attach($grid);
        }

        return response()->json($product);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $grids  = Grid::where('brand_id', session()->get('brand')->id)->get();
        $tags = Tag::where('brand_id', session()->get('brand')->id)->get();

        return view('products.edit',[
            'grids' =>$grids,
            'tags' => $tags,
            'product'=> $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {

        //instancia um novo Produto com os dados do request
        $product->fill($request->all());
        $product->brand_id = (int) session()->get('brand')->id;
        $product->save();

        $product->tags()->sync($request->tags);
        $product->grids()->sync($request->grids);

        return response()->json($product);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    public function addPhoto(Request $request){


        //Valida Mimes para garantir que é uma imagem
        $this->validate($request,[
            'photo' => 'required|mimes:jpg,png,jpeg'
        ]);

        //Faz upload da imagem para o Driver AWS S3
        $image = $request->file('photo')->store('products','gcs');
        //Torna acessível publicamente a imagem
        Storage::disk('gcs')->setVisibility($image, 'public');


//        Espera 5 segundos para garantir que a visibilidade do
//        arquivo no driver S3 seja público para que a imagem
//        seja exibida
//        sleep(5);

        //Retorna a url completa da imagem que será salva no campo photo do produto
        return Storage::disk('gcs')->url($image);

    }


    public function api_index(){

	    $products = Product::
	          with('brand')
		    ->with('line')
		    ->with('material')
		    ->with('color')
		    ->with('grids')
		    ->with('tags')
//		    ->orderBy('line.description')
		    ->paginate(50);

	    return response()->json($products);
    }

    public function api_listPaginate(Brand $brand){
        $products = Product::
            with('brand')
            ->with('line')
            ->with('material')
            ->with('color')
            ->with('grids')
            ->with('tags')
            ->where('brand_id', $brand->id)
            ->paginate(10);
        return response()->json($products);
    }

    public function api_show(Product $product){

        $product = Product::with('brand','line', 'material', 'color', 'grids', 'tags')
                    ->find($product->id);

        return response()->json($product);

    }

    public function api_edit($id){

        $product = Product::
            where('id', $id)
            ->with('brand', 'line','material','color', 'grids', 'tags')
            ->first();

        //carrega os atributos extras
        $product->line_code = $product->line->code;

        $product->material_code = $product->material->code;
        $product->color_code = $product->color->code;
        $product->grids_list = $product->grids->pluck('id');
        $product->tags_list = $product->tags->pluck('id');
        return response()->json($product);
    }

    public function api_sync($dtSincronizacao){
        $date = date_create($dtSincronizacao);
        $products = Product::
                    with('brand')
                    ->with('line')
                    ->with('material')
                    ->with('color')
                    ->with('gridsAndSizes')
                    ->with('tags')
                    ->where('updated_at', '>=',date_format($date, 'Y-m-d H:i:s'))
                    ->where('published', '1')
                    ->get();



        return response()->json($products);
    }

    public function api_search(Brand $brand, Request $request){

	    $products = Product::search($request->search)->where('brand_id', $brand->id)->paginate();
	    $products->load('line', 'material','color');

         return response()->json($products);
    }


}
