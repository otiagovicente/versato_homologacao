<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Http\Requests\UserRequest;
use App\Http\Requests\PasswordRequest;
use Auth;
use Hash;


class UsersController extends Controller
{


    public function index(){
        $roles = [
            1 => 'SuperAdmin',
            2 => 'Admin',
            3 => 'Editor',
            4 => 'Representante'
        ];

        $usersgroup = User::all()->groupBy('role');
        return view('users.index', ['usersgroup' => $usersgroup, 'roles' => $roles]);
    }

    public function profile(){
        $user = User::find(Auth::user()['id']);
        return view('users.show',compact('user'));
    }

    public function show(User $user){
        return view('users.show', compact('user'));
    }
    public function create(){
        return view('users.create');
    }

    public function store(UserRequest $request){
        $user = new User($request->all());
        $user->password = \Hash::make($user->password);
        $user->photo = '/dashboard/pages/img/avatars/default.png';
        $user->save();
        return redirect('/');
    }

    public function edit(User $user){

        return view('users.edit', compact('user'));

    }

    public function update(UserRequest $request, User $user){

        $user->update($request->all());

    }

    public function destroy(User $user){

    }

    public function addPhoto(Request $request){


        $this->validate($request,[
            'photo' => 'required|mimes:jpg,png,jpeg'
        ]);

        //Faz upload da imagem para o Driver AWS S3
        $image = $request->file('photo')->store('users','s3');

        //Torna acessível publicamente a imagem
        Storage::disk('s3')->setVisibility($image, 'public');

        /*
         * Espera 5 segundos para garantir que a visibilidade do
         * arquivo no driver S3 seja público para que a imagem
         * seja exibida
         */
        sleep(5);

        //Retorna a url completa da imagem que será salva no campo photo do produto
        return Storage::disk('s3')->url($image);

    }

    public function changePassword(PasswordRequest $request){

        $email = $request->email;
        $user = User::where('email', $email)->first();

        if(Hash::check($request->current, $user->password)){

            $user->password = Hash::make($request->password);
            $user->save();
            return response('Senha Alterada!');

        }else{

            return response( ['password' => ['Senha incorreta!']],422);

        }

    }

    public function passport(){

        return view('users.passport');
    }



    public function api_index(){
        $users = User::all();
        return $users;
    }

    public function api_show(User $user){
        $user = User::where('id', $user->id)->with('representative')->first();
        return $user;
    }

    public function api_selectList(){

        $users = User::all();
        foreach($users as $user){

            $selectItem['value'] = $user->id;
            $selectItem['label'] = $user->name.' '.$user->lastname ;
            $selectList[] = $selectItem;
        }

        return response()->json($selectList);

    }

}
