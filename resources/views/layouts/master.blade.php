
<!doctype html >
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable"
      dir="{{(Session::get('direction'))}}">

<head>
    <meta charset="utf-8" />
    <title>@yield('title')| {{ ($appInfo->count() > 0)? $appInfo[0]->value : 'BDC'}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="description" />
    <meta content="" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('build/images/logo-dark.png') }}">
    @include('layouts.head-css')
</head>

@section('body')
    @include('layouts.body')
@show
<!-- Begin page -->
<div id="layout-wrapper">
    @routes
    @include('layouts.topbar')
    @include('layouts.sidebar')



    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">


                @yield('content')


                <div id="myCustomPreLoader" >
                    <div id="status">
                        <div class="spinner-border text-primary avatar-sm" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>


            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
        @include('layouts.footer')
    </div>
    <!-- end main content-->
</div>


@include('layouts.customizer')

<!-- JAVASCRIPT -->
@include('layouts.vendor-scripts')

<div aria-live="polite" aria-atomic="true" class="bd-example bg-light position-relative" style="height: 300px;">
    <div class="toast-container position-absolute p-3" id="toastPlacement">
        <div class="toast" id="myToast">
            <div class="toast-header">
                <img src="assets/images/logo-sm.png" class="rounded me-2" alt="..." height="20">
                <strong class="me-auto">Velzon</strong>
                <small>11 mins ago</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Hello, world! This is a toast message.
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function (){
        hideLoader();
        function hideLoader(){
            $('#myCustomPreLoader').css('display', 'none');
        }
    })
</script>
</body>
</html>

