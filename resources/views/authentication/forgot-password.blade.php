@extends('shared.authentication.auth')

@section('title', 'Forgot Password')

@section('content-form')
<div class="card-header border-0">
    <div class="text-center mb-1">
            <img src="{{ asset('theme-assets/images/logo-alt-300x65.png')}}" alt="It4 Canada">
    </div>
    <div class="font-large-1  text-center">
        Recovery Password
    </div>
    <h6 class="card-subtitle  text-muted text-center font-small-3 pt-2">
        <span>Please put your email to send you an email to recovery your password</span>
    </h6>
</div>
<div class="card-content">

    <div class="card-body">
        <form class="form-horizontal" id="frmRecovery" action="{{route('password.update')}}" novalidate="">
            {{csrf_field()}}
            <fieldset class="form-group position-relative has-icon-left">
                <input type="email" class="form-control round" id="user-email" placeholder="Your Email Address" required="" aria-invalid="false">
                <div class="form-control-position">
                    <i class="ft-mail"></i>
                </div>
            </fieldset>

           <div class="form-group text-center">
                <button type="submit" class="btn round btn-block btn-glow btn-bg-gradient-x-purple-blue col-12 mr-1 mb-1">Enviar</button>
            </div>

        </form>
    </div>

</div>
@endsection

@push('scripts')

<script src="{{ asset('assets/js/auth/recovery.js') }}"></script>

@endpush
