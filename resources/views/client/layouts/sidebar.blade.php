<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        @if($appInfo->count() > 0)
            <a href="{{route('admin.dashboard')}}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('storage/appsettings/'.$appInfo->where('key','app_logo')->pluck('value')->first())}}" alt="" height="22">
            </span>
                <span class="logo-lg">
                <img src="{{ URL::asset('storage/appsettings/'.$appInfo->where('key','app_logo')->pluck('value')->first()) }}" alt="" height="33">
            </span>
            </a>
            <!-- Light Logo-->
            <a href="{{url('/')}}" class="logo logo-light ">
            <span class="logo-sm">
                <img src="{{ URL::asset('storage/appsettings/'.$appInfo->where('key','app_logo')->pluck('value')->first()) }}" alt="" height="22">
            </span>
                <span class="logo-lg">
                <img src="{{ URL::asset('storage/appsettings/'.$appInfo->where('key','app_logo')->pluck('value')->first()) }}" alt="" height="17">
            </span>
            </a>
        @else
            <a href="{{url('/')}}" class="logo logo-light">
            <span class="logo-sm">
             <img src="{{ URL::asset('build/images/logo-light.png')}}" alt="" height="22">
            </span>
                <span class="logo-lg">
          <img src="{{ URL::asset('build/images/logo-light.png')}}" alt="" height="17">
            </span>
            </a>

        @endif
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid dropdown-custom-right">
            <div id="two-column-menu"></div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ (Route::currentRouteName()=='user.index')?'active':''}} " href="{{route('user.index')}}"  role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboard</span>
                    </a>
                </li>
                <!-- end Dashboard Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link" {{ (Route::currentRouteName()=='user.appointment.index')?'active':''}} href="#sidebarApps" data-bs-toggle="collapse" role="button" aria-expanded="true" aria-controls="sidebarApps">
                        <i class="ri-briefcase-line"></i> <span data-key="t-apps">Appointments</span>
                    </a>
                    <div class="menu-dropdown dropdown-custom-left collapse " id="sidebarApps" style="">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{route('user.appointment.index')}} " class="nav-link {{ (Route::currentRouteName()=='user.appointment.index')?'active':''}} " data-key="t-api-key">New Appointment</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('user.appointment.show-list')}}" {{ (Route::currentRouteName()=='user.appointment.show-list')?'active':''}} class="nav-link" data-key="t-api-key">Appointments List</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link " href="{{route('appointment.download-list')}}"  role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-download-2-line"></i> <span data-key="t-dashboards">Download Packaging List Sample File</span>
                    </a>
                </li>

{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link menu-link collapsed" href="#sidebarLayouts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLayouts">--}}
{{--                        <i class="ri-flight-takeoff-line"></i> <span data-key="t-layouts">Shipments </span> <span class="badge badge-pill bg-danger" data-key="t-hot">Hot</span>--}}
{{--                    </a>--}}
{{--                    <div class="collapse menu-dropdown dropdown-custom-left" id="sidebarLayouts">--}}
{{--                        <ul class="nav nav-sm flex-column">--}}
{{--                            <li class="nav-item">--}}
{{--                                <a href="#" class="nav-link" data-key="t-api-key">Shipments List</a>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </li>--}}
{{--                <!-- end Dashboard Menu -->--}}

{{--                <li class="menu-title"><i class="ri-more-fill" aria-expanded="false"></i> <span data-key="t-pages">Pages</span></li>--}}

{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link menu-link collapsed" href="#sidebarAuth" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAuth">--}}
{{--                        <i class="ri-alarm-warning-line"></i> <span data-key="t-authentication">Quotes </span>--}}
{{--                    </a>--}}
{{--                    <div class="collapse menu-dropdown dropdown-custom-left" id="sidebarAuth">--}}
{{--                        <ul class="nav nav-sm flex-column">--}}
{{--                            <li class="nav-item">--}}
{{--                                <a href="#" class="nav-link" data-key="t-api-key">Quotes List</a>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </li>--}}
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
