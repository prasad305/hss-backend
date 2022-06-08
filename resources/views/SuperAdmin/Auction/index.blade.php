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
          <h1 class="m-0">Auction</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Auction</li>
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
                  <h3 class="card-title">Auction Instruction</h3>
                  <a class="btn btn-success btn-sm" style="float: right;" onclick="Show('Add Terms and Conditions','{{ route('superAdmin.auctionTerms.create') }}')"><i class=" fa fa-plus"></i>&nbsp;New Terms And Conditions</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Instructions</th>
                            <th style="width: 150px">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($instruction as $data)
                            <tr>
                                <td>{!! $data->acquired_instruction !!}</td>
                                <td style="width: 150px">
                                    <a class="btn btn-sm btn-info"
                                        onclick="Show('Edit Instruction','{{ route('superAdmin.auctionTerms.edit', $data->id) }}')"><i
                                            class="fa fa-edit text-white"></i></a>
                                    <button class="btn btn-sm btn-danger" onclick="delete_function(this)"
                                        value="{{ route('superAdmin.auctionTerms.destroy', $data->id) }}"><i
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
