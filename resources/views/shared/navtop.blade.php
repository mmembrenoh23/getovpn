<!-- fixed-top-->
<nav
        class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-light">
        <div class="navbar-wrapper">
            <div class="navbar-container content">
                <div class="collapse navbar-collapse show" id="navbar-mobile">

                    @if (trim($__env->yieldContent('search')))
                        @yield("search")
                    @else

                    <div class="nav navbar-nav mr-auto float-left">

                    </div>

                    @endif



                    <ul class="nav navbar-nav float-right">

                        <li class="dropdown dropdown-user nav-item"><a
                                class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                <span class="avatar avatar-online"><img
                                        src="{{ asset('theme-assets/images/portrait/small/avatar-s-19.png')}}"
                                        alt="avatar"><i></i></span></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="arrow_box_right"><a class="dropdown-item" href="#"><span
                                            class="avatar avatar-online"><img
                                                src="{{ asset('theme-assets/images/portrait/small/avatar-s-19.png')}}"
                                                alt="avatar"><span class="user-name text-bold-700 ml-1">{{Auth::guard('admin')->user()->username}}</span></span></a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('users.edit',['user'=>Auth::guard('admin')->user()->id]) }}">
                                        <i class="ft-user"></i> Edit Profile
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('logout')}}">
                                        <i class="ft-power"></i> Logout
                                    </a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- ////////////////////////////////////////////////////////////////////////////-->
