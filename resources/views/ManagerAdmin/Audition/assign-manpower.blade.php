@extends('Layouts.ManagerAdmin.master')

@push('title')
    Audition Create
@endpush
@push('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/manager-admin/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/manager-admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/manager-admin/dist/css/adminlte.min.css') }}">
@endpush
@section('content')
    <style>
        .completedMeetupBlack {
            background-color: #151515 !important;
            border-radius: 10px;
        }

        .BGa {
            border: 1px solid rgb(255, 217, 0);
        }

        .BGaB {
            border: 1px solid rgb(0, 204, 255);
        }

        .GoldBtn {
            background: linear-gradient(90deg, #FFCE00 0%, #DFA434 100%) !important;
            border-radius: 25px;
        }

        .GoldBtn:hover {
            background: rgb(16, 20, 29) !important;
            color: white;
            border: 1px solid #FFCE00 !important;
        }

        .BlueBtn {
            background: linear-gradient(90deg, #22AADD 0%, #3A8FF2 100%);
            border-radius: 25px;
        }

        .BlueBtn:hover {
            background: rgb(16, 20, 29) !important;
            color: white;
            border: 1px solid rgb(0, 183, 255) !important;
        }

        .bottomBlackLine {
            border-bottom: 2px solid white;
        }

        .displaySide {
            display: flex;
            justify-content: center
        }

        .fontBold {
            font-size: 40px;
            font-weight: 800;
        }
    </style>

    <!-- Content Header (Page header) -->
    <div class="content-header BorderRpo">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-sm-6">
                    <h1 class="m-0">Assign Manpower</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        {{-- <a href="{{ route('superAdmin.events.edit',1) }}"> <li class="breadcrumb-item active">Events
                        List</li></a> --}}
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"> Assign Manpower</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    @include('ManagerAdmin.Audition.includes.audition-sub-nav')

    <div class="container">
        <form action="{{ route('managerAdmin.audition.assignManpowerStore') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-2">
                        <label>Select Audition Admin</label> <br>
                    </div>
                    <div class="col-10">
                        <input type="hidden" name="audition_rule_id" value="{{ $auditionRule->id ?? '' }}">
                        <input type="hidden" name="audition_id" value="{{ $audition->id ?? '' }}">
                        <select name="audition_admin" class="form-control" style="width: 100%;">

                            @foreach ($auditionAdmins as $auditionAdmin)
                                <option value="{{ $auditionAdmin->id }}">
                                    {{ $auditionAdmin->first_name . ' ' . $auditionAdmin->last_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('audition_admin')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-2">
                        <label>Select Jury By Group</label> <br>
                    </div>
                    @foreach ($groups as $key => $group)
                        <div class="col-3">
                            <input type="hidden" name="group_ids[]" value="{{ $group->id }}">
                            <label for="">Group {{ $group->name }} <span class="text-danger">You have to select {{ $group_data[$key] }} jury !</span></label>
                            <select name="jury[{{ $key }}][]" class="select2" multiple="multiple"
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
                <div class="form-group row">
                    <div class="col-2">
                        <label>Select Judges</label> <br>
                        <span class="text-danger">You have to select
                            {{ $auditionRule->judge_num ?? '' }} judge !</span>
                    </div>
                    <div class="col-10">
                        <select name="judge[]" class="select2" multiple="multiple" style="width: 100%;">
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
                <div class=" float-right">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
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
            var date = document.getElementById('start_date').value;
            var number = '{{ $auditionRule->event_period ?? 0 }}';
            const newDate = new Date(date);

            var end_date = new Date(newDate.setDate(newDate.getDate() + parseInt(number)));

            let day, month, year;

            day = end_date.getDate();
            month = end_date.getMonth() + 1;
            year = end_date.getFullYear();

            var final_date = month + '/' + day + '/' + year;


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
