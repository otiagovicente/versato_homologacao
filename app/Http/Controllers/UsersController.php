<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests;
use App\User;
use App\Http\Requests\UserRequest;
use App\Http\Requests\PasswordRequest;
use Auth;
use Hash;
use Image;
use File;
use Illuminate\Http\UploadedFile;

class UsersController extends Controller
{


    public function index(){
        $roles = [
            1 => 'SuperAdmin',
            2 => 'Admin',
            3 => 'Gestor',
            4 => 'Editor',
            5 => 'Representante'
        ];

        $usersgroup = User::all()->groupBy('role_id');
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
        $this->validate($request, [
            'photo' => 'required|mimes:jpg,png,jpeg'
        ]);

        /* we are generating a SQUARE thumbnail */
        $image = $request->file('photo');
        $input['photo'] = time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('thumbnail');
        $img = Image::make($image);
        $thumbnail = $destinationPath.'/'.$input['photo'];
        $finalImage = $img->fit(500, 500)->save($thumbnail);

        //Faz upload da imagem para o Driver GCS (no longer AWS S3)
        $image = (new UploadedFile($thumbnail, $input['photo']))->store('users', 'gcs');

        //Torna acessível publicamente a imagem
        Storage::disk('gcs')->setVisibility($image, 'public');

        File::delete($thumbnail);

        /*
         * Espera 5 segundos para garantir que a visibilidade do
         * arquivo no driver S3 seja público para que a imagem
         * seja exibida
         */
        sleep(5);

        //Retorna a url completa da imagem que será salva no campo photo do produto
        return Storage::disk('gcs')->url($image);

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
        $users = User::with('representative')->get();
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
