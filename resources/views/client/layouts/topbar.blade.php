<header id="page-topbar" class="">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <a href="{{url('/')}}" class="logo logo-light">
            <span class="logo-sm">
            <img src="https://i.ibb.co/D8JmrVD/USI-Logo-High-light.png" alt="" height="22">
            </span>
                    <span class="logo-lg">
            <img src="https://i.ibb.co/D8JmrVD/USI-Logo-High-light.png" alt="" height="55" />
            </span>
                </a>
                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
            <span class="hamburger-icon">
            <span></span>
            <span></span>
            <span></span>
            </span>
                </button>

            </div>
            <div class="d-flex align-items-center">
                <div class="dropdown d-md-none topbar-head-dropdown header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-search fs-22"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">
                        <form class="p-3">
                            <div class="form-group m-0">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username" />
                                    <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-toggle="fullscreen">
                        <i class="bx bx-fullscreen fs-22"></i>
                    </button>
                </div>
                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                        <i class="bx bx-moon fs-22"></i>
                    </button>
                </div>


                <div class="dropdown topbar-head-dropdown ms-1 header-item" id="notificationDropdown">

                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle btn-nofify" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                        <i class='bx bx-bell fs-22'></i>
                        <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger"><span class="notificationCounter"></span><span class="visually-hidden">unread messages</span></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">

                        <div class="dropdown-head bg-primary bg-pattern rounded-top">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 fs-16 fw-semibold text-white"> Notifications </h6>
                                    </div>
                                    <div class="col-auto dropdown-tabs">
                                        <span class="badge badge-soft-light fs-13"> <span class="notificationCounter"></span> New</span>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div class="tab-content position-relative" id="notificationItemsTabContent">

                            <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: auto; overflow: hidden scroll;">
                                <div data-simplebar style="max-height: 300px;" class="pe-2" id="notificationArea"></div>
                            </div>



                            <div class="empty-notification-elem d-none">

                                <div class="text-center pb-5 mt-2 ms-1">
                                    <span class="fs-18 fw-semibold lh-base">Hey! You have no any notifications </span>
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
                        <a class="dropdown-item" href="{{route('user.logout')}}"><i
                                class="bx bx-power-off font-size-16 align-middle me-1"></i> <span
                                key="t-logout">@lang('translation.logout')</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<script src="{{ URL::asset('build/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
