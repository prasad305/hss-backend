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
          <h1 class="m-0">About Us</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">About Us</li>
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
                  <h3 class="card-title">Aboute Us </h3>
                  <a class="btn btn-success btn-sm" style="float: right;" onclick="Show('Add About Summary','{{ route('superAdmin.aboutUs.create') }}')"><i class=" fa fa-plus"></i>&nbsp;New About Summary</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Aboute us</th>
                            <th>Status</th>
                            <th style="width: 150px">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                  @if (isset($data))
                       <tr>
                        <td>{!! $data->details !!}</td>
                        <td>
                          @if ($data->status == 1)
                              <span class="badge badge-info" style="width: 70px;">Active</span>
                          @else
                              <span class="badge badge-danger" style="width: 70px;">InActive</span>
                          @endif
                      </td>
                        <td style="width: 150px">
                            <a class="btn btn-sm btn-info"
                                onclick="Show('Edit AboutUs','{{ route('superAdmin.aboutUs.edit', $data->id) }}')"><i
                                    class="fa fa-edit text-white"></i></a>
                            {{-- <button class="btn btn-sm btn-danger" onclick="delete_function(this)"
                                value="{{ route('superAdmin.aboutUs.destroy', $data->id) }}"><i
                                    class="fa fa-trash"></i> </button> --}}
                        </td>
                        
                        </tr>
                        @else
                           <tr>
                            <td>No Data Found</td>
                            <td></td>
                            <td></td>
                          </tr>
                       @endif
                            
                     

                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
            </div>

        </div> <!-- container -->
    </div> <!-- content -->

@endsection
