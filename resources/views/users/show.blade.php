@extends('layouts.dashboard')
@section('content')

    <!-- BEGIN PAGE HEADER-->

    @include('users.partials.header',[
        'pageTitle' => ''.$user->name.' '.$user->lastname,
        'url' => '/profile',
        'actions' => ['Editar Usuário' => '/users/'.$user->id.'/edit']
    ])

    <!-- END PAGE HEADER -->

    <user-profile :user_id="{{$user->id}}"></user-profile>

<!-- END PROFILE CONTENT -->

@endsection

