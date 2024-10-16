
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
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span>@lang('translation.menu')</span></li>


                <li class="nav-item">
                    <a class="nav-link menu-link {{ (Route::currentRouteName()=='admin.dashboard')?'active':''}}" href="{{route('admin.dashboard')}}" >
                        <i class="ri-dashboard-2-line"></i> <span>Dashboard</span>
                    </a>
                </li>

                @canany('admin-user-view')
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ (Route::currentRouteName()=='admin.user.index')?'active':''}}" href="{{route('admin.user.index')}}" >
                            <i class="ri-parent-fill"></i> <span>@lang('translation.users') </span>
                        </a>
                    </li>
                @endcanany
                @canany('admin-checkin-view')
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ (Route::currentRouteName()=='admin.check-in.index')?'active':''}}" href="{{route('admin.check-in.index')}}" >
                            <i class="ri-bug-2-line"></i> <span>Check In</span>
                        </a>
                    </li>
                @endcanany
                @canany('admin-offloading-view')
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ (Route::currentRouteName()=='admin.off-loading.index')?'active':''}}" href="{{route('admin.off-loading.index')}}" >
                            <i class=" ri-command-fill"></i> <span>Off Loading</span>
                        </a>
                    </li>
                @endcanany
                @canany('admin-putaway-view')
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ (Route::currentRouteName()=='admin.put-away.index')?'active':''}}" href="{{route('admin.put-away.index')}}" >
                            <i class="ri-git-repository-line"></i> <span>Item Put Away</span>
                        </a>
                    </li>
                @endcanany
                @canany('admin-customer-view')
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ (Route::currentRouteName()=='admin.customer.index')?'active':''}}" href="{{route('admin.customer.index')}}" >
                            <i class="ri-user-add-fill"></i> <span>Customers </span>
                        </a>
                    </li>
                @endcanany

                @canany('admin-load-view')
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ (Route::currentRouteName()=='admin.load.index')?'active':''}}" href="{{route('admin.load.index')}}" >
                            <i class="ri-radar-line"></i> <span>Load Type</span>
                        </a>
                    </li>
                @endcanany

                @canany('admin-companies-view')
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ (Route::currentRouteName()=='admin.companies.index')?'active':''}}" href="{{route('admin.companies.index')}}" >
                            <i class="ri-keyboard-box-fill"></i> <span>Companies</span>
                        </a>
                    </li>
                @endcanany

                @canany('admin-carriers-view')
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ (Route::currentRouteName()=='admin.carriers.index')?'active':''}}" href="{{route('admin.carriers.index')}}" >
                            <i class="ri-coin-line"></i> <span>Carriers</span>
                        </a>
                    </li>
                @endcanany

                @canany('admin-wh-view')
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ (Route::currentRouteName()=='admin.wh.index')?'active':''}}" href="{{route('admin.wh.index')}}" >
                            <i class="ri-water-flash-fill"></i> <span>WareHouses</span>
                        </a>
                    </li>
                    @endcanany

                @canany('admin-order-view')
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ (Route::currentRouteName()=='admin.orders.list')?'active':''}}" href="{{route('admin.orders.list')}}" >
                            <i class=" ri-crop-line"></i> <span>Orders Scheduling</span>
                        </a>
                    </li>
                @endcanany
                @canany('admin-order-view')
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ (Route::currentRouteName()=='admin.transactions.index')?'active':''}}" href="{{route('admin.transactions.index')}}" >
                            <i class=" ri-gift-2-line"></i> <span>Transactions</span>
                        </a>
                    </li>
                @endcanany

                @canany('admin-order-view')
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ (Route::currentRouteName()=='admin.work.orders.index')?'active':''}}" href="{{route('admin.work.orders.index')}}" >
                            <i class="ri-briefcase-4-line"></i> <span>Work Orders</span>
                        </a>
                    </li>
                @endcanany

                @canany('admin-order-view')
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ (Route::currentRouteName()=='admin.picking.index')?'active':''}}" href="{{route('admin.picking.index')}}" >
                            <i class="ri-file-ppt-2-line"></i> <span>Picking</span>
                        </a>
                    </li>
                @endcanany

                @canany('admin-order-view')
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ (Route::currentRouteName()=='admin.missing.index')?'active':''}}" href="{{route('admin.missing.index')}}" >
                            <i class="ri-file-excel-2-fill"></i> <span>Missing</span>
                        </a>
                    </li>
                @endcanany


                @canany('admin-order-view')
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ (Route::currentRouteName()=='admin.qc.index')?'active':''}}" href="{{route('admin.qc.index')}}" >
                            <i class="ri-book-3-fill"></i> <span>QC</span>
                        </a>
                    </li>
                @endcanany

                 <li class="nav-item">
                        <a class="nav-link menu-link {{ (Route::currentRouteName()=='admin.roles.index' OR Route::currentRouteName()=='admin.language.index' OR Route::currentRouteName()=='admin.app-settings.index')?'active':''}}" href="#sidebarDashboards" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                            <i class="ri-settings-2-line"></i> <span>@lang('translation.settings')</span>
                        </a>

                        <div class="collapse menu-dropdown {{ (Route::currentRouteName()=='admin.roles.index' OR Route::currentRouteName()=='admin.language.index' OR Route::currentRouteName()=='admin.app-settings.index')?'collapse show':''}}" id="sidebarDashboards">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    @canany('admin-settings-edit')
                                  <a href="{{route('admin.app-settings.index')}}" class="nav-link {{ ( Route::currentRouteName()=='admin.app-settings.index')?'active':''}}">@lang('translation.app_settings')</a>
                                    @endcanany
                                    @canany('admin-role-view')
                                        <a href="{{route('admin.roles.index')}}" class="nav-link {{ (Route::currentRouteName()=='admin.roles.index')?'active':''}}">@lang('translation.roles')</a>
                                    @endcanany

                                        @canany('admin-custom_fields-view')
                                            <a href="{{route('admin.customField.index')}}" class="nav-link {{ (Route::currentRouteName()=='admin.customField.index')?'active':''}}">@lang('translation.custom_fields')</a>
                                        @endcanany

                                        @canany('admin-notification-template-view')
                                            <a href="{{route('admin.notification.index')}}" class="nav-link {{ (Route::currentRouteName()=='admin.notification.index')?'active':''}}">Notification Templates</a>
                                        @endcanany
                                </li>



                            </ul>
                        </div>
                    </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<div class="vertical-overlay"></div>
