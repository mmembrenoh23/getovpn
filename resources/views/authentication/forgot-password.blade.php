@extends('shared.authentication.auth')

@section('title', 'Forgot Password')

@section('content-form')
<div class="card-header border-0">
    <div class="text-center mb-1">
            <img src="{{ asset('theme-assets/images/logo/logo.png')}}" alt="branding logo">
    </div>
    <div class="font-large-1  text-center">                       
        Recuperar Contraseña
    </div>
    <h6 class="card-subtitle  text-muted text-center font-small-3 pt-2">
        <span>Le enviaremos un enlace para restablecer la contraseña.</span>
    </h6>
</div>
<div class="card-content">
   
    <div class="card-body">
        <form class="form-horizontal" action="{{route('login')}}" novalidate="">
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