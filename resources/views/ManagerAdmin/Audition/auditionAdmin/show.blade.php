@extends('Layouts.ManagerAdmin.master')

@push('title')
    Admin
@endpush

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <div>
        <div class="content text-center px-5 adminAssignPadding">
            <div class="container-fluid widgetUserPadding">
                <div class=" card-widget widget-user paddingWidget">
                    <div class=" text-white AdminCover"
                        style="background-image: url({{ asset($auditionAdmin->cover_photo ?? get_static_option('no_image')) }})">
                        <div class="centeredImg">
                            <img class="img-circle ImGAdmin"
                                src="{{ asset($auditionAdmin->photo ?? get_static_option('no_image')) }}"
                                alt="User Avatar">
                            <h4 class="text-center nameAdmin">Abdullah Al Zaber</h4>
                            <span class=" text-center fw-bold text-warning"><b>Music</b></span>
                        </div>
                    </div>
                    <br /> <br /> <br />
                    <div class="mt-5 pt-2">
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
                                        <h5 class="mb-5" style="color:#638bc9;">Star assigned</h5>
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
                                        <h5 class="mb-5" style="color:#638bc9;">Event assigned</h5>
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
                                        <h5 class="mb-5" style="color: #638bc9;">Event Completed</h5>
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
                                        <h5 class="mb-5" style="color:#638bc9;">Months Supervised</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row justify-content-center mt-5">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <button class="nav-link active btn  mx-2 bg-light" data-toggle="tab" href="#home">Cancel
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('managerAdmin.audition.adminAssignSubmit') }}">
                                        <button
                                            class="nav-link btn  mx-2 bg-info">Assign
                                        </button>
                                    </a>
                                </li>
                            </ul>
                        </div> --}}

                        <div class="row justify-content-center mt-5">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <button class="nav-link btn  mx-2 bg-light" data-toggle="tab" href="#Details">Details
                                    </button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link btn  mx-2 bg-info" data-toggle="tab" href="#Assign">Assign
                                    </button>
                                </li>
                            </ul>
                        </div>


                        <!-- Tab panes -->
                        <div class="tab-content mt-3">
                            <div id="Home" class="tab-pane active mb-5">

                            </div>
                            <div id="Details" class="tab-pane fade">

                            </div>

                            <div id="Assign" class=" tab-pane fade">
                                <div class="card my-4">
                                    @if ($auditionAdmin->assignAudition)
                                    @else
                                        <form action="{{ route('managerAdmin.AuditionAssign', $auditionAdmin->id) }}"
                                            method="post">
                                            @csrf
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <div class="col-2">
                                                        <label>Admin Name</label>
                                                    </div>
                                                    <div class="col-10">
                                                        <input type="text" name="admin_name" class="form-control" readonly value="{{ $auditionAdmin->first_name .' '.$auditionAdmin->last_name }}">
                                                        @error('admin_name')
                                                            <p class="text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-2">
                                                        <label>Assign To</label>
                                                    </div>
                                                    <div class="col-10">
                                                        <select readonly class="custom-select" name="job_type">
                                                            <option selected value="audition">Audition</option>
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
                                                        <textarea name="title" class="form-control" rows="3">{{ old('title') }}</textarea>
                                                        @error('title')
                                                            <p class="text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-2">
                                                        <label>Description</label>
                                                    </div>
                                                    <div class="col-10">
                                                        <textarea name="description" class="form-control" rows="6">{{ old('description') }}</textarea>
                                                        @error('description')
                                                            <p class="text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-2">
                                                        <label>Select Juries</label>
                                                    </div>
                                                    <div class="col-10">
                                                        {{-- <select class="select2"   name="juries[]" multiple="multiple" data-placeholder="Select Juries" style="width: 100%;">
                                                            <option value="Alabama">Alabama</option>
                                                            <option value="Alaska">Alaska</option>
                                                            <option value="California">California</option>
                                                            <option value="Delaware">Delaware</option>
                                                            <option value="Tennessee">Tennessee</option>
                                                            <option value="Texas">Texas</option>
                                                            <option value="Washington">Washington</option>
                                                          </select> --}}



                                                          <div class="form-group">
                                                            <label>Multiple</label>
                                                            <select class="select2" multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
                                                              <option>Alabama</option>
                                                              <option>Alaska</option>
                                                              <option>California</option>
                                                              <option>Delaware</option>
                                                              <option>Tennessee</option>
                                                              <option>Texas</option>
                                                              <option>Washington</option>
                                                            </select>
                                                          </div>


                                                        {{-- <select multiple class="form-control"  name="juries[]">
                                                            <option  value="audition">Audition</option>
                                                            <option  value="fghf">dgfdh</option>
                                                            <option  value="fhfjh">fgjtyjkyrj</option>
                                                        </select> --}}
                                                        @error('juries')
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .dark-mode .card {
            /* background-color: #343a40; */
            color: #fff;
        }

        .paddingWidget {
            padding: 20px !important;
        }

        .AdminCover {
            background-repeat: none !important;
            background-size: cover !important;
            /* object-fit: cover !important; */
            height: 350px !important;
            margin-bottom: 20px;
            border: 2px solid #ff0;
            border-radius: 15px;
        }

        .ImGAdmin {
            width: 180px !important;
            height: 180px !important;
            margin-top: 50px;
            border: 8px solid white;
        }

        .nav-tabs {
            border-bottom: none;
        }

        .centeredImg {
            position: absolute;
            top: 350px;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .Cardnew {
            background-color: #2d2d2d !important;
        }

        .nameAdmin {
            color: #ff0;
            font-weight: 700;
            fontSize: 25px;
            margin-top: 10px;
        }

        .adminAssignPadding {
            background-color: #000000;
        }

        .widgetUserPadding {
            border: 2px solid gray;
            border-radius: 10px;
        }
    </style>
@endsection
