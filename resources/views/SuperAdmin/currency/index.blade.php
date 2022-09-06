@extends('Layouts.SuperAdmin.master')

@push('title')
Super Admin
@endpush

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Currency</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Currency List</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

<style>
    td, th{
        text-align: center;
    }
</style>

<div class="content">

    <div class="container-fluid">


        <div class="card">
            <div class="card-header">
              <h3 class="card-title">All Currencies List</h3>
              <a class="btn btn-success btn-sm" style="float: right;" onclick="Show('New Currency','{{ route('superAdmin.currency.create') }}')"><i class=" fa fa-plus"></i>&nbsp;New Currency</a>
              <!-- <a class="btn btn-info btn-sm mr-3" style="float: right;" onclick="currencyChanges(this)" value="{{ route('superAdmin.currency.currencyChanges') }}"><i class=" fa fa-check"></i>&nbsp;Update Value</a> -->
              <button class="btn btn-info btn-sm mr-3" style="float: right;" onclick="currencyChanges(this)" value="{{ route('superAdmin.currency.currencyChanges') }}">
                <i class=" fa fa-check"></i>&nbsp;Update Value
              </button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Country Name</th>
                        <th>Currency</th>
                        <th>Code</th>
                        <th>Symbol</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($currencies as $currency)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $currency->country ? $currency->country : '' }}</td>
                        <td>{{ $currency->currency ? $currency->currency : '' }}</td>
                        <td>{{ $currency->currency_code }}</td>
                        <td>{{ $currency->symbol }}</td>
                        <td>
                            @if ($currency->status == 0)
                            <span class="badge badge-danger">Unactive</span>
                            @elseif($currency->status == 1)
                            <span class="badge badge-success">Active</span>
                            @endif
                        </td>
                        <td style="width: 150px">
                            @if ($currency->status == 0)
                                <button class="btn btn-success" onclick="activeNow(this)" value="{{ route('superAdmin.currency.activeNow', $currency->id) }}">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                </button>
                            @elseif($currency->status == 1)
                                <button class="btn btn-danger" onclick="inactiveNow(this)" value="{{ route('superAdmin.currency.inactiveNow', $currency->id) }}">
                                    <i class="fa fa-close"></i>
                                </button>
                            @endif
                            <a class="btn btn btn-info" onclick="Show('Edit Currency','{{ route('superAdmin.currency.edit', $currency->id) }}')"><i class="fa fa-edit text-white"></i></a>
                            <button class="btn btn-danger" onclick="delete_function(this)" value="{{ route('superAdmin.currency.destroy', $currency->id) }}">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>SL</th>
                        <th>Country Name</th>
                        <th>Currency</th>
                        <th>Code</th>
                        <th>Symbol</th>
                        <th>Status</th>
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
            title: 'Are you sure?'
            , text: "You won't be able to revert this!"
            , icon: 'warning'
            , showCancelButton: true
            , confirmButtonColor: '#3085d6'
            , cancelButtonColor: '#d33'
            , confirmButtonText: 'Yes, Active !'
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
                                'Currency has been Activated. ' + data.message,
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
                    }
                , })
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
                    }
                    ,success: function(data) {
                        if (data.type == 'success') {
                            Swal.fire(
                                'Inactivated !',
                                'Currency has been Inactivated. ' + data.message,
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

    function currencyChanges(objButton) {
        var url = objButton.value;
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to change the currencies value!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Changes !'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    method: 'POST',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    }
                    ,success: function(data) {
                        if (data.type == 'success') {
                            Swal.fire(
                                'Changes !',
                                'Currency has been Changes. ' + data.message,
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




