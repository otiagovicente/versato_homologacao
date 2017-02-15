<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Grid;
use Excel;
use Input;
use App\ImportCustomer;
use Illuminate\Support\Facades\DB;

class ImportsController extends Controller
{
    public function customer()
    {
        return view('imports.customers.index');
    }
    
    public function importExcel(Request $request)
	{
		if($request->hasFile('import_file')){
			$path = $request->file('import_file')->getRealPath();
			$data = Excel::load($path, function($reader) {
                foreach ($reader->toArray() as $rows) {
                    foreach ($rows as $row) {
                        $insert[] = [
                                        'code' => $row['codigo']
                                        , 'name' => $row['nombre']
                                        , 'fantasyName' => $row['n_fantasia']
                                        , 'document' => $row['cuit']
                                        , 'phone' => $row['telefono']
                                        , 'email' => $row['e_mail'] 
                                    ];    
                    }    
                }
                if(!empty($insert)){
					DB::table('importcustomers')->insert($insert);
				}
            })->get();
            
		}
		return back();
	}
}
