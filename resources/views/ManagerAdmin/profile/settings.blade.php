@extends('Layouts.ManagerAdmin.master')

@push('title')
    Manager Admin
@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Settings</h1>
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



    <div class="content">
        <div class="container-fluid">


            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6" style=" border: 1px solid gold; padding: 10px; border-radius: 5px;">
                    <form action="{{ route('managerAdmin.change.password') }}" method="POST">
                        @csrf
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title  text-white">My Profile Test</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="container">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="first_name">First Name</label>
                                                <input type="text" name="first_name" class="form-control" id="first_name"
                                                    value="{{ $user->first_name }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="last_name">Last Name</label>
                                                <input type="text" name="last_name" class="form-control" id="last_name"
                                                    value="{{ $user->last_name }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email Address</label>
                                                <input type="text" name="email" class="form-control" id="email"
                                                    value="{{ $user->email }}" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="phone">Phone No</label>
                                                <input type="text" name="phone" class="form-control" id="phone"
                                                    value="{{ $user->phone }}" disabled>
                                            </div>
                                            <hr>
                                            <h4 class="panel-title  text-white">Change Password</h4>

                                            @include('Others.message')
                                            <hr>
                                            <div class="form-group">
                                                <label for="oldPassword">Current Password</label>
                                                <input type="password" name="oldPassword" class="form-control"
                                                    id="oldPassword">
                                            </div>
                                            <div class="form-group">
                                                <label for="password">New Password</label>
                                                <input type="password" name="password" class="form-control" id="password">
                                            </div>
                                            <div class="form-group">
                                                <label for="confirmPassword">Confirm Password</label>
                                                <input type="password" name="confirmPassword" class="form-control"
                                                    id="confirmPassword">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <div class=" text-right">
                                    <button type="submit" class="btn btn-dark waves-effect waves-ligh">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


        </div> <!-- container -->
    </div> <!-- content -->
    @if (session()->has('success'))
        <script type="text/javascript">
            $(document).ready(function() {
                // notify('{{ session()->get('success') }}','success');
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: '{{ Session::get('
                                success ') }}',
                    showConfirmButton: false,
                    timer: 1500
                })
            });
        </script>
    @endif
@endsection

@push('script')
    {{-- <script src="{{ asset('assets/manager-admin/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script> --}}
    <script src="{{ asset('assets/manager-admin/pages/dashborad.js') }}"></script>
@endpush
