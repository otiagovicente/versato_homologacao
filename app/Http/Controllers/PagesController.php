<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Brand;
use App\Line;
use App\Reference;
use App\Material;
use App\Color;
use App\Product;
use App\Grid;
use App\Size;

class PagesController extends Controller
{
    public function help(){


        return view('pages.help');


    }

    public function productsDashboard(){

        $linesCount = Line::where('brand_id', session()->get('brand')->id)->count();
        $referencesCount = Reference::where('brand_id', session()->get('brand')->id)->count();
        $materialsCount = Material::where('brand_id', session()->get('brand')->id)->count();
        $colorsCount = Color::where('brand_id', session()->get('brand')->id)->count();

        $productsCount = Product::where('brand_id', session()->get('brand')->id)->count();


        return view('pages.products',
        ['linesCount'=>$linesCount,
        'referencesCount' => $referencesCount,
        'materialsCount' => $materialsCount,
        'colorsCount' => $colorsCount,
        'productsCount' => $productsCount

        ]);


    }
}
