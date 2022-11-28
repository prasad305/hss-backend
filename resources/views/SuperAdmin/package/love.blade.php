@extends('Layouts.SuperAdmin.master')

@push('title')
    Super Admin | Love React
@endpush

<style>
.check{
    border: 1px solid #62ff21; padding: 2px 3px;border-radius: 50%;
}
.xmark{
    border: 1px solid #4b5546; padding: 2px 5px;border-radius: 50%;
}
</style>

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Love Lists</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active">Love List</li>
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
                  <h3 class="card-title">All Love React Lists</h3>
                  <a class="btn btn-success btn-sm" style="float: right;" onclick="Show('New love','{{ route('superAdmin.love.create') }}')"><i class=" fa fa-plus"></i>&nbsp;New Love React</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row">
                    @foreach ($love as $key => $data)
                    <div class="col-md-3">
                      <div class="card text-center">
                          <div class="card-header" style=" background: {{ $data->color_code }}; height: 50px; margin-bottom: 20px; font-weight: 600; font-size: 20px; ">
                            {{ $data->title }}

                            <a class="btn btn-sm btn-info" style="float: right; margin-right: 8px;"
                      onclick="Show('Edit Love','{{ route('superAdmin.love.edit', $data->id) }}')"><i
                          class="fa fa-edit text-white"></i></a>
                          </div>
                          <div class="card-body">
                            <p class=""><i class="fa {{ $data->love_points ? 'fa-check check' : 'fa-xmark xmark' }}"></i> Love Points :: {{ $data->love_points }} </p>
                          </div>
                          <div class="card-footer text-muted" style="color: #f0e25e !important; font-size: 30px; font-weight: 600;">
                            Price :: {{ $data->price }} Tk
                          </div>
                        </div>
                    </div>
                    
                    @endforeach
                  </div>
                </div>
                <!-- /.card-body -->
            </div>




        </div> <!-- container -->
    </div> <!-- content -->


   
@endsection

