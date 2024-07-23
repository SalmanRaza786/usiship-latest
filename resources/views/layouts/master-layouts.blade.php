    <!doctype html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="horizontal" data-layout-style="" data-layout-position="fixed"  data-topbar="light">
    <head>
    <meta charset="utf-8" />
    <title> @yield('title') | {{ ($appInfo->count() > 0)? $appInfo[0]->value : 'BDC'}} </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ URL::asset('build/images/logo-dark.png') }}">
    @include('layouts.head-css')

</head>
    <body>
    <div id="layout-wrapper">
        @include('layouts.topbar')
        @include('layouts.sidebar')
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
            @include('layouts.footer')
        </div>
    </div>
    @include('layouts.customizer')
    @include('layouts.vendor-scripts')


    </body>

    </html>
