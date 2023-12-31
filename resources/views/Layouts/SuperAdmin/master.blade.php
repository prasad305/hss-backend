<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hello Super Star | Dashboard </title>


    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('assets/super-admin/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet"
        href="{{ asset('assets/super-admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/super-admin/dist/css/adminlte.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet"
        href="{{ asset('assets/super-admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet"
        href="{{ asset('assets/super-admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/super-admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/super-admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Custom style -->
    <link rel="stylesheet" href="{{ asset('assets/custom-style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/super-admin/Events.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/manager-admin/plugins/summernote/summernote-bs4.min.css') }}">


    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

    {{-- Datatable CSS --}}
    <link href="{{ asset('assets/super-admin/plugins/datatables/jquery.dataTables.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/super-admin/plugins/datatables/buttons.bootstrap.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/super-admin/plugins/datatables/fixedHeader.bootstrap.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/super-admin/plugins/datatables/responsive.bootstrap.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/super-admin/plugins/datatables/dataTables.bootstrap.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/super-admin/plugins/datatables/scroller.bootstrap.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/new-main.css') }}" rel="stylesheet" type="text/css" />
    @stack('datatableCSS')
    @stack('css')


</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__wobble" src="{{ asset('assets/super-admin/dist/img/helloSuperStar.png') }}"
                alt="AdminLTELogo" height="160" width="160">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="index3.html" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                    aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

                <li class="nav-item">
                    <div class="btn-group">
                        <button type="button" class="btn btn-info">{{ Auth::user()->first_name }}</button>
                        <button type="button" class="btn btn-info dropdown-toggle dropdown-icon"
                            data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu" role="menu">
                            <a class="dropdown-item" href="{{ route('superAdmin.settings') }}">Settings</a>
                            {{-- <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a> --}}
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item logout-btn">Logout</a>
                        </div>

                        @if (Auth::check())
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        @endif
                    </div>
                </li>




                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-comments"></i>
                        <span class="badge badge-danger navbar-badge">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="{{ asset('assets/super-admin/dist/img/user1-128x128.jpg') }}"
                                    alt="User Avatar" class="img-size-50 mr-3 img-circle">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Brad Diesel
                                        <span class="float-right text-sm text-danger"><i
                                                class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">Call me whenever you can...</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="{{ asset('assets/super-admin/dist/img/user8-128x128.jpg') }}"
                                    alt="User Avatar" class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        John Pierce
                                        <span class="float-right text-sm text-muted"><i
                                                class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">I got your message bro</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="{{ asset('assets/super-admin/dist/img/user3-128x128.jpg') }}"
                                    alt="User Avatar" class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Nora Silvester
                                        <span class="float-right text-sm text-warning"><i
                                                class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">The subject goes here</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                    </div>
                </li>
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">15</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"
                        role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('managerAdmin.dashboard') }}" class="brand-link">
                <img src="{{ asset('assets/super-admin/dist/img/helloSuperStar.png') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Hello Super Star</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ Auth::user()->image ? asset(Auth::user()->image) : asset('demo_image/demo_user.png') }}"
                            style="width: 50px;height:50px; border: 1px solid gold;" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href="{{ route('managerAdmin.dashboard') }}"
                            class="d-block">{{ Auth::user()->first_name }}</a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                @include('Layouts.SuperAdmin.sidebar')

            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->


        <div class="content-wrapper">



            @yield('content')

            @include('Others.modal')



        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; {{ '2021' . '-' . date('Y') }} <a href="hellosuperstars.com">Hello Super
                    Stars</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b>0.3.0
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="{{ asset('assets/super-admin/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('assets/super-admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('assets/super-admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/super-admin/dist/js/adminlte.js') }}"></script>

    <!-- PAGE PLUGINS -->
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('assets/super-admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/super-admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/super-admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/super-admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/super-admin/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/super-admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/super-admin/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/super-admin/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/super-admin/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/super-admin/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/super-admin/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/super-admin/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- AdminLTE App -->

    <!-- jQuery Mapael -->
    <script src="{{ asset('assets/super-admin/plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
    <script src="{{ asset('assets/super-admin/plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('assets/super-admin/plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
    <script src="{{ asset('assets/super-admin/plugins/jquery-mapael/maps/usa_states.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('assets/super-admin/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('assets/super-admin/plugins/chart.js/Chart.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('assets/super-admin/dist/js/demo.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('assets/super-admin/dist/js/pages/dashboard2.js') }}"></script>

    <script src="{{ asset('assets/helper.js') }}"></script>

    <script src="{{ asset('assets/super-admin/Events.js') }}"></script>

    <!-- Summernote -->
    <script src="{{ asset('assets/manager-admin/plugins/summernote/summernote-bs4.min.js') }}"></script>
    @stack('js')

    <script>
        function PreviewImage(event){
            let file = URL.createObjectURL(event.files[0]);
            document.getElementById('show-image').src = file;
        }
    </script>

    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>




    <script>
        function Show(title, link, style = '') {
            $('#modal').modal();
            $('#modal-title').html(title);
            $('#modal-body').html('<h1 class="text-center"><strong>Please Wait...</strong></h1>');
            $('#modal-dialog').attr('style', style);
            $.ajax({
                    url: link,
                    type: 'GET',
                    data: {},
                })
                .done(function(response) {
                    $('#modal-body').html(response);
                });

        }




        function sweet(message) {
            Swal.fire({
                icon: 'error',
                title: message,
                footer: ''
            });
        }

        function ErrorMessage(key, value) {
            if (key == 'category_id') {
                $('#category_error').html(value);
            }
            if (key == 'sub_category_id') {
                $('#sub_category_error').html(value);
            }
            if (key == 'first_name') {
                $('#first_name_error').html(value);
            }
            if (key == 'last_name') {
                $('#last_name_error').html(value);
            }
            if (key == 'email') {
                $('#email_error').html(value);
            }
            if (key == 'phone') {
                $('#phone_error').html(value);
            }
            if (key == 'image') {
                $('#image_error').html(value);
            }
            if (key == 'cover') {
                $('#cover_error').html(value);
            }

            if (key == 'dob') {
                $('#dob_error').html(value);
            }
            if (key == 'terms_and_condition') {
                $('#terms_error').html(value);
            }
            if (key == 'star_id') {
                $('#star_error').html(value);
            }
            if (key == 'reminder_date') {
                $('#reminder_error').html(value);
            }
            if (key == 'acquired_instruction') {
                $('#acquired_instruction_error').html(value);
            }
            if (key == 'title') {
                $('#title_error').html(value);
            }
            if (key == 'description') {
                $('#description_error').html(value);
            }
            if (key == 'instruction') {
                $('#instruction_error').html(value);
            }
            if (key == 'group_name') {
                $('#group_name_error').html(value);
            }
            if (key == 'reminder_date') {
                $('#reminder_error').html(value);
            }
            if (key == 'acquired_instruction') {
                $('#acquired_instruction_error').html(value);
            }
            if (key == 'jury_or_judge') {
                $('#jury_or_judge_error').html(value);
            }
            if (key == 'jury_or_judge_mark') {
                $('#jury_or_judge_mark_error').html(value);
            }
            if (key == 'mark_live_or_offline') {
                $('#mark_live_or_offline_error').html(value);
            }
            if (key == 'appeal') {
                $('#appeal_error').html(value);
            }
            if (key == 'wildcard') {
                $('#wildcard_error').html(value);
            }
            if (key == 'video_feed') {
                $('#video_feed_error').html(value);
            }
            if (key == 'name') {
                $('#name_error').html(value);
            }
            if (key == 'event_period') {
                $('#event_preiod_error').html(value);
            }
            if (key == 'registration_period') {
                $('#registration_preiod_error').html(value);
            }
            if (key == 'round_type') {
                $('#round_type_error').html(value);
            }

        }


        function ErrorMessageClear() {
            $('#sub_category_error').html('');
            $('#first_name_error').html('');
            $('#last_name_error').html('');
            $('#email_error').html('');
            $('#phone_error').html('');
            $('#image_error').html('');
            $('#cover_error').html('');
            $('#dob_error').html('');
            $('#terms_error').html('');
            $('#category_error').html('');
            $('#star_error').html('');
            $('#reminder_error').html('');
            $('#acquired_instruction_error').html('');
            $('#title_error').html('');
            $('#description_error').html('');
            $('#instruction_error').html('');
            $('#group_name_error').html('');
            $('#jury_or_judge_error').html('');
            $('#appeal_error').html('');
            $('#jury_or_judge_mark_error').html('');
            $('#mark_live_or_offline_error').html('');
            $('#wild_card_error').html('');
            $('#video_feed_error').html('');
            $('#name_error').html('');
            $('#event_period').html('');
            $('#registration_period').html('');
            $('#round_type_error').html('');
        }
    </script>

</body>

</html>
