@extends('layouts.dashboard')
@section('styles')
    <link href="/dashboard/pages/css/profile.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')

    <!-- BEGIN PAGE HEADER-->

    @include('users.partials.header',[
        'pageTitle' => ''.$user->name.' '.$user->lastname,
        'url' => '/profile',
        'actions' => ['Editar Usuário' => '/users/'.$user->id.'/edit']
    ])

    <!-- END PAGE HEADER -->

<div id="app">
    <!-- BEGIN PROFILE SIDEBAR -->
    <div class="profile-sidebar">
        <!-- PORTLET MAIN -->
        <div class="portlet light profile-sidebar-portlet ">
            <!-- SIDEBAR USERPIC -->
            <div class="profile-userpic">
                <img :src="user.photo" class="img-responsive" alt=""> </div>
            <!-- END SIDEBAR USERPIC -->
            <!-- SIDEBAR USER TITLE -->
            <div class="profile-usertitle">
                <div class="profile-usertitle-name">@{{ user.name }} @{{ user.lastname }}</div>
                <div class="profile-usertitle-job">@{{ user.occupation }} </div>
                <a href="mailto:@{{ user.email }}">@{{ user.email }}</a>
            </div>
            <!-- END SIDEBAR USER TITLE -->
            <!-- SIDEBAR BUTTONS -->
            <div class="profile-userbuttons">
                <a v-show="user.facebook" href="@{{ user.facebook }}" target="_blank"><i class="fa fa-facebook"></i>&nbsp;</a>
                <a v-show="user.twitter" href="@{{ user.twitter }}" target="_blank"><i class="fa fa-twitter"></i>&nbsp;</a>
                <a v-show="user.instagram" href="@{{ user.instagram }}" target="_blank"><i class="fa fa-instagram"></i>&nbsp;</a>
            </div>
            <!-- END SIDEBAR BUTTONS -->
            <!-- SIDEBAR MENU -->
            <div class="profile-usermenu">
                <ul class="nav">
                    <li class="active">
                        <a href="/users/{{$user->id}}">
                            <i class="icon-home"></i> Perfil </a>
                    </li>
                    <li>
                        <a href="/users/{{$user->id}}/edit">
                            <i class="icon-settings"></i> Editar </a>
                    </li>
                    <li>
                        <a href="/help">
                            <i class="icon-info"></i> Help </a>
                    </li>
                </ul>
            </div>
            <!-- END MENU -->
        </div>
        <!-- END PORTLET MAIN -->
    </div>
    <!-- END BEGIN PROFILE SIDEBAR -->
    <!-- BEGIN PROFILE CONTENT -->
    <div class="profile-content">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light ">
                    <div class="portlet-title tabbable-line">
                        <div class="caption caption-md">
                            <i class="icon-globe theme-font hide"></i>
                            <span class="caption-subject font-blue-madison bold uppercase">Conta de usuário</span>
                        </div>
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#tab_1_1" data-toggle="tab">Informaciones Personales</a>
                            </li>
                        </ul>
                    </div>
                    <div class="portlet-body">
                        <div class="tab-content">
                            <!-- PERSONAL INFO TAB -->
                            <div class="tab-pane active" id="tab_1_1">

                                <div class="md-col-2">
                                    <span class="h4">Sobre</span>
                                </div>

                                <div class="md-col-4">
                                    <blockquote>
                                        <p>@{{{ user.about }}}</p>
                                    </blockquote>


                                </div>

                            </div>
                            <!-- END PERSONAL INFO TAB -->


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- END PROFILE CONTENT -->

@endsection

@section('metatags')
    <meta id="token" name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('styles')
    <link href="/dashboard/global/plugins/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
    <link href="/dashboard/global/plugins/dropzone/basic.min.css" rel="stylesheet" type="text/css" />
    <link href="/dashboard/assets/pages/css/profile.min.css" rel="stylesheet" type="text/css">

    <style>

    </style>
@endsection

@section('scripts')


    <script>


        var data = {

            actionUrl : '/users/{{$user->id}}',
            user: {
                id: {{$user->id}},
                _method: 'PATCH',
                name: '{{$user->name}}',
                lastname: '{{$user->lastname}}',
                mobile: '{{$user->mobile}}',
                occupation: '{{$user->occupation}}',
                about: '{{ $user->about }}',
                facebook: '{{$user->facebook}}',
                twitter: '{{$user->twitter}}',
                instagram: '{{$user->instagram}}',
                email: '{{$user->email}}',
                role: '{{$user->role}}',
                photo: '{{$user->photo}}'

            }

        };

        var vm = new Vue({

            el: '#app',
            data: data

        });


    </script>

    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/typeahead.js/0.11.1/typeahead.jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/dashboard/global/scripts/moment.min.js"></script>




@endsection
