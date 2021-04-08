@extends('shared.authentication.auth')

@section('title', 'Login App')

@section('content-form')
<div class="card-header border-0">
    <div class="text-center mb-1">
            <img src="{{ asset('theme-assets/images/logo-alt-300x65.png')}}" alt="branding logo">
    </div>
    <div class="font-large-1  text-center">
        Login
    </div>

</div>
<div class="card-content">

    <div class="card-body">
        <form class="form-horizontal" action="{{ route('loginuser') }}" method="POST" novalidate="">
         {{csrf_field()}}
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{session('error')}}
                </div>
            @endif
            <fieldset class="form-group position-relative has-icon-left">
                <input type="text" class="form-control round @error('username') is-invalid @enderror" id="username" name="username" placeholder="Your Username" required="" value="{{ old('username') }}">
                <div class="form-control-position">
                    <i class="ft-user"></i>
                </div>
            </fieldset>
            <fieldset class="form-group position-relative has-icon-left">
                <input type="password" class="form-control round {{ $errors->has('password') ? ' is-invalid' : '' }}" id="userpassword" name="password" placeholder="Enter Password" required="">
                <div class="form-control-position">
                    <i class="ft-lock"></i>
                </div>
                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </fieldset>
            <div class="form-group row">
                <div class="col-md-6 col-12 text-center text-sm-left">

                </div>

            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn round btn-block btn-glow btn-bg-gradient-x-purple-blue col-12 mr-1 mb-1">Login</button>
            </div>

        </form>
    </div>

</div>
@endsection
