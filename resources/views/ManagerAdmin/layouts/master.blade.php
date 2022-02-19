<!DOCTYPE html>
<html>

<head>
    @include('ManagerAdmin.layouts.includes.head')
</head>


<body class="fixed-left">
    @if(Auth::check())
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    @endif

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Top Bar Start -->
        @include('ManagerAdmin.layouts.includes.topbar')
        <!-- Top Bar End -->
        <!-- ========== Left Sidebar Start ========== -->

        @include('ManagerAdmin.layouts.includes.navbar')
        <!-- Left Sidebar End -->

        <!-- Start right Content here -->

        <div class="content-page">
            <!-- Start content -->
            @yield('content')
            @include('Others.modal')
            @include('ManagerAdmin.layouts.includes.footer')
        </div>
        <!-- End Right content here -->
    </div>
    <!-- END wrapper -->
    <!-- jQuery  -->
    @include('ManagerAdmin.layouts.includes.foot')

    <script>

        function Show(title,link,style = '') {

            // alert();
            $('#modal').modal();
            $('#modal-title').html(title);
            $('#modal-body').html('<h1 class="text-center"><strong>Please Wait...</strong></h1>');
            $('#modal-dialog').attr('style',style);
            $.ajax({
                url: link,
                type: 'GET',
                data: {},
            })
            .done(function(response) {
                $('#modal-body').html(response);
            });
        }

        
        function sweet(message){
            Swal.fire({
                        icon: 'error',
                        title: message,
                         footer: ''
                    });
        }

    </script>
</body>

</html>
