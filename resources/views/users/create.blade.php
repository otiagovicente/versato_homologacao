
@extends('layouts.dashboard')

@section('styles')
    <link href="/dashboard/pages/css/profile.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <!-- BEGIN PAGE HEADER-->

    @include('users.partials.header',[
        'pageTitle' => 'Criar Usuário',
        'url' => '/users/create',
        'actions' => []
    ])

    <!-- END PAGE HEADER -->


    <div class="row">
        <div class="col-md-12">

            @include('users.partials.register', [
            'action' => 'create',
            'sendButtonText' => 'Criar Usuário'

            ])
        </div>
    </div>
@endsection
