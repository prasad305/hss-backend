@extends('Layouts.ManagerAdmin.master')

@push('title')
    Audition Admin
@endpush

@push('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/manager-admin/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/manager-admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/manager-admin/dist/css/adminlte.min.css') }}">
@endpush

@section('content')
    <div>
        <div class="content text-center px-5 adminAssignPadding">
            <div class="container-fluid widgetUserPadding">
                <div class=" card-widget widget-user paddingWidget">
                    <div class=" text-white AdminCover"
                        style="background-image: url({{ asset($auditionAdmin->cover_photo ?? get_static_option('no_image')) }})">
                        <div class="centeredImg">
                            <img class="img-circle ImGAdmin"
                                src="{{ asset($auditionAdmin->image ?? get_static_option('no_image')) }}"
                                alt="User Avatar">
                            <h4 class="text-center nameAdmin">
                                {{ $auditionAdmin->first_name . ' ' . $auditionAdmin->last_name }}</h4>
                            <span
                                class=" text-center fw-bold text-warning"><b>{{ $auditionAdmin->category->name ?? '' }}</b></span>
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
                                @if ($auditionAdmin->assignedAudition)
                                    <div class="card-body">
                                        <div class="container">
                                            <h2 class="auditionTitle">{{ $auditionAdmin->assignedAudition->title ?? '' }}
                                            </h2> <br>
                                            <p class="auditionDescription">
                                                {{ $auditionAdmin->assignedAudition->description ?? '' }}</p>
                                            <div class="bannerDiv">
                                                <img class="bannerImage" width="100%" height="350px;"
                                                    src="{{ asset($auditionAdmin->assignedAudition->banner ?? get_static_option('no_image')) }}"
                                                    alt="Banner">
                                            </div>
                                            <div class="videoDiv">
                                                <video class="bannerVideo" width="100%" height="350px;" controls>
                                                    <source
                                                        src="{{ url($auditionAdmin->assignedAudition->video ?? 'http://www.youtube.com/watch?v=nOEw9iiopwI') }}"
                                                        type="video/mp4">
                                                </video>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="card card-row card-primary">
                                                        <div class="card-header">
                                                            <h3 class="card-title">
                                                                Jury panel
                                                            </h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="card card-primary card-outline">
                                                                @foreach ($auditionAdmin->assignedAudition->assignedJuries as $assignedJury)
                                                                    <div class="card-header d-flex justify-content-between">
                                                                        <img height="50px;" width="50px;" src="{{ asset($assignedJury->user->image ?? get_static_option('no_image')) }}" alt="Jury">

                                                                        <p class="card-title">{{ $assignedJury->user ? $assignedJury->user->first_name : '' }} {{ $assignedJury->user ? $assignedJury->user->last_name : '' }}</p>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card card-row card-primary">
                                                        <div class="card-header">
                                                            <h3 class="card-title">
                                                                Jugde panel
                                                            </h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="card card-primary card-outline">
                                                                @foreach ($auditionAdmin->assignedAudition->assignedJudges as $assignedJudge)
                                                                    <div class="card-header d-flex justify-content-between">
                                                                        <img height="50px;" width="50px;" src="{{ asset($assignedJudge->user->image ?? get_static_option('no_image')) }}" alt="judge">

                                                                        <p class="card-title">{{ $assignedJudge->user->first_name ?? '' }} {{ $assignedJudge->user->last_name ?? '' }}</p>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="card-body">
                                        <p class="card-text">
                                            Sorry This audition admin doesn't assigned to any audition.
                                        </p>
                                    </div>
                                @endif
                            </div>
                            <div id="Assign" class=" tab-pane fade">
                                <div class="card my-4">
                                    @if ($auditionAdmin->assignedAudition)
                                        <div class="card-body">
                                            <p class="card-text">
                                                Sorry This audition admin already assigned to an audition.
                                            </p>
                                        </div>
                                    @else
                                        <form action="{{ route('managerAdmin.audition.store') }}" method="POST">
                                            @csrf
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <div class="col-2">
                                                        <label>Admin Name</label>
                                                    </div>
                                                    <div class="col-10">
                                                        <input type="hidden" name="audition_admin_id"
                                                            value="{{ $auditionAdmin->id }}">
                                                        <input type="hidden" name="audition_rule_id"
                                                            value="{{ $auditionRule->id ?? '' }}">
                                                        <input type="text" name="admin_name" class="form-control" readonly
                                                            value="{{ $auditionAdmin->first_name . ' ' . $auditionAdmin->last_name }}">
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
                                                        <label>Select Jury By Group</label> <br>
                                                    </div>


                                                    @foreach ($groups  as $key => $group)
                                                            <div class="col-3">
                                                                <input type="hidden" name="group_ids[]" value="{{ $group->id }}">
                                                                <label for="">Group {{$group->name}} <span class="text-danger">You have to select
                                                                    {{ $group_data[$key]}} jury !</span></label>
                                                                <select name="jury[{{$key}}][]" class="select2" multiple="multiple"
                                                                    style="width: 100%;">
                                                                    @foreach ($juries as $jury)
                                                                        @if ($jury->jury->group_id == $group->id)
                                                                            <option value="{{ $jury->id }}">
                                                                                {{ $jury->first_name . ' ' . $jury->last_name }}
                                                                            </option>
                                                                        @endif
                                                                        
                                                                    @endforeach
                                                                </select>
                                                                @error('jury')
                                                                    <p class="text-danger">{{ $message }}</p>
                                                                @enderror
                                                            </div>
                                                    @endforeach

                                                   

                                                </div>

                                                {{-- <div class="form-group row">
                                                    <div class="col-2">
                                                        <label>Select Juries</label> <br>
                                                        <span class="text-danger">You have to select
                                                            {{ $auditionRule->jury_num ?? '' }} jury !</span>
                                                    </div>
                                                    <div class="col-10">
                                                        <select name="jury[]" class="select2" multiple="multiple"
                                                            style="width: 100%;">
                                                            @foreach ($juries as $jury)
                                                                <option value="{{ $jury->id }}">
                                                                    {{ $jury->first_name . ' ' . $jury->last_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('jury')
                                                            <p class="text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div> --}}


                                                <div class="form-group row">
                                                    <div class="col-2">
                                                        <label>Select Judges</label> <br>
                                                        <span class="text-danger">You have to select
                                                            {{ $auditionRule->judge_num ?? '' }} judge !</span>
                                                    </div>
                                                    <div class="col-10">
                                                        <select name="judge[]" class="select2" multiple="multiple"
                                                            style="width: 100%;">
                                                            @foreach ($judges as $judge)
                                                                <option value="{{ $judge->id }}">
                                                                    {{ $judge->first_name . ' ' . $judge->last_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('judge')
                                                            <p class="text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-2">
                                                        <label>Event Start</label>
                                                    </div>
                                                    <div class="col-4">
                                                        <input type="date" onchange="setEndDate()" name="start_date"
                                                            id="start_date" class="form-control">
                                                        @error('start_date')
                                                            <p class="text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    <div class="col-2">
                                                        <label>Event End</label>
                                                    </div>
                                                    <div class="col-4">
                                                        <input type="text" readonly name="end_date" id="end_date"
                                                            class="form-control">
                                                        @error('end_date')
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

        .auditionTitle {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 600;
            font-size: 32px;
            line-height: 48px;
            color: #3A8FF2;
            text-align: left;
        }

        .auditionDescription {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 500;
            font-size: 20px;
            line-height: 30px;
            color: #D2C3C3;
            text-align: left;
        }

        .bannerImage {
            border: 2px solid gold;
            border-radius: 20px;
        }

        .videoDiv {
            margin: 20px 0;
        }

        .bannerVideo {
            border: 2px solid gold;
            border-radius: 20px;
        }

    </style>
@endsection


@push('js')
    <script>
        function setEndDate() {
            var start_date = document.getElementById('start_date').value;
            var month = '{{ $auditionRule->month ?? 0 }}';
            var day = '{{ $auditionRule->day ?? 0 }}';
            var total_day = (parseInt(month * 30)) + parseInt(day);

            var end_date = new Date(start_date);
            end_date.setDate(end_date.getDate() + total_day);

            var final_date = parseInt(parseInt(end_date.getMonth()) + 1) + '/' + end_date.getDate() + '/' + end_date
                .getFullYear()
            document.getElementById('end_date').value = final_date;
        }
    </script>
    <!-- Select2 -->
    <script src="{{ asset('assets/manager-admin/plugins/select2/js/select2.full.min.js') }}"></script>


    <script>
        //Initialize Select2 Elements
        $('.select2').select2();

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });
    </script>
@endpush
