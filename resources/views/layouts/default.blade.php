<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    @yield('css')

    <!-- App favicon -->
    <link rel="shortcut icon" href={{ URL::asset('images/favicon.ico') }}>

    <!-- Plugin css -->
    <link href={{ URL::asset('libs/fullcalendar/fullcalendar.min.css') }} rel="stylesheet" type="text/css" />
    <!-- Plugins css inbox-->
    <link href={{ URL::asset('libs/quill/quill.core.css') }} rel="stylesheet" type="text/css" />
    <link href={{ URL::asset('libs/quill/quill.bubble.css') }} rel="stylesheet" type="text/css" />
    <!-- Custom box css inbox-->
    <link href={{ URL::asset('libs/custombox/custombox.min.css') }} rel="stylesheet">

    <!-- Tablesaw css -->
    <link href={{ URL::asset('libs/tablesaw/tablesaw.css') }} rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href={{ URL::asset('css/bootstrap.min.css') }} id="bootstrap-stylesheet" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href={{ URL::asset('css/icons.min.css') }} rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href={{ URL::asset('css/app.min.css') }} id="app-stylesheet" rel="stylesheet" type="text/css" />
    {{-- titile --}}
    <title>@yield('title')</title>

</head>

<body>
    @guest
        <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
        <li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
    @endguest
    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->
        <div class="navbar-custom">
            <ul class="list-unstyled topnav-menu float-right mb-0">

                {{-- Notification --}}
                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle  waves-effect" data-toggle="dropdown" href="#" role="button"
                        aria-haspopup="false" aria-expanded="false">
                        <i class="fe-bell noti-icon"></i>
                        <span class="badge badge-danger rounded-circle noti-icon-badge"><?php if
                            (count(Auth::user()->unreadNotifications) == 0) {
                            echo 0;
                            } else {
                            echo count(Auth::user()->unreadNotifications);
                            } ?></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-lg">

                        <!-- item-->
                        <div class="dropdown-item noti-title">
                            <h5 class="m-0">
                                <span class="float-right">
                                    <a href="" class="text-dark">
                                        <small>Clear All</small>
                                    </a>
                                </span>Notification
                            </h5>
                        </div>

                        <div class="slimscroll noti-scroll">
                            @if (count(Auth::user()->unreadNotifications) == 0)
                                <!-- item-->
                                <p class="notify-details"></p>
                                <p class="text-muted mb-0 user-msg" style="text-align: center">
                                    Nothing
                                </p>

                            @else

                                @foreach (Auth::user()->notifications as $item)
                                    <!-- item-->
                                    @if ($item->read_at == null)
                                        <a href="/notifications" class="dropdown-item notify-item active">
                                            {{-- <div class="notify-icon">
                                        <img src='/images/users/{{$item}}'
                                            class="img-fluid rounded-circle" alt="no avata" />
                                    </div> --}}
                                            <p class="text-muted mb-0 user-msg"><b>From : {{ $item->data['title'] }}
                                                    -
                                                    {{ Carbon\Carbon::parse($item->created_at)->diffForHumans(Carbon\Carbon::now()) }}</b>
                                            </p>
                                            {{-- <p class="text-muted mb-0 user-msg">
                                        <small>Hi, How are you? What about our next meeting</small>
                                    </p> --}}
                                        </a>
                                    @endif
                                    {{-- <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item active">
                                <div class="notify-icon">
                                    <img src='/images/users/{{Auth::user()->avatar}}'
                                        class="img-fluid rounded-circle" alt="" />
                                </div>
                                <p class="notify-details">Cristina Pride</p>
                                <p class="text-muted mb-0 user-msg">
                                    <small>Hi, How are you? What about our next meeting</small>
                                </p>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <div class="notify-icon">
                                    <img src="/images/users/user-4.jpg" class="img-fluid rounded-circle" alt="" />
                                </div>
                                <p class="notify-details">Karen Robinson</p>
                                <p class="text-muted mb-0 user-msg">
                                    <small>Wow ! this admin looks good and awesome design</small>
                                </p>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <div class="notify-icon bg-warning">
                                    <i class="mdi mdi-account-plus"></i>
                                </div>
                                <p class="notify-details">New user registered.
                                    <small class="text-muted">5 hours ago</small>
                                </p>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <div class="notify-icon bg-info">
                                    <i class="mdi mdi-comment-account-outline"></i>
                                </div>
                                <p class="notify-details">Caleb Flakelar commented on Admin
                                    <small class="text-muted">4 days ago</small>
                                </p>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <div class="notify-icon bg-secondary">
                                    <i class="mdi mdi-heart"></i>
                                </div>
                                <p class="notify-details">Carlos Crouch liked
                                    <b>Admin</b>
                                    <small class="text-muted">13 days ago</small>
                                </p>
                            </a>
                        </div> --}}

                                    <!-- All-->
                                @endforeach
                                <a href="javascript:void(0);"
                                    class="dropdown-item text-center text-primary notify-item notify-all">
                                    View all
                                    <i class="fi-arrow-right"></i>
                                </a>
                            @endif
                        </div>
                </li>

                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect" data-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <img src='/images/users/{{ Auth::user()->avatar }}' alt="user-image" class="rounded-circle">
                        <span class="pro-user-name ml-1">
                            <i class="mdi mdi-chevron-down">{{ Auth::user()->name }}</i>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                        <!-- item-->
                        {{-- <div class="dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Welcome !</h6>
                        </div> --}}

                        <!-- item-->
                        <a href="/profile" class="dropdown-item notify-item">
                            <i class="fe-user"></i>
                            <span>My Account</span>
                        </a>

                        <!-- item-->
                        {{-- <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <i class="fe-settings"></i>
                            <span>Settings</span>
                        </a> --}}

                        <!-- item-->
                        {{-- <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <i class="fe-lock"></i>
                            <span>Lock Screen</span>
                        </a> --}}

                        <div class="dropdown-divider"></div>

                        <!-- item-->
                        <a href="{{ route('logout') }}" class="dropdown-item notify-item" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                            <i class="fe-log-out"></i>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                            <span>Logout</span>
                        </a>

                    </div>
                </li>

                <li class="dropdown notification-list">
                    <a href="javascript:void(0);" class="nav-link right-bar-toggle waves-effect">
                        <i class="fe-settings noti-icon"></i>
                    </a>
                </li>


            </ul>

            <!-- LOGO -->
            <div class="logo-box">
                <a href="/home" class="logo logo-dark text-center">
                    <span class="logo-lg">
                        <img src="/images/logo-cty-sm.png" alt="" height="38">
                    </span>
                </a>
            </div>

            <ul class="list-unstyled topnav-menu topnav-menu-left mb-0">
                <li>
                    <button class="button-menu-mobile disable-btn waves-effect">
                        <i class="fe-menu"></i>
                    </button>
                </li>

                <li>
                    <h4 class="page-title-main"></h4>
                </li>

            </ul>

        </div>
        <!-- end Topbar -->

        <!-- ========== Left Sidebar Start ========== -->
        <div class="left-side-menu">

            <div class="slimscroll-menu">

                <!-- User box -->
                <div class="user-box text-center">
                    <img src='/images/users/{{ Auth::user()->avatar }}' alt="user-img" title="Mat Helme"
                        class="rounded-circle img-thumbnail avatar-md">
                    <div class="dropdown">
                        <a href="#" class="user-name dropdown-toggle h5 mt-2 mb-1 d-block" data-toggle="dropdown"
                            aria-expanded="false">{{ Auth::user()->name }}</a>
                        <div class="dropdown-menu user-pro-dropdown">

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="fe-user mr-1"></i>
                                <span>My Account</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="fe-settings mr-1"></i>
                                <span>Settings</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="fe-lock mr-1"></i>
                                <span>Lock Screen</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="fe-log-out mr-1"></i>
                                <span>Logout</span>
                            </a>

                        </div>
                    </div>
                    <p class="text-muted">{{ Auth::user()->getRoleNames()[0] }}</p>
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <a href="#" class="text-muted">
                                <i class="mdi mdi-cog"></i>
                            </a>
                        </li>

                        <li class="list-inline-item">
                            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                                <i class="mdi mdi-power"></i>
                            </a>
                        </li>
                    </ul>
                </div>

                <!--- Sidemenu -->
                <div id="sidebar-menu">

                    <ul class="metismenu" id="side-menu">

                        <li class="menu-title">Navigation</li>

                        <li>
                            <a href="/">
                                <i class="mdi mdi-view-dashboard"></i>
                                <span> Dashboard </span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('notifications.index') }}">
                                <i class="mdi mdi-view-dashboard"></i>
                                <span> Notifications </span>
                            </a>
                        </li>

                        @can('user-create')
                            <li>
                                <a href="{{ route('users.index') }}">
                                    <i class="fas fa-user-alt"></i>
                                    <span> Users </span>
                                </a>
                            </li>
                        @endcan

                        @can('project-list')
                            <li>
                                <a href="{{ route('projects.index') }}">
                                    <i class="mdi mdi-forum"></i>
                                    <span> Project </span>
                                </a>
                            </li>
                        @endcan

                        @can('department-create')
                            <li>
                                <a href="{{ route('departments.index') }}">
                                    <i class="fas fa-id-card-alt"></i>
                                    {{-- <span class="badge badge-purple float-right">New</span> --}}
                                    <span> Department</span>
                                </a>
                            </li>
                        @endcan

                        @can('role-create')
                            <li>
                                <a href="{{ route('roles.index') }}">
                                    <i class="fab fa-critical-role"></i>
                                    {{-- <span class="badge badge-purple float-right">New</span> --}}
                                    <span> Role </span>
                                </a>
                            </li>
                        @endcan

                        @if (Auth::user()->getRoleNames()[0] == 'Admin')
                            <li>
                                <a href="/configurations">
                                    <i class="mdi mdi-forum"></i>
                                    <span> Configuration </span>
                                </a>
                            </li>
                        @endif

                        {{-- @can('product-create')
                        <li>
                            <a href="{{ route('products.index') }}">
                                <i class="mdi mdi-forum"></i>
                                <span> Manage Product </span>
                            </a>
                        </li>
                        @endcan --}}

                        <li class="menu-title">Apps</li>

                        <li>
                            <a href="calendar">
                                <i class="mdi mdi-calendar"></i>
                                <span> Calendar </span>
                            </a>
                        </li>

                        <li>
                            <a href="apps-chat">
                                <i class="mdi mdi-forum"></i>
                                {{-- <span class="badge badge-purple float-right">New</span> --}}
                                <span> Chat </span>
                            </a>
                        </li>

                        <li>
                            <a href="inbox">
                                <i class="mdi mdi-email"></i>
                                <span> Mail </span>
                            </a>
                        </li>
                    </ul>

                </div>
                <!-- End Sidebar -->

                <div class="clearfix"></div>

            </div>
            <!-- Sidebar -left -->

        </div>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                @yield('content')


            </div> <!-- content -->

            {{-- <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                           2016 - 2020 &copy; Adminto theme by <a href="">Coderthemes</a>
                        </div>
                        <div class="col-md-6">
                            <div class="text-md-right footer-links d-none d-sm-block">
                                <a href="javascript:void(0);">About Us</a>
                                <a href="javascript:void(0);">Help</a>
                                <a href="javascript:void(0);">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer --> --}}

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->

    <!-- Right Sidebar -->
    <div class="right-bar">
        <div class="rightbar-title">
            <a href="javascript:void(0);" class="right-bar-toggle float-right">
                <i class="mdi mdi-close"></i>
            </a>
            <h4 class="font-16 m-0 text-white">Theme Customizer</h4>
        </div>
        <div class="slimscroll-menu">

            <div class="p-3">
                <div class="alert alert-warning" role="alert">
                    <strong>Customize </strong> the overall color scheme, layout, etc.
                </div>
                <div class="mb-2">
                    <img src="/images/layouts/light.png" class="img-fluid img-thumbnail" alt="">
                </div>
                <div class="custom-control custom-switch mb-3">
                    <input type="checkbox" class="custom-control-input theme-choice" id="light-mode-switch" checked />
                    <label class="custom-control-label" for="light-mode-switch">Light Mode</label>
                </div>

                <div class="mb-2">
                    <img src="/images/layouts/dark.png" class="img-fluid img-thumbnail" alt="">
                </div>
                <div class="custom-control custom-switch mb-3">
                    <input type="checkbox" class="custom-control-input theme-choice" id="dark-mode-switch"
                        data-bsStyle="css/bootstrap-dark.min.css" data-appStyle="css/app-dark.min.css" />
                    <label class="custom-control-label" for="dark-mode-switch">Dark Mode</label>
                </div>

                <div class="mb-2">
                    <img src="/images/layouts/rtl.png" class="img-fluid img-thumbnail" alt="">
                </div>
                <div class="custom-control custom-switch mb-3">
                    <input type="checkbox" class="custom-control-input theme-choice" id="rtl-mode-switch"
                        data-appStyle="css/app-rtl.min.css" />
                    <label class="custom-control-label" for="rtl-mode-switch">RTL Mode</label>
                </div>

                <div class="mb-2">
                    <img src="/images/layouts/dark-rtl.png" class="img-fluid img-thumbnail" alt="">
                </div>
                <div class="custom-control custom-switch mb-5">
                    <input type="checkbox" class="custom-control-input theme-choice" id="dark-rtl-mode-switch"
                        data-bsStyle="css/bootstrap-dark.min.css" data-appStyle="css/app-dark-rtl.min.css" />
                    <label class="custom-control-label" for="dark-rtl-mode-switch">Dark RTL Mode</label>
                </div>

                <a href="https://1.envato.market/k0YEM" class="btn btn-danger btn-block mt-3" target="_blank"><i
                        class="mdi mdi-download mr-1"></i> Download Now</a>
            </div>
        </div> <!-- end slimscroll-menu-->
    </div>
    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <a href="javascript:void(0);" class="right-bar-toggle demos-show-btn">
        <i class="mdi mdi-cog-outline mdi-spin"></i> &nbsp;Choose Demos
    </a>

    <!-- Vendor js -->
    <script src={{ URL::asset('js/vendor.min.js') }}></script>
    <!-- App js -->
    <script src={{ URL::asset('js/app.min.js') }}></script>


    {{-- Thêm file phụ --}}

    <!-- knob plugin -->
    <script src={{ URL::asset('libs/jquery-knob/jquery.knob.min.js') }}></script>



    <!-- Plugins js -->
    <script src={{ URL::asset('libs/katex/katex.min.js') }}></script>
    <script src={{ URL::asset('libs/quill/quill.min.js') }}></script>

    <!-- Modal-Effect -->
    <script src={{ URL::asset('libs/custombox/custombox.min.js') }}></script>
    <script src={{ URL::asset('js/pages/inbox.init.js') }}></script>

    <!-- Tablesaw js & Init js -->
    <script src={{ URL::asset('libs/tablesaw/tablesaw.js') }}></script>
    <script src={{ URL::asset('js/pages/tablesaw.init.js') }}></script>

    @yield('js')
</body>

</html>
