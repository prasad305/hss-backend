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
          <h1 class="m-0">Marketplace</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active">Marketplace List</li>
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
                  <h3 class="card-title">All Marketplace Lists</h3>
                  {{-- <a class="btn btn-success btn-sm" style="float: right;" onclick="Show('New Interest Type','{{ route('superAdmin.interest-type.create') }}')"><i class=" fa fa-plus"></i>&nbsp;New Marketplace Type</a> --}}
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Title</th>
                            <th>Image</th>
                            <th>Total Items</th>
                            <th>Unit Price</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th style="width: 150px">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($marketplace as $key => $data)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $data->title }}</td>
                                <td>
                                    <img src="{{ asset($data->image) }}" style="height: 60px; border-radius: 67%; border: 2px solid #90fd00;" alt="">
                                </td>
                                <td>{{ $data->total_items }}</td>
                                <td>{{ $data->unit_price }}</td>
                                <td>{!! $data->description !!}</td>
                                <td>
                                  @if($data->status)
                                  <span class="badge badge-info" style="width: 70px;">Active</span>
                                  @else
                                  <span class="badge badge-danger" style="width: 70px;">InActive</span>
                                  @endif
                                </td>
                                
                                <td style="width: 150px">
                                    {{-- <a class="btn btn-sm btn-info"
                                        onclick="Show('Edit Interest Type','{{ route('superAdmin.interest-type.edit', $data->id) }}')"><i
                                            class="fa fa-edit text-white"></i></a> --}}
                                        @if ($data->status == 0)
                                            <button class="btn btn-success" onclick="activeNow(this)" value="{{ route('superAdmin.marketplace.activeNow', $data->id) }}">
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                            </button>
                                        @elseif($data->status == 1)
                                            <button class="btn btn-danger" onclick="inactiveNow(this)" value="{{ route('superAdmin.marketplace.inactiveNow', $data->id) }}">
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
