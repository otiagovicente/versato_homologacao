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
    
    public function downloadExcel($type)
	{
		$data = Item::get()->toArray();
		return Excel::create('itsolutionstuff_example', function($excel) use ($data) {
			$excel->sheet('mySheet', function($sheet) use ($data)
	        {
				$sheet->fromArray($data);
	        });
		})->download($type);
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
					DB::table('import_customer')->insert($insert);
					dd('Insert Record successfully.');
				}
            })->get();
            
		}
		return back();
	}
}
