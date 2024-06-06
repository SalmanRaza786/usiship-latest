<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">


                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                        id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>


            </div>

            <div class="d-flex align-items-center">

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                            data-toggle="fullscreen">
                        <i class='bx bx-fullscreen fs-22'></i>
                    </button>
                </div>
                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button"
                            class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                        <i class="bx bx-moon fs-22"></i>
                    </button>
                </div>


                <div class="dropdown topbar-head-dropdown ms-1 header-item" id="notificationDropdown">

                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                        <i class='bx bx-bell fs-22'></i>
                        <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger"><span id="unreadMessage"></span><span class="visually-hidden">unread messages</span></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">

                        <div class="dropdown-head bg-primary bg-pattern rounded-top">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 fs-16 fw-semibold text-white"> Notifications </h6>
                                    </div>
                                    <div class="col-auto dropdown-tabs">
                                        <span class="badge badge-soft-light fs-13"> 4 New</span>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div class="tab-content position-relative" id="notificationItemsTabContent">
                            <div class="tab-pane fade show active py-2 ps-2" id="all-noti-tab" role="tabpanel">
                                <div data-simplebar style="max-height: 300px;" class="pe-2" id="notificationArea">
                                </div>

                            </div>


                        </div>
                    </div>
                </div>


                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <div class="avatar-xxs">
    <div class="avatar-title rounded bg-primary-subtle text-default rounded-circle avatar-md">

         {{  substr(Auth::user()->name, 0, 2)}}

    </div>
</div>
                     {{--       <img class="rounded-circle header-profile-user" src="@if (Auth::user()->avatar != ''){{ URL::asset('images/' . Auth::user()->avatar) }}
                            @else{{ URL::asset('build/images/users/user-dummy-img.jpg') }}@endif" alt="Header Avatar">--}}
                            <span class="text-start ms-xl-2">
                           <span
                               class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">{{Auth::user()->name}}</span>


                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header"> {{__('translation.welcome')}} {{Auth::user()->name}}!</h6>


                        <div class="dropdown-divider"></div>


                        <a class="dropdown-item" href="{{route('admin.logout')}}"><i
                                class="bx bx-power-off font-size-16 align-middle me-1"></i> <span
                                key="t-logout">@lang('translation.logout')</span></a>

                    </div>
                </div>




            </div>
        </div>
    </div>
</header>

<script src="{{ URL::asset('build/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

