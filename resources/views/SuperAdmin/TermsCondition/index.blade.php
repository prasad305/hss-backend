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
          <h1 class="m-0">Terms And Condition</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Terms And Condition</li>
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
                  <h3 class="card-title">Terms And Condition</h3>
                  <a class="btn btn-success btn-sm" style="float: right;" onclick="Show('Add Terms And Condition','{{ route('superAdmin.termscondition.create') }}')"><i class=" fa fa-plus"></i>&nbsp;Add Terms And Condition</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Details</th>
                            <th>Status</th>
                            <th style="width: 150px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($termscondition)
                            <tr>
                                <td>{{$termscondition->title}}</td>
                                <td>{!!$termscondition->details !!}</td>
                                <td>
                                    @if($termscondition->status  === 1)
                                    <span class="badge badge-success">Active</span>
                                    @else
                                    <span class="badge badge-danger">InActive</span>
                                    @endif
                                </td>
                                <td style="width: 150px">
                                    <a class="btn btn-sm btn-info"
                                        onclick="Show('Edit Terms And Condition','{{ route('superAdmin.termscondition.edit', $termscondition->id) }}')">
                                        <i class="fa fa-edit text-white"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger" onclick="delete_function(this)"
                                        value="{{ route('superAdmin.termscondition.destroy', $termscondition->id) }}"><i
                                            class="fa fa-trash"></i> </button>
                                </td>
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
