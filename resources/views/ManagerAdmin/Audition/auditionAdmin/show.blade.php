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
                                                        <label>Select Juries</label>
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
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-2">
                                                        <label>Select Judges</label>
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

    </style>
@endsection


@push('js')
    <script>
        function setEndDate() {
            var start_date = document.getElementById('start_date').value;
            var month = '{{ $auditionRule->month ?? 0 }}';
            var day = '{{ $auditionRule->day ?? 0 }}';
            var total_day = (parseInt(month*30)) + parseInt(day) ;

            var end_date = new Date(start_date);
            end_date.setDate(end_date.getDate() + total_day);

            var final_date  = parseInt(parseInt(end_date.getMonth()) + 1)+'/'+end_date.getDate()+'/'+end_date.getFullYear()
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
