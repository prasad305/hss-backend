@extends('Layouts.ManagerAdmin.master')

@push('title')
    Greeting Request
@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Greeting </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Greeting Requests</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>




    <div class="content">
        <div class="container-fluid">
            <div class="row mb-3">
                @foreach ($greetings as $key => $greeting)
                    <!--card-->

                    <div class="col-sm-12 col-md-4 col-lg-3">
                        <div class="card">
                            <div class="panel panel-primary p-2 text-center">


                                <img src="{{ asset($greeting->banner) }}" class="img-fluid card-img" />

                                <div class="panel-body py-3">
                                    <h5 class="text-ellipsis-line-1">{{ $greeting->title }}</h5>

                                    <p class="card-text text-center">Cost : {{ $greeting->cost }} BDT</p>

                                    <a href="{{ route('managerAdmin.greeting.show', $greeting->id) }}" type="button"
                                        class="btn btnDetails waves-effect waves-light mb-2">Details <i
                                            class="fa fa-angle-double-right"></i></a>

                                </div>
                            </div>

                        </div>
                    </div>
                    <!--card end-->
                @endforeach
            </div>

        </div> <!-- container -->
    </div>
@endsection
