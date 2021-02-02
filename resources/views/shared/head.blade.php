
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description"
        content="Application made of Laravel to admin vpn files and allows some user to download with a token">
    <meta name="keywords"
        content="VPN, laravel, app">
    <meta name="author" content="Data Protection – IT4Canada">

    <link rel="apple-touch-icon" href="{{ asset('theme-assets/images/logo-alt-300x65.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="theme-assets/images/logo-alt-300x65.png">
    <link
        href="https://fonts.googleapis.com/css?family=Muli:300,300i,400,400i,600,600i,700,700i%7CComfortaa:300,400,700"
        rel="stylesheet">
    <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css" rel="stylesheet">

    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/css/vendors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/vendors/css/charts/chartist.css')}}">
    <!-- END VENDOR CSS-->
    <!-- BEGIN CHAMELEON  CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/css/app-lite.css')}}">
    <!-- END CHAMELEON  CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/css/core/menu/menu-types/vertical-menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/css/core/colors/palette-gradient.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/css/pages/dashboard-ecommerce.css')}}">
    <link href="{{asset('theme-assets/vendors/css/select2/select2.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('theme-assets/vendors/css/tables/datatable/jquery.dataTables.min.css')}}" type="text/css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" type="text/css">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}" type="text/css">
    @stack('css')
    <!-- END Custom CSS-->

