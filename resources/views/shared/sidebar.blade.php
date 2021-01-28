<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow menu-dark " data-scroll-to-active="true"
        data-img="{{ asset('theme-assets/images/backgrounds/02.jpg')}}">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto"><a class="navbar-brand" href="{{ route('servers') }}"><img class="brand-logo"
                            alt="Chameleon admin logo" src="{{ asset('theme-assets/images/logo-alt-300x65.png')}}" />
                    </a></li>
                <li class="nav-item d-md-none"><a class="nav-link close-navbar"><i class="ft-x"></i></a></li>
            </ul>
        </div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
               
                <li class="active nav-item"><a href="{{ route('servers') }}"><i class="ft-server"></i><span class="menu-title"
                            data-i18n="">Servers</span></a>
                </li>
                <li class="nav-item has-sub">
                        <a href="#">
                            <i class="ft-settings"></i>
                            <span class="menu-title" data-i18n="">Configurations</span>
                        </a>
                    <ul class="menu-content">
                        <li class="is-shown">
                           <a class="menu-item" href="{{ route('config.server') }}">Servers</a>
                        </li>
                        <li class="is-shown">
                           <a class="menu-item" href="{{ route('config.users') }}">Users</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item"><a href="{{ route('logs') }}"><i class="ft-activity"></i><span class="menu-title"
                    data-i18n="">Logs</span></a>
                </li>
            </ul> 
        </div>
        <div class="navigation-background"></div>
    </div>