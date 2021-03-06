<?php

namespace App\Http\Controllers;

use App\Mail\VersatoAppAccessMail;
use Illuminate\Http\Request;

use App\Http\Requests\RepresentativeRequest;
use App\Http\Requests;
use App\Representative;
use App\User;
use Endroid\QrCode\QrCode;
use Mail;

class RepresentativesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('representatives.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('representatives.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RepresentativeRequest $request)
    {
        $representative = new Representative($request->all());
        $representative->save();
        $representative->regions()->sync($request->regions);
        //$representative->brands()->sync($request->brands);

        return response($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Representative $representative)
    {
        return view('representatives.edit', compact('representative'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RepresentativeRequest $request, Representative $representative)
    {
        $representative->fill($request->all());
        $representative->save();
        $representative->regions()->sync($request->regions);
        $representative->brands()->sync($request->brands);
        return $representative;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /*
     *
     * Métodos de Criação de Token
     *
     */

        public function showGrantAccess(Representative $representative){
            return view('representatives.versatoapp', compact('representative'));
        }

        public function grantAccess(Representative $representative){
            $token = $this->createToken($representative);
            $QRCode = $this->createTokenQRCode($token);
            $representative->token = $token;
            $representative->qrcode = $this->createTokenQRCodeBase64($QRCode);
            $this->sendVersatoAppAccessMail($QRCode, $representative);
            return response($representative->qrcode);
        }

        public function createToken($representative){
            $user = User::find($representative->user->id);
            $token = $user->createToken('VersatoApp')->accessToken;
            $representative->save();
            return $token;
        }

        public function createTokenQRCode($token){
            $qrCode = new QrCode();
            $qrCode
                ->setText($token)
                ->setSize(500)
                ->setPadding(10)
                ->setErrorCorrection('high')
                ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
                ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
                ->setLabel('Accesso a Versato App')
                ->setLabelFontSize(16)
                ->setImageType(QrCode::IMAGE_TYPE_PNG)
            ;

            return $qrCode;
        }

        public function createTokenQRCodeBase64($qrCode){

            $image = "<img src='".$qrCode->getDataUri()."' />";
            return $image;

        }

        public function sendVersatoAppAccessMail($QRCode, $representative){

            Mail::to($representative->user->email)->send(new VersatoAppAccessMail($QRCode, $representative));
        }



    /*
     *
     *  Métodos API
     *
     */


    public function api_index(){

        $representatives = Representative::with('user', 'regions')->get();
        return $representatives;
    }

    public function api_show(Representative $representative){

        return response()->json($representative);

    }

    public function api_brands(Representative $representative){
        $brands = [];
        foreach ($representative->brands()->get() as $brand) {
            $brand['comission'] = $brand->pivot->comission;
            $brands[] = $brand;
        }

        return response()->json($brands);

    }

    public function api_regions(Representative $representative){
        return response()->json($representative->regions()->get());
    }


    public function api_user(Representative $representative){
        return response()->json($representative->user()->first());
    }

    public function api_representative($idUser){
        $rep = Representative::where('user_id', '$idUser')->get();
        return response()->json($rep);
    }



    public function api_selectList(){

        $representatives = Representative::with('user', 'regions')->paginate(20);

        return response()->json($representatives);
    }
    
    public function api_selectListSimple(){
        $representatives = Representative::with('user')->get();
        $selectList = [];
        
        foreach($representatives as $representative){
            $selectItem['value'] = $representative->id;
            $selectItem['label'] = $representative->user->name;
            $selectList[] = $selectItem;
        }

        return response()->json($selectList);
    }

	public function api_search(Request $request){


		$representatives = Representative::search($request->search)->get();
		$representatives->load('user');
		return response()->json($representatives);


	}

}
