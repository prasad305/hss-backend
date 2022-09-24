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
        <h1 class="m-0">Event List</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Event List</li>
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

      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <!-- <th>Name</th>
                            <th>Email</th> -->
              <th>Id</th>
              <th>Amount</th>
              <th style="width: 150px">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($learning_seassion_reg as $data)
            <tr>
              <td>{{ $data->user_id }}</td>
              <td>
              <td>{{ $data->amount }}</td>
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



@endsection