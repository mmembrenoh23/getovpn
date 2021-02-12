<!DOCTYPE html>
<!-- saved from url=(0099)https://themeselection.com/demo/chameleon-admin-template/html/ltr/vertical-menu-template/login.html -->
<html class="loaded" lang="en" data-textdirection="ltr">
    <!-- BEGIN: Head-->
    <head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description"
        content="Application made of Laravel to admin vpn files and allows some user to download with a token">
    <meta name="keywords"
        content="VPN, laravel, app">
    <meta name="author" content="Data Protection – IT4Canada">
    <title>@yield("title","")</title>
    <link rel="apple-touch-icon" href="{{ asset('theme-assets/images/logo-alt-300x65.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="theme-assets/images/logo-alt-300x65.png">
    <link href="https://fonts.googleapis.com/css?family=Muli:300,300i,400,400i,600,600i,700,700i%7CComfortaa:300,400,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/css/vendors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/vendors/css/forms/toggle/switchery.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/css/plugins/forms/switch.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/css/core/colors/palette-switch.min.css')}}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/css/bootstrap-extended.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/css/colors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/css/components-lite.min.css')}}">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/css/core/menu/menu-types/vertical-menu.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/css/core/colors/palette-gradient.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/css/pages/login-register.min.css')}}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <!-- END: Custom CSS-->

  </head>
  <!-- END: Head-->

  <!-- BEGIN: Body-->
  <body class="vertical-layout vertical-menu 1-column  bg-full-screen-image blank-page blank-page  pace-done" data-open="click" data-menu="vertical-menu" data-color="bg-gradient-x-purple-blue" data-col="1-column"><div class="pace  pace-inactive">
      <div class="pace-progress" data-progress-text="100%" data-progress="99" style="transform: translate3d(100%, 0px, 0px);">
        <div class="pace-progress-inner"></div>
      </div>

      <div class="pace-activity"></div></div>
      <!-- BEGIN: Content-->
      <div class="app-content content">
        <div class="content-wrapper">
          <div class="content-wrapper-before"></div>
          <div class="content-header row">
          </div>
          <div class="content-body">

            <section class="flexbox-container">
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="col-lg-4 col-md-6 col-10 box-shadow-2 p-0">
                        <div class="card border-grey border-lighten-3 px-1 py-1 m-0">
                            @yield("content-form")
                        </div>
                    </div>
                </div>
            </section>

          </div>
        </div>
      </div>
      <!-- END: Content-->


      <!-- BEGIN: Vendor JS-->
      <script src="{{asset('theme-assets/vendors/js/vendors.min.js')}}" type="text/javascript"></script>
      <script src="{{asset('theme-assets/vendors/js/forms/toggle/switchery.min.js')}}" type="text/javascript"></script>
      <script src="{{asset('theme-assets/vendors/js/forms/toggle/switch.min.js')}}" type="text/javascript"></script>
      <!-- BEGIN Vendor JS-->

      <!-- BEGIN: Page Vendor JS-->
      <script src="{{asset('theme-assets/vendors/js/forms/validation/jqBootstrapValidation.js')}}" type="text/javascript"></script>
      <!-- END: Page Vendor JS-->

      <!-- BEGIN: Theme JS-->
      <script src="{{asset('src/js/core/app-menu-lite.js')}}" type="text/javascript"></script>
      <script src="{{asset('src/js/core/app-lite.js')}}" type="text/javascript"></script>
      <!-- END: Theme JS-->

      <!-- BEGIN: Page JS-->
      <script src="{{asset('src/js/scripts/forms/form-login-register.min.js')}}" type="text/javascript"></script>
      <!-- END: Page JS-->


    <!-- END: Body-->
  </body>
</html>
