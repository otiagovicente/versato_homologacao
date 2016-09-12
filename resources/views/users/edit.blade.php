
@extends('layouts.dashboard')
@section('styles')
    <link href="/dashboard/pages/css/profile.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')

    <!-- BEGIN PAGE HEADER-->

    @include('users.partials.header',[
        'pageTitle' => ''.$user->name.' '.$user->lastname,
        'url' => '/users/'.$user->id.'/edit',
        'actions' => []
    ])

    <!-- END PAGE HEADER -->


    <div class="row">
        <div class="col-md-12">

            @include('users.partials.form', [
            'action' => 'edit',
            'sendButtonText' => 'Editar Usuário'

            ])
        </div>
    </div>
@endsection
