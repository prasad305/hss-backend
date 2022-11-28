@extends('Layouts.ManagerAdmin.master')

@push('title')
    Admin
@endpush


@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> Admin</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"> Admin List</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-header">
                        {{-- <h3 class="card-title">DataTable with default features</h3> --}}
                        <a class="btn btn-success btn-sm" style="float: right;"
                            onclick="Show('New Admin','{{ route('managerAdmin.admin.create') }}')"><i
                                class=" fa fa-plus"></i>&nbsp;New Admin</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SL.</th>
                                <th>SubCategory</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Image</th>
                                <th>Profit Share(%)</th>
                                <th>Approve Status</th>
                                <th>Active Status</th>
                                <th style="width: 150px">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($admins as $admin)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $admin->subCategory ? $admin->subCategory->name : '' }}</td>
                                    <td>{{ $admin->first_name . ' ' . $admin->last_name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>{{ $admin->phone }}</td>
                                    <td>
                                        @if ($admin->image)
                                            <img src="{{ asset($admin->image) }}" alt="" height="50px"
                                                width="50px">
                                        @else
                                            <a href="{{ asset('demo_image/demo_user.png') }}" target="_blank">
                                                <img height="70px;" src="{{ asset('demo_image/demo_user.png') }}"
                                                    width="70px;" class="rounded-circle" />
                                            </a>
                                        @endif
                                    </td>
                                    <td>{{ $admin->profitShare ? $admin->profitShare->profit : 00 }}</td>
                                    <td>
                                        @if ($admin->status == 0)
                                            <span class="badge badge-danger">Pending</span>
                                        @endif
                                        @if ($admin->status == 1)
                                            <span class="badge badge-success">Approved</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($admin->active_status == 0)
                                            <span class="badge badge-danger">InActive</span>
                                        @endif
                                        @if ($admin->active_status == 1)
                                            <span class="badge badge-success">Active</span>
                                        @endif
                                    </td>

                                    <td style="width: 150px">
                                        @if ($admin->active_status == 0)
                                            <button class="btn btn-sm btn-success" onclick="activeNow(this)"
                                                value="{{ route('managerAdmin.admin.activeNow', $admin->id) }}">
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                            </button>
                                        @elseif($admin->active_status == 1)
                                            <button class="btn btn-sm btn-danger" onclick="inactiveNow(this)"
                                                value="{{ route('managerAdmin.admin.inactiveNow', $admin->id) }}">
                                                <i class="fa fa-close"></i>
                                            </button>
                                        @endif
                                        <a class="btn btn-sm btn-info"
                                            onclick="Show('Edit Audition Admin','{{ route('managerAdmin.admin.edit', $admin->id) }}')"><i
                                                class="fa fa-edit text-white"></i>
                                        </a>
                                        <button class="btn btn-sm btn-danger" onclick="delete_function(this)"
                                            value="{{ route('managerAdmin.admin.destroy', $admin) }}"><i
                                                class="fa fa-trash"></i>
                                        </button>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div> <!-- container -->
    </div> <!-- content -->

    <style>
        .AdminImg {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;

        }

        .AdminName {
            color: black;
            font-size: 1rem;
        }

        .AdminMusic {
            color: #638BC9 !important:
        }

        .AtifAdmin {
            color: #FF602E;
        }


        @media only screen and (min-width: 1100px) and (max-width: 1400px) {

            .AdminName {
                white-space: nowrap;
                width: 8vw;
                overflow: hidden;
            }
        }
    </style>

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
            // alert(objButton.value)
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
