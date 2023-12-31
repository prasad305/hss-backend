@extends('Layouts.SuperAdmin.master')

@push('title')
    Super Admin
@endpush
@push('datatableCSS')
    <!-- DataTables -->
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
@endpush
@section('content')
    <style>
        .head-line {
            border-top: 1px solid #ffad00 !important;
            border-left: 8px solid #ffad00 !important;
            border-bottom: 1px solid #ffad00 !important;
            border-right: 8px solid #ffad00 !important;
        }

        .card-bg {
            background-color: black;
        }
    </style>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="card card-bg head-line mt-4 mb-2">
                <div class="text-light d-flex p-2">
                    <h4 class="mx-3 text-white p-2">Super Star</h4>
                </div>
            </div>

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
                    <h3 class="card-title">Admin List</h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Name</th>
                                <th>Photo</th>
                                <th>Phone</th>
                                <th>Active Status</th>
                                <th>Approve Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admins as $admin)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $admin->first_name . ' ' . $admin->last_name }}</td>
                                    <td>
                                        @if ($admin->image)
                                            <a href="{{ asset($admin->image) }}" target="_blank">
                                                <img height="70px;" src="{{ asset($admin->image) }}" width="70px;"
                                                    class="rounded-circle" />
                                            </a>
                                        @else
                                            <a href="{{ asset('demo_image/demo_user.png') }}" target="_blank">
                                                <img height="70px;" src="{{ asset('demo_image/demo_user.png') }}" width="70px;"
                                                    class="rounded-circle" />
                                            </a>
                                        @endif
                                    </td>
                                    <td>{{ $admin->phone }}</td>

                                    <td>
                                        @if ($admin->active_status == 0)
                                            <span class="badge badge-danger">Unactive</span>
                                        @elseif($admin->active_status == 1)
                                            <span class="badge badge-success">Active</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($admin->status == 0)
                                            <span class="badge badge-danger">Pending</span>
                                        @elseif($admin->status == 1)
                                            <span class="badge badge-success">Approved</span>
                                        @endif
                                    </td>
                                    <td style="width: 150px">
                                        @if ($admin->status == 0)
                                            <button class="btn btn-success" onclick="activeNow(this)"
                                                value="{{ route('superAdmin.star.activeNow', $admin->id) }}">
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                            </button>
                                        @elseif($admin->status == 1)
                                            <button class="btn btn-danger" onclick="inactiveNow(this)"
                                                value="{{ route('superAdmin.star.inactiveNow', $admin->id) }}">
                                                <i class="fa fa-close"></i>
                                            </button>
                                        @endif
                                        {{-- <a class="btn btn btn-info" onclick="Show('Edit Star','{{ route('superAdmin.star.edit', $admin->id) }}')"><i class="fa fa-edit text-white"></i></a> --}}
                                        <button class="btn btn-danger" onclick="delete_function(this)"
                                            value="{{ route('superAdmin.star.destroy', $admin->id) }}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Sl</th>
                                <th>Name</th>
                                <th>Photo</th>
                                <th>Phone</th>
                                <th>Active Status</th>
                                <th>Approve Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
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
