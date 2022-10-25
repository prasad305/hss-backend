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
          <h1 class="m-0">Virtual Tour</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Virtual Tour</li>
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
                  <h3 class="card-title">Virtual Tour</h3>
                  <a class="btn btn-success btn-sm" style="float: right;" onclick="Show('Add Virtual Tour','{{ route('superAdmin.virtual-tour.create') }}')"><i class=" fa fa-plus"></i>&nbsp;Add Virtual Tour</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Offline Video</th>
                            <th>Youtube Video</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th style="width: 150px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($virtualtours as $virtualtour)
                            <tr>
                                <td>{{$virtualtour->title}}</td>
                                <td>
                                    @if($virtualtour->video)
                                        <video width="312" controls>
                                            <source src="{{asset($virtualtour->video)}}" />
                                        </video>
                                    @else
                                    There are no videos
                                    @endif
                                </td>
                                <td>
                                    @if($virtualtour->link)
                                        <iframe width="400" height="250"
                                            src="{{asset($virtualtour->link)}}">
                                        </iframe>
                                    @else
                                    There are no videos
                                    @endif
                                </td>
                                <td>{{$virtualtour->type}}</td>
                                <td>
                                    @if($virtualtour->status == 1)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">InActive</span>
                                    @endif
                                </td>
                                <td style="width: 150px">
                                    <a class="btn btn-sm btn-info"
                                        onclick="Show('Edit Virtual Tour','{{ route('superAdmin.virtual-tour.edit', $virtualtour->id) }}')">
                                        <i class="fa fa-edit text-white"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger" onclick="delete_function(this)"
                                        value="{{ route('superAdmin.virtual-tour.destroy', $virtualtour->id) }}"><i
                                            class="fa fa-trash"></i> </button>
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
