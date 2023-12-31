@extends('Layouts.SuperAdmin.master')

@push('title')
    Super Admin
@endpush

@section('content')
    <!-- Content Header (Page header) -->

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

    <div class="content-header">
        <div class="container-fluid">
            <div class="card card-bg head-line mt-4 mb-2">
                <div class="text-light d-flex p-2">
                    <h4 class="mx-3 text-white p-2">Admin List</h4>
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
                    <h3 class="card-title">List</h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Category</th>
                                <th>Sub Category</th>
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
                                    <td>{{ $admin->category ? $admin->category->name : '' }}</td>
                                    <td>{{ $admin->subCategory ? $admin->subCategory->name : '' }}</td>
                                    <td>{{ $admin->first_name . ' ' . $admin->last_name }}</td>
                                    <td>
                                        @if ($admin->image)
                                            <a href="{{ asset($admin->image) }}" target="_blank">
                                                <img height="70px;" src="{{ asset($admin->image) }}" width="70px;"
                                                    class="rounded-circle" />
                                            </a>
                                        @else
                                            <a href="{{ asset('demo_image/demo_user.png') }}" target="_blank">
                                                <img height="70px;" src="{{ asset('demo_image/demo_user.png') }}"
                                                    width="70px;" class="rounded-circle" />
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
                                            <span class="badge badge-danger">Unapproved</span>
                                        @elseif($admin->status == 1)
                                            <span class="badge badge-success">Approved</span>
                                        @endif
                                    </td>
                                    <td style="width: 150px">
                                        @if ($admin->status == 0)
                                            <button class="btn btn-success" onclick="activeNow(this)"
                                                value="{{ route('superAdmin.admin.activeNow', $admin->id) }}">
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                            </button>
                                        @elseif($admin->status == 1)
                                            <button class="btn btn-danger" onclick="inactiveNow(this)"
                                                value="{{ route('superAdmin.admin.inactiveNow', $admin->id) }}">
                                                <i class="fa fa-close"></i>
                                            </button>
                                        @endif
                                        <a class="btn btn btn-info"
                                            onclick="Show('Edit Admin','{{ route('superAdmin.admin.edit', $admin->id) }}')"><i
                                                class="fa fa-edit text-white"></i></a>
                                        <button class="btn btn-danger" onclick="delete_function(this)"
                                            value="{{ route('superAdmin.admin.destroy', $admin->id) }}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Sub Category</th>
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
