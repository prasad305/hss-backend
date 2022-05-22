@extends('Layouts.ManagerAdmin.master')

@push('title')
 Admin
@endpush

@push('css')
      <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('assets/manager-admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/manager-admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/manager-admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endpush

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"> Star</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active"> Star List</li>
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
                        onclick="Show('New Star','{{ route('managerAdmin.star.create') }}')"><i
                            class=" fa fa-plus"></i>&nbsp;New Star</a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>SL.</th>
                        <th>Sub Category</th>
                        <th>Name</th>
                        <th>DOB</th>
                        <th>Approve Status</th>
                        <th>Active Status</th>
                        <th style="width: 150px">Action</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($stars as $star)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $star->subCategory ? $star->subCategory->name : '' }}</td>
                            <td>{{ $star->first_name . ' ' . $star->last_name }}</td>
                            <td>{{date('Y-m-d',strtotime($star->dob))}}</td>
                            <td>
                                @if ($star->status == 0)
                                    <span class="badge badge-danger">Pending</span>
                                @endif
                                @if ($star->status == 1)
                                    <span class="badge badge-success">Approved</span>
                                @endif
                            </td>
                            
                            <td>
                                @if ($star->active_status == 0)
                                    <span class="badge badge-danger">InActive</span>
                                @endif
                                @if ($star->active_status == 1)
                                    <span class="badge badge-success">Active</span>
                                @endif
                            </td>

                            <td style="width: 150px">
                                @if ($star->active_status == 0)
                                <button class="btn btn-sm btn-success" onclick="activeNow(this)" value="{{ route('managerAdmin.star.activeNow', $star->id) }}">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                </button>
                            @elseif($star->active_status == 1)
                                <button class="btn btn-sm btn-danger" onclick="inactiveNow(this)" value="{{ route('managerAdmin.star.inactiveNow', $star->id) }}">
                                    <i class="fa fa-close"></i>
                                </button>
                            @endif
                                <a class="btn btn-sm btn-info"
                                    onclick="Show('Edit Audition Admin','{{ route('managerAdmin.star.edit', $star->id) }}')"><i
                                        class="fa fa-edit text-white"></i>
                                </a>
                                <button class="btn btn-sm btn-danger" onclick="delete_function(this)"
                                    value="{{ route('managerAdmin.star.destroy', $star) }}"><i
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

@push('js')
<script src="{{asset('assets/manager-admin/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/manager-admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/manager-admin/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/manager-admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/manager-admin/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/manager-admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/manager-admin/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('assets/manager-admin/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('assets/manager-admin/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('assets/manager-admin/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/manager-admin/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/manager-admin/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>
@endpush
