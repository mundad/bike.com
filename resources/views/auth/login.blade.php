@extends('layouts.app')

@section('content')
<section class="login-content">
<div class="login-box">
    <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}" class="login-form">
        @csrf
        <h4 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>SIGN IN</h4>
        <div class="form-group row">
            <label for="login" class="control-label">{{ __('Login') }}</label>
            <input  placeholder="Login" id="login" type="text" class="form-control{{ $errors->has('login') ? ' is-invalid' : '' }} block" name="login" value="{{ old('login') }}" required autofocus>
            @if ($errors->has('login'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('login') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group row">
            <label for="password" class="control-label">{{ __('Password') }}</label>
            <input id="password" placeholder="Password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group row">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                </label>
            </div>
            <a class="btn btn-link" href="{{ route('password.request') }}">
                {{ __('Forgot Your Password?') }}
            </a>
        </div>

        <div class="form-group row mb-0">
            <button type="submit" class="btn btn-primary btn-block">
                <i class="fa fa-sign-in fa-lg fa-fw"></i>SIGN IN
            </button>
        </div>
    </form>
</div>
</section>
@endsection
