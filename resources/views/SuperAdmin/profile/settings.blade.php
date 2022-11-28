@extends('Layouts.SuperAdmin.master')

@push('title')
Super Admin
@endpush
@push('datatableCSS')
<!-- DataTables -->
<link href="{{ asset('assets/super-admin/plugins/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/super-admin/plugins/datatables/buttons.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/super-admin/plugins/datatables/fixedHeader.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/super-admin/plugins/datatables/responsive.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/super-admin/plugins/datatables/dataTables.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/super-admin/plugins/datatables/scroller.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endpush
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Admin Settings</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Settings</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<style>
    td,
    th {
        text-align: center;
    }
</style>

<div class="content">

    <div class="container-fluid">


        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Settings</h3>

            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6" style=" border: 1px solid gold; padding: 10px; border-radius: 5px;">
                        <form action="{{ route('superAdmin.change.profile') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="panel panel-primary">
                                <div style="text-align: center;">
                                    <div style="position:relative;width: 150px;height:150px; display:inline-block;">
                                        <img src="{{$user->image ? asset($user->image) : asset('demo_image/demo_user.png')}}" id="show-image" class="rounded-circle" style="width: 150px;height:150px; border: 1px solid gold;" alt="Avatar" />

                                        <label for="customFile" class="btn btn-warning" style="border-radius:50%; position:absolute; top:90%; left:65%; transform: translate(-90%, -50%);"><i class="fa fa-camera" aria-hidden="true"></i></label>
                                        <input type="file"  name="image" style="display:none;" id="customFile" onChange="PreviewImage(this)"/>
                                    </div>
                                </div>

                                <div class="panel-heading">
                                    <h3 class="panel-title  text-white">My Profile</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="container">
                                            <div class="col">

                                                <div class="form-group">
                                                    <label for="first_name">First Name</label>
                                                    <input type="text" name="first_name" class="form-control" id="first_name" value="{{ $user->first_name }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="last_name">Last Name</label>
                                                    <input type="text" name="last_name" class="form-control" id="last_name" value="{{ $user->last_name }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="email">Email Address</label>
                                                    <input type="text" name="email" class="form-control" id="email" value="{{ $user->email }}" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label for="phone">Phone No</label>
                                                    <input type="text" name="phone" class="form-control" id="phone" value="{{ $user->phone }}" disabled>
                                                </div>
                                                <div class="panel-footer">
                                                    <div class=" text-right">
                                                        <button type="submit" class="btn btn-warning waves-effect waves-ligh">Submit</button>
                                                    </div>
                        </form>

                        <form action="{{ route('superAdmin.change.password') }}" method="POST">
                            @csrf

                            <hr style="border: 1px solid gold;">
                            <h4 class="panel-title  text-white">Change Password</h4>

                            @include('Others.message')
                            <hr>
                            <div class="form-group">
                                <label for="oldPassword">Current Password</label>
                                <input type="password" name="oldPassword" class="form-control" id="oldPassword">
                                <i  class="bi bi-eye-slash field-icon" id="togglePasswordOld"></i>

                            </div>
                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input type="password" name="password" class="form-control passwordIcon" id="passwordNew" />
                                <i  class="bi bi-eye-slash field-icon" id="togglePasswordNew"></i>

                            </div>
                            <div class="form-group">
                                <label for="confirmPassword">Confirm Password</label>
                                <input type="password" name="confirmPassword" class="form-control passwordIcon" id="confirmPassword">
                                <i  class="bi bi-eye-slash field-icon" id="togglePasswordConfirm" ></i>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <div class=" text-right">
                <button type="submit" class="btn btn-warning  waves-effect waves-ligh">Submit</button>
            </div>
        </div>
    </div>
    </form>
</div>
</div>
</div>
</div>


</div>
</div>

<script>
    function activeNow(objButton) {
        var url = objButton.value;
        // alert(objButton.value)
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Active !'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    method: 'POST',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        if (data.type == 'success') {
                            Swal.fire(
                                'Activated !',
                                'This account has been Activated. ' + data.message,
                                'success'
                            )
                            setTimeout(function() {
                                location.reload();
                            }, 800);
                        } else {
                            Swal.fire(
                                'Wrong !',
                                'Something going wrong. ' + data.message,
                                'warning'
                            )
                        }
                    },
                })
            }
        })
    }

    function inactiveNow(objButton) {
        var url = objButton.value;
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Inactive !'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    method: 'POST',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        if (data.type == 'success') {
                            Swal.fire(
                                'Inactivated !',
                                'This account has been Inactivated. ' + data.message,
                                'success'
                            )
                            setTimeout(function() {
                                location.reload();
                            }, 800);
                        } else {
                            Swal.fire(
                                'Wrong !',
                                'Something going wrong. ' + data.message,
                                'warning'
                            )
                        }
                    },
                })
            }
        })
    }
</script>
<style>
    .field-icon {
      float: right;
      margin-right: 30px !important;
      margin-top: -30px !important;
      position: relative; */
    }

    /* .eyeIcon{
        margin-left: 100px !important;

    } */
    </style>
<script>
    const OldtogglePassword = document.querySelector("#togglePasswordOld");
    const Oldpassword = document.querySelector("#oldPassword");

    const NewtogglePassword = document.querySelector("#togglePasswordNew");
    const password = document.querySelector("#passwordNew");

    const ConfirmtogglePassword = document.querySelector("#togglePasswordConfirm");
    const Confirmpassword = document.querySelector("#confirmPassword");

    OldtogglePassword.addEventListener("click", function () {
        // toggle the type attribute
        const type = Oldpassword.getAttribute("type") === "password" ? "text" : "password";
        Oldpassword.setAttribute("type", type);

        // toggle the icon
        this.classList.toggle("bi-eye");
    });
    NewtogglePassword.addEventListener("click", function () {
        // toggle the type attribute
        const type = password.getAttribute("type") === "password" ? "text" : "password";
        password.setAttribute("type", type);

        // toggle the icon
        this.classList.toggle("bi-eye");
    });
    ConfirmtogglePassword.addEventListener("click", function () {
        // toggle the type attribute
        const type = Confirmpassword.getAttribute("type") === "password" ? "text" : "password";
        Confirmpassword.setAttribute("type", type);

        // toggle the icon
        this.classList.toggle("bi-eye");
    });

    // prevent form submit
</script>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
<link rel="stylesheet" href="css/style.css" />



@endsection
