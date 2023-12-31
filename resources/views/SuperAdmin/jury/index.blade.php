@extends('Layouts.SuperAdmin.master')

@push('title')
    Super Admin | Jury Board
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
                    <h4 class="mx-3 text-white p-2">Jury</h4>
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

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>First name</th>
                                <th>Last name</th>
                                <th>Photo</th>
                                <th>Phone</th>
                                <th>Active Status</th>
                                <th>Approve Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($juries as $jury)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $jury->first_name }}</td>
                                    <td>{{ $jury->last_name }}</td>

                                    <td>
                                            @if($jury->image)
                                                <a href="{{ asset($jury->image) }}" target="_blank">
                                                    <img height="70px;" src="{{ asset($jury->image) }}" width="70px;" class="rounded-circle" />
                                                </a>
                                            @else
                                                <a href="{{ asset('demo_image/demo_user.png') }}" target="_blank">
                                                    <img height="70px;" src="{{ asset('demo_image/demo_user.png') }}" width="70px;" class="rounded-circle" />
                                                </a>
                                            @endif
                                    </td>
                                    <td>{{ $jury->phone }}</td>
                                    <td>
                                        @if ($jury->active_status == 0)
                                            <span class="badge badge-danger">Inactive</span>
                                        @elseif($jury->active_status == 1)
                                            <span class="badge badge-success">Active</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($jury->status == 0)
                                            <span class="badge badge-danger">Pending</span>
                                        @elseif($jury->status == 1)
                                            <span class="badge badge-success">Approved</span>
                                        @endif
                                    </td>
                                    <td style="width: 150px">
                                        @if ($jury->status == 0)
                                            <button class="btn btn-success" onclick="activeNow(this)"
                                                value="{{ route('superAdmin.jury.activeNow', $jury->id) }}">
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                            </button>
                                        @elseif($jury->status == 1)
                                            <button class="btn btn-danger" onclick="inactiveNow(this)"
                                                value="{{ route('superAdmin.jury.inactiveNow', $jury->id) }}">
                                                <i class="fa fa-close"></i>
                                            </button>
                                        @endif
                                        <a class="btn btn btn-info"
                                            onclick="Show('Edit Jury','{{ route('superAdmin.jury.edit', $jury->id) }}')"><i
                                                class="fa fa-edit text-white"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Sl</th>
                                <th>First name</th>
                                <th>Last name</th>
                                <th>Photo</th>
                                <th>Phone</th>
                                <th>Active Status</th>
                                <th>Pending Status</th>
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
                                    'Approved !',
                                    'This account has been Approved. ' + data.message,
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
                                    'Unapproved !',
                                    'This account has been Unapproved. ' + data.message,
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
