@extends('Layouts.ManagerAdmin.master')

@push('title')
    Super Admin
@endpush



@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Apply Delete List</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active">All Apply Delete List</li>
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
                  <h3 class="card-title">All Apply Delete Lists</h3>
                  {{-- <a class="btn btn-success btn-sm" style="float: right;" onclick="Show('New Interest Type','{{ route('superAdmin.interest-type.create') }}')"><i class=" fa fa-plus"></i>&nbsp;New Marketplace Type</a> --}}
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>User Name</th>
                            <th>Image</th>
                            <th>Mobile No</th>
                            <th>Area</th>
                            <th>Star Name</th>
                            <th>Apply Date</th>
                            <!-- <th>Status</th> -->
                            <th style="width: 50px">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    @if($applyDeleteSouvenir)
                        @foreach ($applyDeleteSouvenir as $key => $data)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $data->name }}</td>
                                <td>
                                    <img src="{{ asset($data->image) }}" style="height: 60px; border-radius: 67%; border: 2px solid #90fd00;" alt="">
                                </td>
                                <td>{{ $data->mobile_no }}</td>
                                <td>{{ $data->area }}, {{ $data->city->name }}
                                    <br>
                                    {{ $data->state->name }}, {{ $data->country->name }}
                                </td>
                                <td>{{ $data->star->first_name }} {{ $data->star->last_name }}
                                    <br>
                                    {{ $data->star->phone }}
                                </td>
                                <td>{{ $data->created_at->diffForHumans() }}</td>
                                <td>
                                    <button class="btn btn-success" onclick="restoreNow(this)" title="Restore" value="{{ route('managerAdmin.souvenir.restoreNow', $data->id) }}">
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                    </button>
                                    <button class="btn btn-danger" onclick="deleteNow(this)" title="Delete" value="{{ route('managerAdmin.souvenir.deleteNow', $data->id) }}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>

                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
            </div>




        </div> <!-- container -->
    </div> <!-- content -->


    <script>
      function restoreNow(objButton) {
          var url = objButton.value;
          // alert(objButton.value)
          Swal.fire({
              title: 'Are you sure?'
              , text: "You want to restore this!"
              , icon: 'warning'
              , showCancelButton: true
              , confirmButtonColor: '#3085d6'
              , cancelButtonColor: '#d33'
              , confirmButtonText: 'Yes, Restore !'
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
                      }
                  , })
              }
          })
      }
  
      function deleteNow(objButton) {
          var url = objButton.value;
          Swal.fire({
              title: 'Are you sure?',
              text: "You want to delete this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, Delete !'
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
                                  'Deleted !',
                                  'Deleted Successfully. ' + data.message,
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
