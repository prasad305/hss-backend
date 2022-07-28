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
    

    </style>

    <!-- Content Header (Page header) -->
    <div class="content-header BorderRpo">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-sm-6">
                    <h1 class="m-0">Create</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        {{-- <a href="{{ route('superAdmin.events.edit',1) }}"> <li class="breadcrumb-item active">Events
                        List</li></a> --}}
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"> Create</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    @include('ManagerAdmin.Audition.includes.audition-sub-nav')



    <div class="row">
        <div class="col-md-12">
            <div class="row bg-black-custom">
                <h4 class="mx-3">Create Audition</h4>
                <a class="btn btn-success btn-sm mr-4 " style="margin-bottom: 10px; margin-left: auto;"
                    href="{{ route('managerAdmin.audition.events') }}">
                    <i class=" fa fa-list"></i>&nbsp;Audition list
                </a>
            </div>
        </div>
    </div>

    <div class="container my-4">
        <div class="p-5 bg-gray-custom ">
                <form action="{{ route('managerAdmin.audition.store') }}" method="POST">
                    @csrf

                    <div class="form-group row">
                        <div class="col-2">
                            <label class="text-warning">Title</label>
                        </div>
                        <div class="col-10">
                            <input type="hidden" name="audition_rule_id" class="form-control from-custom-i" value="{{ $auditionRule->id ?? '' }}">
                            <input name="title" class="form-control from-custom-i" rows="3" value="{{ old('title') }}" />
                            @error('title')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-2">
                            <label class="text-warning">Description</label>
                        </div>
                        <div class="col-10 ">
                            <textarea name="description" class=" bg-warning from-custom-i" id="summernote" rows="6"> {{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-2">
                        </div>
                        <div class="col-10 bh-bg-card p-3">
                            The audition will have to complete within {{ $auditionRule->event_period ?? 0 }} day(s)
                        </div>
                        <hr>
                    </div>

                    <div class="row justify-content-between">
                        <div class="col-md-5 d-flex">
                            <div class="col-md-4">
                                <label class="text-warning">Event Start</label>
                            </div>
                            <div class="col-md-8">
                                <input type="date" onchange="setEndDate()" min='{{date('Y-m-d')}}' name="start_date" id="start_date"
                                    class="custom-control-i form-control">
                                @error('start_date')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-5 d-flex">
                            <div class="col-md-4">
                                <label class="text-warning">Event End</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" readonly name="end_date" id="end_date" class="custom-control-i form-control">
                                @error('end_date')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="form-group row mt-5">
                        <div class="col-2">

                        </div>
                        <div class="col-md-8 d-flex justify-content-center">
                            <button type="submit" class="btn text-bold btn-warning-custom px-5">Submit</button>
                        </div>

                    </div>



                </form>


        </div>
    </div>

    {{-- <div class="container">
        <form action="{{ route('managerAdmin.audition.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-2">
                        <label class="text-warning">Title</label>
                    </div>
                    <div class="col-10">
                        <input name="audition_rule_id" value="{{ $auditionRule->id ?? '' }}">
                        <textarea name="title" class="form-control" rows="3">{{ old('title') }}</textarea>
                        @error('title')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-2">
                        <label class="text-warning">Description</label>
                    </div>
                    <div class="col-10">
                        <textarea name="description" class="form-control" rows="6"> {{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>


                <div class="form-group row">
                    <div class="col-2">
                    </div>
                    <div class="col-10">
                        <h6 class="text-warning">The audition will have to complete within
                            {{ $auditionRule->event_period ?? 0 }} day(s)</h6>
                    </div>
                    <hr>
                </div>


                <div class="form-group row">
                    <div class="col-2">
                        <label class="text-warning">Event Start</label>
                    </div>
                    <div class="col-4">
                        <input type="date" onchange="setEndDate()" min='{{date('Y-m-d')}}' name="start_date" id="start_date"
                            class="form-control">
                        @error('start_date')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-2">
                        <label class="text-warning">Event End</label>
                    </div>
                    <div class="col-4">
                        <input type="text" readonly name="end_date" id="end_date" class="form-control">
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
    </div> --}}
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

<script>
    $('#summernote').summernote({
height: 300,
focus: true
});

</script>
@endpush
