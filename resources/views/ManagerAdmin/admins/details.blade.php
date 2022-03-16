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
                   <div class="container">
                        <div class="row">
                            <div class="col-md-2 offset-md-3">
                            <div class="card" style="background-color: white;height:250px;">
                               <div style="height:170px; width:100%;" class="justify-content-center  d-flex align-items-center">
                                        <div style="background-color:#ffff; border-radius:50%; border: 2px solid rgba(190, 11, 11, 0.067); height:70px; width:80px; color:red;" class="justify-content-center  d-flex align-items-center">
                                            @if ($admin->assignAudition)
                                            <span class="right badge border border-danger my-2">Assigned</span> ⭕<br>
                                            @else
                                                <span class="right badge border border-success my-2">Free Now</span><br>
                                            @endif
                                        </div>
                               </div>
                                <h2 class="my-5 h2" style="color:black;">Star Assign</h2>
                            </div>
                        </div>
                            <div class="col-md-2">
                            <div class="card" style="background-color: white;height:250px;">
                               <div style="height:170px; width:100%;" class="justify-content-center  d-flex align-items-center">
                                        <div style="background-color:#ffff; border-radius:50%; border: 2px solid rgba(190, 11, 11, 0.067); height:70px; width:80px; color:red;" class="justify-content-center  d-flex align-items-center">
                                            @if ($admin->assignAudition)
                                            <span class="right badge border border-danger my-2">Assigned</span> ⭕<br>
                                            @else
                                                <span class="right badge border border-success my-2">Free Now</span><br>
                                            @endif
                                        </div>
                               </div>
                                <h2 class="my-5 h2" style="color:black;"> Event Assign</h2>
                            </div>
                        </div>
                            <div class="col-md-2">
                            <div class="card" style="background-color: white;height:250px;">
                               <div style="height:150px; width:100%;" class="justify-content-center  d-flex align-items-center">
                                        <div style="background-color:#ffff; border-radius:50%; border: 2px solid rgba(190, 11, 11, 0.067); height:70px; width:80px; color:red;" class="justify-content-center  d-flex align-items-center">
                                            @if ($admin->assignAudition)
                                            <span class="right badge border border-danger my-2">Assigned</span> ⭕<br>
                                            @else
                                                <span class="right badge border border-success my-2">Free Now</span><br>
                                            @endif
                                        </div>
                               </div>
                                <h2 class="my-5 h2" style="color:black;">Event Completed</h2>
                            </div>
                        </div>
                            <div class="col-md-2">
                            <div class="card" style="background-color: white;height:250px;">
                               <div style="height:150px; width:100%;" class="justify-content-center  d-flex align-items-center">
                                        <div style="background-color:#ffff; border-radius:50%; border: 2px solid rgba(190, 11, 11, 0.067); height:70px; width:80px; color:red;" class="justify-content-center  d-flex align-items-center">
                                            @if ($admin->assignAudition)
                                            <span class="right badge border border-danger my-2">Assigned</span> ⭕<br>
                                            @else
                                                <span class="right badge border border-success my-2">Free Now</span><br>
                                            @endif
                                        </div>
                               </div>
                                <h2 class="my-5 h2" style="color:black;">Month Supervised</h2>
                            </div>
                        </div>
                   </div>
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
                                        @error('job_type')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-2">
                                        <label>Title</label>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" name="title" class="form-control" placeholder="Title"
                                            autocomplete="off" value="{{ old('title') }}">
                                        @error('title')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-2">
                                        <label>Details</label>
                                    </div>
                                    <div class="col-10">
                                        <textarea name="details" class="form-control"
                                            rows="7">{{ old('details') }}</textarea>
                                        @error('details')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
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
