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

<body class="vertical-layout vertical-menu 1-column  bg-gradient-directional-danger blank-page blank-page  pace-done" data-open="click" data-menu="vertical-menu" data-color="bg-gradient-x-purple-blue" data-col="1-column">
    <div class="pace  pace-inactive">
        <div class="pace-progress" data-progress-text="100%" data-progress="99" style="transform: translate3d(100%, 0px, 0px);">
            <div class="pace-progress-inner"></div>
        </div>
        <div class="pace-activity"></div>
    </div>


    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-wrapper-before"></div>
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section class="flexbox-container bg-hexagons-danger">
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="col-lg-4 col-md-6 col-10 p-0">
                        <div class="card-header bg-transparent border-0">
                            <h2 class="error-code text-center mb-2 white">Exception</h2>
                            <h3 class="text-uppercase text-center white">@yield('code')</h3>
                        </div>
                        <div class="card-content">
                            <div class="alert alert-secondary alert-light alert-dismissible mb-2" role="alert">
									<h4 class="alert-heading mb-2">Exception</h4>
                                    @yield('message')
								</div>
                        </div>

                    </div>
                </div>
            </section>
        </div>
      </div>
    </div>


    @include('shared.footer')
    @include('shared.scripts')
</body>
</html>
