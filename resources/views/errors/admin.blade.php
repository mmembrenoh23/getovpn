@extends('shared.app')
@section('title_site', "Exception")

@section('htmlheader')
    <div class="content-header-left col-md-4 col-12 mb-2">
        <h3 class="content-header-title">Exception</h3>
    </div>

@endsection

@section('content')

    <div class="row match-height">
        <div class="col-2">

        </div>
        <div class="col-xl-8 col-lg-12">
            <div class="alert alert-danger alert-dismissible alert-light mb-2" role="alert">
                <h4 class="alert-heading mb-2">Ooh oh!</h4>
                <p><span class="text-bold-700">Code:</span> {{$exception->getCode()}}</p>
               <p><span class="text-bold-700">Line:</span> {{$exception->getLine()}}</p>
               <p><span class="text-bold-700">File:</span> {{$exception->getFile()}}</p>
               <p><span class="text-bold-700">Message:</span> {{$exception->getMessage()}}</p>

            </div>

        </div>
        <div class="col-2">

        </div>

    </div>




@endsection


