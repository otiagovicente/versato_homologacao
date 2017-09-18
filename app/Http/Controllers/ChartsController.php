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

class ChartsController extends Controller
{
    public function index()
    {
        //$brands = Brand::all();
        return view('charts.index');
    }
}
