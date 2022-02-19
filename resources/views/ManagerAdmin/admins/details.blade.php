@extends('Layouts.ManagerAdmin.master')

@push('title')
Manager Admin
@endpush



@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Admin Details</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Admin List</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->



<div class="content">

    <div class="container-fluid">

        <!-- Widget: user widget style 1 -->
        <div class="card card-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header text-white"
                 style="background: url('{{ asset($admin->cover_photo) }}') center center;">
              <h3 class="widget-user-username text-right">Elizabeth Pierce</h3>
              <h5 class="widget-user-desc text-right">Web Designer</h5>
            </div>
            <div class="widget-user-image">
              <img class="img-circle" src="{{ asset($admin->image) }}" alt="User Avatar" style="height: 120px!important; width: 120px!important">
            </div>
            {{-- <div class="card-footer">
              <div class="row">
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header">3,200</h5>
                    <span class="description-text">SALES</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header">13,000</h5>
                    <span class="description-text">FOLLOWERS</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4">
                  <div class="description-block">
                    <h5 class="description-header">35</h5>
                    <span class="description-text">PRODUCTS</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div> --}}

            <div class="card-footer row">
                <div class="mx-auto mt-3">
                  <h3 class="text-center">{{ $admin->first_name }} {{ $admin->last_name }}</h3>
                </div>
            </div>


          </div>
          <!-- /.widget-user -->

    </div>

</div>



@endsection

