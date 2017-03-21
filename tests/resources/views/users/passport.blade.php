@extends('layouts.dashboard')

@section('content')

    <!-- BEGIN PAGE HEADER-->

    @include('users.partials.header',[
        'pageTitle' => 'Passport API Tokens',
        'url' => '/users/passport',
        'actions' => []
    ])

    <!-- END PAGE HEADER -->


    <div class="row">
        <div class="col-md-12">


            <passport-clients></passport-clients>
            <passport-authorized-clients></passport-authorized-clients>
            <passport-personal-access-tokens></passport-personal-access-tokens>



        </div>
    </div>
@endsection
