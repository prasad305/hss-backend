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
          <h1 class="m-0">Refund Policy</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Refund Policy</li>
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
                  <h3 class="card-title">Refund Policy</h3>
                  <a class="btn btn-success btn-sm" style="float: right;" onclick="Show('Add Refund Policy','{{ route('superAdmin.refundpolicy.create') }}')"><i class=" fa fa-plus"></i>&nbsp;Add Refund Policy</a>
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
                        @if($refundpolicy)
                            <tr>
                                <td>{{$refundpolicy->title}}</td>
                                <td>{!!$refundpolicy->details !!}</td>
                                <td>
                                    @if($refundpolicy->status  === 1)
                                    <span class="badge badge-success">Active</span>
                                    @else
                                    <span class="badge badge-danger">InActive</span>
                                    @endif
                                </td>
                                <td style="width: 150px">
                                    <a class="btn btn-sm btn-info"
                                        onclick="Show('Edit Refund Policy','{{ route('superAdmin.refundpolicy.edit', $refundpolicy->id) }}')">
                                        <i class="fa fa-edit text-white"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger" onclick="delete_function(this)"
                                        value="{{ route('superAdmin.refundpolicy.destroy', $refundpolicy->id) }}"><i
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
