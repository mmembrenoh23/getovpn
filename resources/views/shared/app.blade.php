<!DOCTYPE html>
<html class="loaded" lang="en" data-textdirection="ltr">
    <!-- BEGIN: Head-->

<head>

<meta charset="utf-8">
     @include("shared.head")
     <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>{{  config('app.name') }} - @yield('title_site',"something")</title>
    @csrf
</head>


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
</html>
