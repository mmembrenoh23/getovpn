@extends('shared.app')

@section('title_site', "Profile ".$user->first_name." ".$user->last_name)

@section('content')

<div id="user-profile">
    <div class="row">
        <div class="col-sm-12 col-xl-10">
            <div class="media d-flex m-1 ">
                <div class="align-left p-1">
                <a href="#" class="profile-image">
                    <img src="{{asset('theme-assets\images\default-user-profile.png')}}" class="rounded-circle img-border height-100" alt="Card image">
                </a>
                </div>
                <div class="media-body text-left  mt-1">
                    <h3 class="font-large-1 white">{{ $user->first_name." ".$user->last_name }} <span class="font-medium-1 white">({{ $user->username }})</span>
                    </h3>
                    <h3 class="font-medium-3 white">{{ $user->email }}
                    </h3>

                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Change Password</h4>
                </div>
                <div class="card-body">
                    <form class="form" id="frmPassword" method="POST" action="{{ route('change-pass',['user'=>$user->id]) }}">
                        <div class="form-body">
                            <div class="form-group">
                                <label for="contactinput5">Password</label>
                                <div class="input-group" >
                                    <input class="form-control border-primary" required id="txtPassword" name="txtPassword" type="password" placeholder="Password">
                                    <span class="input-group-append" id="btnSeePass">
                                        <button class="btn btn-success" type="button" data-repeater-delete="">
                                            <i class="ft-eye-off"></i>
                                        </button>
                                    </span>
                                </div>

                                <div class="generate-password mt-1">
                                    <button class="btn btn-outline-info btn-sm" id="btnGenPass"><i class="ft-lock"></i></button>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions right">
                            <button type="submit" class="btn btn-primary" id="btnSave">
                                <i class="la la-check-square-o"></i> Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Change data user</h4>
                </div>
                <div class="card-body">
                    <form class="form" action="{{ route('users.update',['user'=>$user->id]) }}" id="frmUserProfile">
                        @method("PUT")
                        <div class="form-body">

                            <div class="form-group">
                                <label for="contactinput5">First Name</label>
                                <input class="form-control border-primary" type="text" placeholder="First Name" id="txtFirstName">
                            </div>
                            <div class="form-group">
                                <label for="contactinput5">Last Name</label>
                                <input class="form-control border-primary" type="text" placeholder="Last Name" id="txtLastName">
                            </div>

                            <div class="form-group">
                                <label for="contactinput5">Email</label>
                                <input class="form-control border-primary" type="email" placeholder="Email" id="txtEmail">
                            </div>


                        </div>

                        <div class="form-actions right">
                            <button type="submit" id="btnSave" class="btn btn-primary">
                                <i class="la la-check-square-o"></i> Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection


@push('scripts')
    <script src="{{ asset('theme-assets/js/scripts/extensions/sweetalert2.all.js') }}"></script>
    <script src="{{ asset('assets/js/user-profile.js') }}"></script>
@endpush

