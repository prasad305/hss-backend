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
          <h1 class="m-0">Jury Group</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Jury Group List</li>
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
              <a class="btn btn-success btn-sm" style="float: right; margin-bottom: 10px;" onclick="Show('New Jury Group','{{ route('superAdmin.jury_groups.create') }}')"><i class=" fa fa-plus"></i>&nbsp;New Jury Group</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Category</th>
                        <th>Name</th>
                        <th style="width: 150px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($groups as $key => $group)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $group->category ? $group->category->name : '' }}</td>
                        <td>{{ $group->name }}</td>
                        <td style="width: 150px">
                            <a class="btn btn-sm btn-info" onclick="Show('Edit Jury Group','{{ route('superAdmin.jury_groups.edit', $group->id) }}')"><i class="fa fa-edit text-white"></i></a>
                            <button class="btn btn-sm btn-danger" onclick="delete_function(this)" value="{{ route('superAdmin.jury_groups.destroy', $group) }}"><i class="fa fa-trash"></i> </button>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
              </table>
            </div>
        </div>



    </div> <!-- container -->
</div> <!-- content -->


@endsection


