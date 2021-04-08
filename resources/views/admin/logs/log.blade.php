@extends('shared.app')

@section('title_site', "Logs")


@section('htmlheader')
    <div class="content-header-left col-md-4 col-12 mb-2">
        <h3 class="content-header-title">Logs</h3>
    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title"> Log's App </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive log-app" data-log_app_route="{{ route('logs-app') }}">
            <table class="table" id="tbLogApp">

            </table>
        </div>


    </div>

</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title"> Log's file downloaded </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive log-file" data-log_file_route="{{ route('logs-file') }}">
            <table class="table" id="tbLogFile">

            </table>
        </div>
    </div>
</div>


@endsection

@push("scripts")
    <script src="{{ asset('assets/js/logs.js') }}"></script>
@endpush
