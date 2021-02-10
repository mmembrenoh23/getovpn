@extends('shared.app')

@section('title', "Users App")


@section('htmlheader')
    <div class="content-header-left col-md-4 col-12 mb-2">
        <h3 class="content-header-title">User App</h3>
    </div>
    <div class="content-header-right col-md-8 col-12">
        <div class="form-group float-md-right">
            <button class="btn btn-success" data-toggle="modal" data-target="#mCreateUser"> <i class="ft ft-user"></i> Create User</button>
        </div>

    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead class="bg-primary white">
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                            Username
                        </th>
                        <th>
                            First Name
                        </th>
                        <th>
                            Last Name
                        </th>
                        <th>
                            Created At
                        </th>
                        <th>
                            Status
                        </th>
                        <th>
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>
                                {{ $user->id }}
                            </td>
                            <td>
                                {{ $user->username }}
                            </td>
                            <td>
                                {{ $user->first_name }}
                            </td>
                            <td>
                                {{ $user->last_name }}
                            </td>
                            <td>
                                {{ $user->created_at }}
                            </td>
                             <td>
                                 @if ($user->is_active == 1)

                                    <span class="badge badge-success">Active</span>
                                 @else

                                    <span class="badge badge-danger">Inactive</span>
                                 @endif
                             </td>
                            <td>
                                <button class="btn btn-outline-info btn-sm" data-route="{{route('users.show',['user'=>$user->id])}}" ><i class="ft ft-edit"></i> Edit </button>
                                <button class="btn btn-outline-danger btn-sm" data-route="{{route('users.destroy',['user'=>$user->id])}}"  ><i class="ft ft-user-minus "></i> Inactive </button>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>

@include('admin.config.users.modal-create')

@endsection

@push('scripts')
    <script src="{{ asset('assets/js/users.js') }}"></script>
@endpush
