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

    private $imagesPath;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
        $this->imagesPath = 'images/users';
            return $next($request);
        });
    }

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

        $file = $request->file('photo');

        $name= time().'.jpg';

        $file->move($this->imagesPath, $name);

        //atualiza o path da imagem
        $image = "/".$this->imagesPath."/".$name;

        return $image;
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


    public function api_show(User $user){
        return $user;
    }
}
