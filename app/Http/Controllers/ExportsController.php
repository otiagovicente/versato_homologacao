<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Grid;
use Illuminate\Support\Facades\DB;

class ExportsController extends Controller
{
    public function order()
    {
        return view('exports.orders.index');
    }
}
