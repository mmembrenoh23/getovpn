<!DOCTYPE html>
<html class="loaded" lang="en" data-textdirection="ltr">
    <!-- BEGIN: Head-->
    @include("shared.head")

<body class="vertical-layout vertical-menu 2-columns   menu-expanded fixed-navbar" data-open="click"
    data-menu="vertical-menu" data-color="bg-gradient-x-blue-cyan" data-col="2-columns">

    @include("shared.navtop")
    @include("shared.sidebar")
    <div class="app-content content">
        <div class="content-wrapper">
            @include("shared.htmlheader")
            @yield('content')
        </div>
    </div>

    @include('shared.footer')
    @include('shared.scripts')
</body>
  