@extends('Layouts.ManagerAdmin.master')

@push('title')
Jury Board
@endpush

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Jury Board Details</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Jury Board List</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

{{-- cover_photo --}}

<div class="content text-center px-5">

    <div class="container-fluid">

        <!-- Widget: user widget style 1 -->
        <div class=" card-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->

            <div class="widget-user-header text-white AdminCover"
                style="background: url('{{ asset($jury->image) }}')center ; background-repet:none !important;">
                {{-- <h3 class="widget-user-username text-right">Elizabeth Pierce</h3>
                <h5 class="widget-user-desc text-right">Web Designer</h5> --}}

                <div class="centeredImg">
                    <img class="img-circle ImGAdmin" src="{{ asset($jury->image) }}" alt="User Avatar">
                    <h4 class="text-center">{{ $jury->first_name }} {{ $jury->last_name }}</h4>
                    <span class=" text-center fw-bold text-primary"><b>Music</b></span>
                </div>
            </div>

            <br /> <br /> <br/>

            <div class="mt-5">

                <div class="container mt-5">
                    <div class="row">

                        <div class="col-md-3">
                            <div class="card Cardnew">
                                <div style="height:170px; width:100%;"
                                    class="justify-content-center  d-flex align-items-center">
                                    <div style="background-color:#ffff; border-radius:50%; border: 3px solid rgb(0, 183, 255); height:110px; width:110px; color:rgb(0, 183, 255); font-size:25px;"
                                        class="justify-content-center  d-flex align-items-center">
                                        <h4><b>-</b></h4>
                                    </div>
                                </div>
                                <h5 class="mb-5" style="color:black;">Star assigned</h5>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card Cardnew">
                                <div style="height:170px; width:100%;"
                                    class="justify-content-center  d-flex align-items-center">
                                    <div style="background-color:#ffff; border-radius:50%; border: 3px solid rgb(0, 183, 255); height:110px; width:110px; color:rgb(0, 183, 255); font-size:25px;"
                                        class="justify-content-center  d-flex align-items-center">
                                        <h4><b>-</b></h4>
                                    </div>
                                </div>
                                <h5 class="mb-5" style="color:black;">Event assigned</h5>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card Cardnew">
                                <div style="height:170px; width:100%;"
                                    class="justify-content-center  d-flex align-items-center">
                                    <div style="background-color:rgb(0, 183, 255); border-radius:50%; border: 2px solid rgba(190, 11, 11, 0.067); height:110px; width:110px; color:white; font-size:25px; "
                                        class="justify-content-center  d-flex align-items-center">
                                        <h4><b>12</b></h4>
                                    </div>
                                </div>
                                <h5 class="mb-5" style="color:black;">Event Completed</h5>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card Cardnew">
                                <div style="height:170px; width:100%;"
                                    class="justify-content-center  d-flex align-items-center">
                                    <div style="background-color:rgb(0, 183, 255); border-radius:50%; border: 2px solid rgba(190, 11, 11, 0.067); height:110px; width:110px; color:white; font-size:25px; "
                                        class="justify-content-center  d-flex align-items-center">
                                        <h4><b>12</b></h4>
                                    </div>
                                </div>
                                <h5 class="mb-5" style="color:black;">Months Supervised</h5>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row justify-content-center mt-5">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <button class="nav-link active btn  mx-2 bg-light" data-toggle="tab" href="#home">Details
                            </button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link btn  mx-2 bg-info" data-toggle="tab" href="#menu1">Assign
                            </button>
                        </li>
                    </ul>
                </div>

                {{-- <!-- Tab panes -->
                <div class="tab-content mt-3">
                    <div id="home" class="tab-pane active mb-5"></div>

                    <div id="menu1" class=" tab-pane fade">

                        <div class="card my-4">
                            @if ($jury->assignAudition)
                            @else
                            <form action="{{ route('managerAdmin.AuditionAssign', $jury->id) }}" method="post">
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

                </div> --}}

            </div>

            <!-- /.widget-user -->

        </div>

    </div>

    <style>
        .dark-mode .card {
            /* background-color: #343a40; */
            color: #fff;
        }
        .AdminCover {
            object-fit: cover;
            background-repeat: none !important;
            height: 200px !important;
            margin-bottom: 20px;
        }


        .ImGAdmin {
            width: 120px !important;
            height: 120px !important;
            margin-top: 50px;
            border: 5px solid white;
        }

        .nav-tabs {
            border-bottom: none;
        }

        .centeredImg {
            position: absolute;
            top: 200px;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .Cardnew{
            background-color: white !important;
        }


    </style>

    @endsection
