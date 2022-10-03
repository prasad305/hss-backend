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
                                    <img src="{{asset('storage/'.$user->image)}}" class="rounded-circle" style="width: 150px;height:150px; border: 1px solid gold;" alt="Avatar" /><br>
                                    <input type="file" name="image" style="text-align: center;padding-left:70px;" id="customFile" />
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
                            </div>
                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input type="password" name="password" class="form-control" id="password">
                            </div>
                            <div class="form-group">
                                <label for="confirmPassword">Confirm Password</label>
                                <input type="password" name="confirmPassword" class="form-control" id="confirmPassword">
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





@endsection
