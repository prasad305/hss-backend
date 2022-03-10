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



    <div class="content text-center px-5">

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
                    <img class="img-circle" src="{{ asset($admin->image) }}" alt="User Avatar"
                        style="height: 120px!important; width: 120px!important">
                </div>
                <div class="card-footer mt-2">
                    <div class="mx-auto my-3">
                        <h4 class="text-center">{{ $admin->first_name }} {{ $admin->last_name }}</h4>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                                <h5 class="description-header">3,200</h5>
                                <span class="description-text">Event Completed</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                                <h5 class="description-header">13,000</h5>
                                <span class="description-text">Months Supervison</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4">
                            <div class="description-block">
                                <h5 class="description-header">35</h5>
                                <span class="description-text">More</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <div class="row">



                    </div>
                    <!-- /.row -->
                </div>
                <div class="card m-4">
                    @if ($admin->assignAudition)
                    @else
                        <form action="{{ route('managerAdmin.AuditionAssign', $admin->id) }}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-2">
                                        <label>Assign To</label>
                                    </div>
                                    <div class="col-10">
                                        <select class="custom-select" name="job_type" id="exampleSelectRounded0">
                                            <option value="audition">Audition</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-2">
                                        <label>Title</label>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" name="title" class="form-control" placeholder="Title"
                                            autocomplete="off" value="{{ old('title') }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-2">
                                        <label>Details</label>
                                    </div>
                                    <div class="col-10">
                                        <textarea name="details" class="form-control"
                                            rows="7">{{ old('details') }}</textarea>
                                    </div>
                                </div>
                                <div class=" float-right">

                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>

                            </div>

                        </form>
                    @endif

                </div>


            </div>

            <!-- /.widget-user -->

        </div>

    </div>
@endsection
