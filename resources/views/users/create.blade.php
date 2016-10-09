
@extends('layouts.dashboard')

@section('styles')
    <link href="/dashboard/pages/css/profile.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    @include('users.partials.header',[
        'pageTitle' => 'Criar Usuário',
        'url' => '/users/create',
        'actions' => []
    ])

    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <user-form/>
            </div>
        </div>
    </div>
@endsection
