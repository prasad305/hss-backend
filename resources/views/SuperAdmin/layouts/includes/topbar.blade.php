<div class="topbar">
    <!-- LOGO -->
    <div class="topbar-left">
        <div class="text-center">
            <a href="{{ route('superAdmin.dashboard') }}" class="logo"><img src="{{ asset('assets/super-admin/images/super-admin-1.png') }}" style="width: 100%; height: 55px;" height="28"></a>
            {{-- <a href="{{ route('superAdmin.dashboard') }}" class="logo"><img src="{{ asset('assets/super-admin/images/super-admin-2.png') }}" style="width: 100%; height: 55px;" height="28"></a> --}}
            <a href="{{ route('superAdmin.dashboard') }}" class="logo-sm"><img src="{{ asset('assets/super-admin/images/logo_sm.png') }}" height="36"></a>
        </div>
    </div>
    <!-- Button mobile view to collapse sidebar menu -->
    <div class="navbar navbar-default" role="navigation">
        <div class="container">
            <div class="">
                <div class="pull-left">
                    <button type="button" class="button-menu-mobile open-left waves-effect waves-light">
                        <i class="ion-navicon"></i>
                    </button>
                    <span class="clearfix"></span>
                </div>
                <form class="navbar-form pull-left" role="search">
                    <div class="form-group">
                        <input type="text" class="form-control search-bar" placeholder="Search...">
                    </div>
                    <button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
                </form>

                <ul class="nav navbar-nav navbar-right pull-right">
                    <li class="dropdown hidden-xs">
                        <a href="#" data-target="#" class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">
                            <i class="fa fa-bell"></i> <span class="badge badge-xs badge-danger">3</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg">
                            <li class="text-center notifi-title">Notification <span class="badge badge-xs badge-success">3</span></li>
                            <li class="list-group">
                                <!-- list item-->
                                <a href="javascript:void(0);" class="list-group-item">
                                    <div class="media">
                                        <div class="media-heading">Your order is placed</div>
                                        <p class="m-0">
                                            <small>Dummy text of the printing and typesetting industry.</small>
                                        </p>
                                    </div>
                                </a>
                                <!-- list item-->
                                <a href="javascript:void(0);" class="list-group-item">
                                    <div class="media">
                                        <div class="media-body clearfix">
                                            <div class="media-heading">New Message received</div>
                                            <p class="m-0">
                                                <small>You have 87 unread messages</small>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                                <!-- list item-->
                                <a href="javascript:void(0);" class="list-group-item">
                                    <div class="media">
                                        <div class="media-body clearfix">
                                            <div class="media-heading">Your item is shipped.</div>
                                            <p class="m-0">
                                                <small>It is a long established fact that a reader will</small>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                                <!-- last list item -->
                                <a href="javascript:void(0);" class="list-group-item">
                                    <small class="text-primary">See all notifications</small>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="hidden-xs">
                        <a href="#" id="btn-fullscreen" class="waves-effect waves-light"><i class="fa fa-crosshairs"></i></a>
                    </li>


                    <li class="nav-item dropdown user-menu">
                        <a href="" class="nav-link dropdown-toggle" data-toggle="dropdown">
                            <img src="{{asset( Auth::user()->image ?? get_static_option('no_image'))}}" class="user-image img-circle " alt="User Image">
                            <span class="d-none d-md-inline"> {{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <!-- User image -->
                            <li class="user-header ">
                                <img src="{{asset( Auth::user()->logo ?? get_static_option('no_image'))}}" class="img-circle " alt="User Image">
                                <p>
                                    {{ Auth::user()->name }}
                                </p>
                                <center><small>{{ Auth::user()->email }}</small></center>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="left">
                                    <a href="{{ route('superAdmin.profile') }}">
                                        <img src="https://img.icons8.com/external-kiranshastry-lineal-color-kiranshastry/64/000000/external-user-management-kiranshastry-lineal-color-kiranshastry-10.png" />
                                    </a>
                                </div>
                                <div class="right">
                                    <div class="log logout-btn">
                                        <a class="dropdown-item">
                                            <img src="https://img.icons8.com/fluency/48/000000/sign-in-form-password.png" alt="user-img" class="img-circle img-fluid text-center" />
                                        </a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </div>
</div>
