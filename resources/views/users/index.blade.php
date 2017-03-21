
@extends('layouts.dashboard')
@section('styles')
    <link href="/dashboard/pages/css/profile.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')


    @foreach($usersgroup as $role => $users)

        <div class="row">
            <div class="col-md-12">
                <div class="portlet light portlet-fit bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class=" icon-layers font-green"></i>
                            <span class="caption-subject font-green bold uppercase">{{$roles[$role]}}</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="mt-element-card mt-element-overlay">
                            <div class="row">
                                @foreach($users as $user)

                                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">

                                        <div class="mt-card-item">
                                            <div class="mt-card-avatar mt-overlay-1">
                                                <img src="{{$user->photo}}" />
                                                <div class="mt-overlay">
                                                    <ul class="mt-info">
                                                        <li>
                                                            <a target="_blank" class="btn default btn-outline" href="/users/{{$user->id}}">
                                                                <i class="icon-magnifier"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a target="_blank" class="btn default btn-outline" href="/users/{{$user->id}}">
                                                                <i class="icon-link"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="mt-card-content">
                                                <h3 class="mt-card-name">{{ $user->name.' '.$user->lastname }}</h3>
                                                <p class="mt-card-desc font-grey-mint">{{$user->occupation}}</p>
                                                <div class="mt-card-social">
                                                    <ul>
                                                        <li>
                                                            <a target="_blank" href="{{$user->facebook}}">
                                                                <i class="fa fa-facebook"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a target="_blank" href="{{$user->twitter}}">
                                                                <i class="fa fa-twitter"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a target="_blank" href="{{$user->instagram}}">
                                                                <i class="fa fa-instagram"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    @endforeach


@endsection