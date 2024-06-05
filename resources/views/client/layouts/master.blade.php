<!doctype html >
<html
    lang="en"
    data-layout="horizontal"
    data-layout-style="default"
    data-layout-position="fixed"
    data-topbar="dark"
    data-sidebar-size="lg"
    data-bs-theme="light"
    data-layout-width="fluid"
    data-sidebar-visibility="show"
    data-preloader="enable"
>
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
<body class="">
<!-- Begin page -->
<div id="layout-wrapper">
    @routes
    @include('client.layouts.topbar')
    @include('client.layouts.sidebar')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
        @include('client.layouts.footer')
    </div>
    <!-- end main content-->
</div>
@include('layouts.customizer')
<!-- JAVASCRIPT -->
@include('client.layouts.vendor-scripts')
</body>
</html>
