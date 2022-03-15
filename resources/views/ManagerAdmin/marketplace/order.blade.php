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
          <h1 class="m-0">Order List</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active">All Order List</li>
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
                  <h3 class="card-title">All Order Lists</h3>
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
                            <th>Items</th>
                            <th>Unit Price</th>
                            <th>Total Price</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th style="width: 150px">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($orders as $key => $data)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $data->marketplace->title }}</td>
                                <td>
                                    <img src="{{ asset($data->marketplace->image) }}" style="height: 60px; border-radius: 67%; border: 2px solid #90fd00;" alt="">
                                </td>
                                <td>{{ $data->items }}</td>
                                <td>{{ $data->unit_price }}</td>
                                <td>{{ $data->total_price }}</td>
                                <td>{{ $data->phone }}</td>
                                <td>
                                  @if($data->status == 0)
                                  <span class="badge badge-danger" style="width: 70px;">Pending</span>
                                  @elseif($data->status == 1)
                                  <span class="badge badge-primary" style="width: 70px;">Received</span>
                                  @else
                                  <span class="badge badge-success" style="width: 70px;">Delivery</span>
                                  @endif
                                </td>
                                
                                <td style="width: 150px">
                                    <a href="{{ route('managerAdmin.marketplace.allOrderDetails', $data->id) }}" class="btn btn-sm btn-info"><i class="fa fa-eye text-white"></i></a>
                                        {{-- @if ($data->status == 0)
                                            <button class="btn btn-success" onclick="activeNow(this)" value="{{ route('superAdmin.marketplace.activeNow', $data->id) }}">
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                            </button>
                                        @elseif($data->status == 1)
                                            <button class="btn btn-danger" onclick="inactiveNow(this)" value="{{ route('superAdmin.marketplace.inactiveNow', $data->id) }}">
                                                <i class="fa fa-close"></i>
                                            </button>
                                        @endif --}}
                                </td>
                            </tr>


                            <!-- Button trigger modal -->
{{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Launch demo modal
  </button>
  
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div> --}}
  
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
