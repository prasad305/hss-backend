<!DOCTYPE html>
<html>

<head>
    @include('SuperAdmin.layouts.includes.head')
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
        @include('SuperAdmin.layouts.includes.topbar')
        <!-- Top Bar End -->
        <!-- ========== Left Sidebar Start ========== -->

        @include('SuperAdmin.layouts.includes.navbar')
        <!-- Left Sidebar End -->

        <!-- Start right Content here -->

        <div class="content-page">
            <!-- Start content -->
            @yield('content')
            @include('Others.modal')
            @include('SuperAdmin.layouts.includes.footer')
        </div>
        <!-- End Right content here -->
    </div>
    <!-- END wrapper -->
    {{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
@include('sweetalert::alert') --}}
    <!-- jQuery  -->
    @if(session()->has('success'))
    {{-- <script type="text/javascript">
      $(document).ready(function() {
        // notify('{{session()->get('success')}}','success');
        Swal.fire({
            position: 'top-end',
            icon: success,
            title: 'Data Updated Successfully',
            showConfirmButton: false,
            timer: 1500
        })
        // alert('Success');
      });
    </script> --}}
    <script>
        // alert('Hello MOnir');
        sweet('hello bangladesh');
    </script>
    @endif

    @if(session()->has('danger'))
    <script type="text/javascript">
      $(document).ready(function() {
        // notify('{{session()->get('danger')}}','danger');
        Swal.fire({
            position: 'top-end',
            icon: danger,
            title: 'Something went wrong',
            showConfirmButton: false,
            timer: 1500
        })
      });
    </script>
    @endif

    @if($errors->any())
        <script type="text/javascript">
          $(document).ready(function() {
            var errors=<?php echo json_encode($errors->all()); ?>;
            $.each(errors, function(index, val) {
               notify(val,'danger');
            });
          });
        </script>
    @endif
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
    @include('SuperAdmin.layouts.includes.foot')
</body>

</html>
