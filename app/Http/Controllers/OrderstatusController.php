<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Orderstatus;

class OrderstatusController extends Controller
{
    public function index(Request $request){
    	     if($request->ajax()){
    	     	return response()->json(Orderstatus::all());
          }else{
    	     	return view('orderstatus.index');
          }
    }
}
