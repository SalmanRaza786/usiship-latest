
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

                @canany(['admin-checkin-view','admin-offloading-view','admin-putaway-view'])
                <li class="nav-item">
                    <a class="nav-link menu-link {{ (Route::currentRouteName()=='admin.check-in.index' OR Route::currentRouteName()=='admin.off-loading.index' OR Route::currentRouteName()=='admin.put-away.index')?'active':''}}" href="#inbound" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="inbound">
                        <i class="ri-install-line"></i> <span>Inbound</span>
                    </a>

                    <div class=" menu-dropdown {{ ( Route::currentRouteName()=='admin.off-loading.index' OR Route::currentRouteName()=='admin.put-away.index') ?'collapse show':'collapse'}}" id="inbound">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                @canany('admin-checkin-view')
                                    <a href="{{route('admin.check-in.index')}}" class="nav-link {{ (Route::currentRouteName() == 'admin.check-in.index') ? 'active' : '' }}">Check In</a>
                                @endcanany
                                @canany('admin-offloading-view')
                                    <a href="{{route('admin.off-loading.index')}}" class="nav-link {{ (Route::currentRouteName()=='admin.off-loading.index')?'active':''}}">Off Loading</a>
                                @endcanany

                                @canany('admin-putaway-view')
                                    <a href="{{route('admin.put-away.index')}}" class="nav-link {{ (Route::currentRouteName()=='admin.put-away.index')?'active':''}}">Item Put Away</a>
                                @endcanany
                            </li>
                        </ul>
                    </div>
                </li>
                @endcanany

                @canany(['admin-w-order-view','admin-picking-view','admin.missing.index','admin-qc-view','admin-checkin-view','admin-offloading-view'])
                <li class="nav-item">
                    <a class="nav-link menu-link {{ (Route::currentRouteName()=='admin.on-loading.index' OR Route::currentRouteName()=='admin.outbound.check-in.index' OR Route::currentRouteName()=='admin.work.orders.index' OR Route::currentRouteName()=='admin.picking.index' OR Route::currentRouteName()=='admin.missing.index' OR Route::currentRouteName()=='admin.qc.index')?'active':''}}" href="#sidebarDashboards4" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboards4">
                        <i class="ri-uninstall-line"></i> <span>Outbound</span>
                    </a>
                    <div class="collapse menu-dropdown {{ (Route::currentRouteName()=='admin.on-loading.index' OR Route::currentRouteName()=='admin.outbound.check-in.index' OR Route::currentRouteName()=='admin.work.orders.index' OR Route::currentRouteName()=='admin.picking.index' OR Route::currentRouteName()=='admin.missing.index' OR Route::currentRouteName()=='admin.qc.index') ?'collapse show':''}}" id="sidebarDashboards4">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                    @canany('admin-w-order-view')
                                        <a href="{{route('admin.work.orders.index')}}" class="nav-link {{ ( Route::currentRouteName()=='admin.work.orders.index')?'active':''}}">Orders</a>
                                    @endcanany
                                    @canany('admin-picking-view')
                                        <a href="{{route('admin.picking.index')}}" class="nav-link {{ (Route::currentRouteName()=='admin.picking.index')?'active':''}}">Picking</a>
                                    @endcanany
                                        @canany('admin-missing-view')
                                        <a href="{{route('admin.missing.index')}}" class="nav-link {{ (Route::currentRouteName()=='admin.missing.index')?'active':''}}">Missing</a>
                                    @endcanany
                                    @canany('admin-qc-view')
                                        <a href="{{route('admin.qc.index')}}" class="nav-link {{ (Route::currentRouteName()=='admin.qc.index')?'active':''}}">Quality Check (QC)</a>
                                    @endcanany
                                    @canany('admin-qc-view')
                                        <a href="{{route('admin.process.index')}}" class="nav-link {{ (Route::currentRouteName()=='admin.process.index')?'active':''}}">Processing</a>
                                    @endcanany
                                    @canany('admin-checkin-view')
                                        <a href="{{route('admin.outbound.check-in.index')}}" class="nav-link {{ (Route::currentRouteName() == 'admin.outbound.check-in.index' )? 'active' : '' }}">Check In</a>
                                    @endcanany
                                    @canany('admin-offloading-view')
                                        <a href="{{route('admin.on-loading.index')}}" class="nav-link {{ (Route::currentRouteName()=='admin.on-loading.index')?'active':''}}">On Loading</a>
                                    @endcanany

                            </li>
                        </ul>
                    </div>
                </li>
                @endcanany

                @canany(['admin-order-view','admin-order-view'])
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ (Route::currentRouteName()=='admin.orders.list' OR Route::currentRouteName()=='admin.transactions.index')?'active':''}}" href="#sidebarDashboards3" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboards3">
                            <i class="ri-gift-2-line"></i> <span>Transactions</span>
                        </a>

                        <div class="collapse menu-dropdown {{ (Route::currentRouteName()=='admin.orders.list' OR Route::currentRouteName()=='admin.wh.index') ?'collapse show':''}}" id="sidebarDashboards3">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    @canany('admin-order-view')
                                        <a href="{{route('admin.orders.list')}}" class="nav-link {{ ( Route::currentRouteName()=='admin.orders.list')?'active':''}}">Orders Scheduling</a>
                                    @endcanany
                                    @canany('admin-order-view')
                                        <a href="{{route('admin.transactions.index')}}" class="nav-link {{ (Route::currentRouteName()=='admin.transactions.index')?'active':''}}">Transactions</a>
                                    @endcanany

                                </li>
                            </ul>
                        </div>
                    </li>
                @endcanany

                @canany(['admin-customer-view','admin-customer-companies-view'])
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ (Route::currentRouteName()=='admin.customer.index' OR Route::currentRouteName()=='admin.customer-companies.index')?'active':''}}" href="#customers" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="customers">
                            <i class="ri-team-line"></i> <span>Customers</span>
                        </a>

                        <div class="collapse menu-dropdown {{ (Route::currentRouteName()=='admin.customer.index' OR Route::currentRouteName()=='admin.customer-companies.index') ?'collapse show':''}}" id="customers">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    @canany('admin-customer-companies-view')
                                        <a href="{{route('admin.customer-companies.index')}}" class="nav-link {{ ( Route::currentRouteName()=='admin.customer-companies.index')?'active':''}}">Companies</a>
                                    @endcanany
                                    @canany('admin-customer-view')
                                        <a href="{{route('admin.customer.index')}}" class="nav-link {{ (Route::currentRouteName()=='admin.customer.index')?'active':''}}">Contacts</a>
                                    @endcanany

                                </li>
                            </ul>
                        </div>
                    </li>
                @endcanany


                @canany(['admin-companies-view','admin-carriers-view'])
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ (Route::currentRouteName()=='admin.companies.index' OR Route::currentRouteName()=='admin.carriers.index')?'active':''}}" href="#carrier" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="carrier">
                            <i class="ri-truck-line"></i> <span>Carriers</span>
                        </a>

                        <div class="collapse menu-dropdown {{ (Route::currentRouteName()=='admin.companies.index' OR Route::currentRouteName()=='admin.carriers.index') ?'collapse show':''}}" id="carrier">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    @canany('admin-companies-view')
                                        <a href="{{route('admin.companies.index')}}" class="nav-link {{ ( Route::currentRouteName()=='admin.companies.index')?'active':''}}">Companies</a>
                                    @endcanany
                                    @canany('admin-carriers-view')
                                        <a href="{{route('admin.carriers.index')}}" class="nav-link {{ (Route::currentRouteName()=='admin.carriers.index')?'active':''}}">Carriers</a>
                                    @endcanany

                                </li>
                            </ul>
                        </div>
                    </li>
                @endcanany

                @canany(['admin-load-view','admin-wh-view'])
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ (Route::currentRouteName()=='admin.load.index' OR Route::currentRouteName()=='admin.wh.index')?'active':''}}" href="#wh" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="wh">
                            <i class="ri-home-gear-line"></i> <span>Warehouse Settings </span>
                        </a>

                        <div class="collapse menu-dropdown {{ (Route::currentRouteName()=='admin.load.index' OR Route::currentRouteName()=='admin.wh.index') ?'collapse show':''}}" id="wh">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    @canany('admin-load-view')
                                        <a href="{{route('admin.load.index')}}" class="nav-link {{ ( Route::currentRouteName()=='admin.load.index')?'active':''}}">Load Type</a>
                                    @endcanany
                                    @canany('admin-wh-view')
                                        <a href="{{route('admin.wh.index')}}" class="nav-link {{ (Route::currentRouteName()=='admin.wh.index')?'active':''}}">WareHouses</a>
                                    @endcanany

                                </li>
                            </ul>
                        </div>
                    </li>
                @endcanany

                @canany(['admin-settings-edit','admin-role-view','admin-custom_fields-view','admin-notification-template-view','admin-user-view'])
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ (Route::currentRouteName()=='admin.roles.index' OR Route::currentRouteName()=='admin.language.index' OR Route::currentRouteName()=='admin.app-settings.index') OR Route::currentRouteName()=='admin.user.index'?'active':''}}" href="#sidebarDashboards" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                            <i class="ri-settings-2-line"></i> <span>@lang('translation.settings')</span>
                        </a>

                        <div class="collapse menu-dropdown {{ (Route::currentRouteName()=='admin.roles.index' OR Route::currentRouteName()=='admin.language.index' OR Route::currentRouteName()=='admin.app-settings.index') OR Route::currentRouteName()=='admin.user.index'?'collapse show':''}}" id="sidebarDashboards">
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
                                        @canany('admin-user-view')
                                            <a href="{{route('admin.user.index')}}" class="nav-link {{ (Route::currentRouteName()=='admin.user.index')?'active':''}}">@lang('translation.users')</a>
                                        @endcanany
                                </li>
                            </ul>
                        </div>
                    </li>
                @endcanany

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<div class="vertical-overlay"></div>
