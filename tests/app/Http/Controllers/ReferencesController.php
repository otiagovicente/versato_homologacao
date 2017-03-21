<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\ReferenceRequest;

use App\Reference;

class ReferencesController extends Controller
{
    private $references;

    public function __construct(){

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->references = Reference::where('brand_id', session()->get('brand')->id)->get();
        return view('references.index', ['references' => $this->references]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('references.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReferenceRequest $request)
    {
        $reference = new Reference($request->all());
        $reference->brand_id = (int) $request->session()->get('brand')->id;
        $reference->save();
        return response()->json($reference);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Reference $reference)
    {
        return view('references.show', compact('reference'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Reference $reference)
    {
        return view('references.edit', compact('reference'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReferenceRequest $request, Reference $reference)
    {
        $reference->fill($request->all());
        $reference->brand_id = (int) session()->get('brand')->id;
        $reference->save();
        return response()->json($reference);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reference $reference)
    {
        //
    }

    public function search(Request $request){
        $query = $request->get('search');
        $results = Reference::where('code', 'like', "%$query%")->orWhere('description', 'like', "%$query%")->get();

        return response()->json($results);
    }

   public function api_list(){

        $products = Reference::
                    groupBy('brand_id')
                    ->get();

        return $products;


    }

}
