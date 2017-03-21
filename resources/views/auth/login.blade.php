@extends('layouts.lock')

@section('content')

    <div class="content">
        <!-- BEGIN LOGIN FORM -->
        <form class="login-form" novalidate="novalidate" role="form" method="POST" action="{{ url('/login') }}">
            {{ csrf_field() }}
            <h3 class="form-title font-green">Sign In</h3>
            <div class="alert alert-danger display-hide">
                <button class="close" data-close="alert"></button>
                <span> Enter any username and password. </span>
            </div>
            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                <label class="control-label visible-ie8 visible-ie9">Username</label>
                <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email">
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                <label class="control-label visible-ie8 visible-ie9">Password</label>
                <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password"> </div>
            @if ($errors->has('password'))
                <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
            @endif
            <div class="form-actions">
                <button type="submit" class="btn green uppercase">Login</button>
                <label class="rememberme check mt-checkbox mt-checkbox-outline">
                    <input type="checkbox" name="remember" value="1">Remember
                    <span></span>
                </label>
                <a href="{{ url('/password/reset') }}" id="forget-password" class="forget-password">Esqueceu sua senha?</a>
            </div>

            <div class="create-account">
                <p>
                    <a href="javascript:;" id="register-btn" class="uppercase">Create an account</a>
                </p>
            </div>
        </form>
        <!-- END LOGIN FORM -->

    </div>



@endsection
