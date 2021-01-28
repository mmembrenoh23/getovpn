@extends('shared.app')

@section('title', 'Servers')

@push('css')
    <style>
        .server.card{
            cursor: pointer;
        }
    </style>

@endpush

@section('search')
<ul class="nav navbar-nav mr-auto float-left">                   
    <li class="nav-item dropdown navbar-search"><a class="nav-link dropdown-toggle hide"
            data-toggle="dropdown" href="#"><i class="ficon ft-search"></i></a>
        <ul class="dropdown-menu">
            <li class="arrow_box">
                <form>
                    <div class="input-group search-box">
                        <div class="position-relative has-icon-right full-width">
                            <input class="form-control" id="search" type="text"
                                placeholder="Search here...">
                            <div class="form-control-position navbar-search-close"><i class="ft-x">
                                </i></div>
                        </div>
                    </div>
                </form>
            </li>
        </ul>
    </li>
</ul>
@endsection

@section('htmlheader')
    <div class="content-header-left col-md-4 col-12 mb-2">
        <h3 class="content-header-title">Servers</h3>
    </div>
    
@endsection

@section('content')

<div class="row match-height">
    @foreach ($dir as $item)
        <div class="col-lg-3 col-md-12">
            <div class="card server"  data-route="{{ route('server',['server_path'=>$item['dir_path']]) }}">
                <div class="card-body">
                    <h4 class="card-title">{{ $item['dir_name'] }}</h4>
                </div>
                <div class="card-body">
                    <i class="ft-server display-1"></i>
                </div>
                
            </div>
        </div>
    @endforeach
    
</div>
    
@endsection

@push("scripts")
    <script>
        $(".server.card").on("click",function(e){
            e.preventDefault();

            var $data = $(this).data();

            window.location=$data.route;
        });
    
    </script>

@endpush
