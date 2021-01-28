@extends('shared.app')

@section('title', $server_name)


@section('htmlheader')
    <div class="content-header-left col-md-4 col-12 mb-2">
        <h3 class="content-header-title">{{ $server_name }}</h3>
    </div>   
    <div class="content-header-right col-md-8 col-12">
        <div class="form-group float-md-right">
            <button type="button" class="btn btn-secondary mr-1"><i class="ft-arrow-left"></i></button>
        </div>
    </div>
@endsection

@section('content')

<div class="row match-height">
    @foreach ($files as $item)
        <div class="col-lg-3 col-md-12">
            <div class="card" data-id="{{ $item['id'] }}">
                <div class="card-body">
                    <h3 class="card-title">{{ $item['file_name'] }}</h3>
                    
                    <div class="d-flex justify-content-center">
                        <i class="ft-file-text display-1"></i>
                        <ul>
                            <li>
                                Size: {{ $item['file_size'] }}
                            </li>
                            <li>
                                Created: {{ $item['file_created'] }}
                            </li>
                            <li>
                              Owner: {{ $item['owner'] }}
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-footer border-top-blue-grey border-top-lighten-5 text-muted">
                    <span>
                        <a href="#" class="card-link" title="Editar atributos" data-toggle="modal" data-target="#mEditar">
                            <i class="la la-edit"></i>
                        </a>
                        <a href="#" class="card-link">
                            <i class="la la-cloud-download" title="Download"></i>
                        </a>
                        <a href="#" class="card-link" title="Secret" data-toggle="modal" data-target="#mGenerarSecret">
                            <i class="la la-key"></i>
                        </a>
                        <a href="#" class="card-link" title="Obtener Link">
                            <i class="la la-globe"></i>
                        </a>
                    </span>
                </div>
            </div>
        </div>
    @endforeach
    
</div>
    
@endsection

@include('admin.servers.edit-modal')
@include('admin.servers.load-secret-modal')