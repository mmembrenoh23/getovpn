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
                <form method="GET" id="search-box">
                    <div class="input-group search-box">
                        <div class="position-relative has-icon-right full-width">
                            <input class="form-control" id="search" type="text"
                                placeholder="Search here..."  data-route="{{ route('search-server',['query'=>'?']) }}" >
                            <div class="form-control-position navbar-search-close" data-route="{{ route('search-server',['query'=>'?']) }}"><i class="ft-x">
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
    @include('admin.servers.search-server', ['dir'=>$dir])

</div>

@endsection

@push("scripts")
    <script>
        $(".row.match-height").on("click",".server.card",function(e){
            e.preventDefault();

            var $data = $(this).data();

            window.location=$data.route;
        });

        $("#search-box").on("input", "#search", function(e) {
            e.preventDefault();
            var $route =  $(this).data('route');

            var $query= $(this).val();

            if($.trim($query.length) == 0){
             return false;
            }
             $route=  $route.replace('?',$query);

            try {
                App._urlToSend=$route;
                App._data=null;
                App._method="GET";
                App._dataType = "HTML";

                App._beforeSend = $(".row.match-height");

                $.when(App.fnSendData())
                    .done(function($_resultado) {

                     $(".row.match-height").html($_resultado);

                }).fail(function(errorThrown){
                    var message=errorThrown.responseJSON.errors+" "+errorThrown.responseJSON.message;
                    toastr.error(message);
                });

            } catch (error) {
                toastr.error(error.message);
            }
        }).on("click",".navbar-search-close",function(e){
            e.preventDefault();

            var $route =  $(this).data('route');
            $route=  $route.replace('?','reset');
            try {
                App._urlToSend=$route;
                App._data=null;
                App._method="GET";
                App._dataType = "HTML";

                App._beforeSend = $(".row.match-height");

                $.when(App.fnSendData())
                    .done(function($_resultado) {

                     $(".row.match-height").html($_resultado);
                     $(e.delegateTarget).find("#search").val("");

                }).fail(function(errorThrown){
                    var message=errorThrown.responseJSON.errors+" "+errorThrown.responseJSON.message;
                    toastr.error(message);
                });

            } catch (error) {
                toastr.error(error.message);
            }
        });

    </script>


@endpush
