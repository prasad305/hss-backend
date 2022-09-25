@extends('Layouts.SuperAdmin.master')

@push('title')
    Super Admin | City
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
                    <h4 class="mx-3 text-white p-2">All City list</h4>
                </div>
            </div>
      
        </div><!-- /.container-fluid -->
      </div>

    <!-- /.content-header -->



    <div class="content">

        <div class="container-fluid">



            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">All City Lists</h3>
                    <a class="btn btn-success btn-sm" style="float: right;"
                        onclick="Show('New city','{{ route('superAdmin.city.create') }}')"><i
                            class=" fa fa-plus"></i>&nbsp;New city</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>City Name</th>
                                <th>State Name</th>
                                <th>Country Name</th>
                                <th>Status</th>
                                <th style="width: 150px">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($city as $key => $data)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td>{{ $data->state->name ?? '' }}</td>
                                    <td>{{ $data->country->name ?? '' }}</td>
                                    <td>
                                        @if ($data->status)
                                            <span class="badge badge-info" style="width: 70px;">Active</span>
                                        @else
                                            <span class="badge badge-danger" style="width: 70px;">InActive</span>
                                        @endif
                                    </td>

                                    <td style="width: 150px">
                                        <a class="btn btn-sm btn-info"
                                            onclick="Show('Edit city','{{ route('superAdmin.city.edit', $data->id) }}')"><i
                                                class="fa fa-edit text-white"></i></a>
                                        @if ($data->status == 0)
                                            <button class="btn btn-success" onclick="activeNow(this)"
                                                value="{{ route('superAdmin.city.activeNow', $data->id) }}">
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                            </button>
                                        @elseif($data->status == 1)
                                            <button class="btn btn-danger" onclick="inactiveNow(this)"
                                                value="{{ route('superAdmin.city.inactiveNow', $data->id) }}">
                                                <i class="fa fa-close"></i>
                                            </button>
                                        @endif
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
                                    'Status has been Activated. ' + data.message,
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
                                    'Status has been Inactivated. ' + data.message,
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
