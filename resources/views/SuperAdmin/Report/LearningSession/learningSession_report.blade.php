@extends('Layouts.SuperAdmin.master')

@push('title')
    Super Admin
@endpush

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Report</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Report</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <form action="{{route('superAdmin.report.filter.learningSession')}}" method="post">

        @csrf
        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-3 col-md-3">
                        <label for="category">Start Date</label>
                        <div class="form-group mb-4">
                            <div class="datepicker date input-group">
                                <input type="text" name="start_date" placeholder="Choose Date" class="form-control"
                                    id="fecha1">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3">
                        <label for="category">End Date</label>
                        <div class="form-group mb-4">
                            <div class="datepicker date input-group">
                                <input type="text" name="end_date" placeholder="Choose Date" class="form-control"
                                    id="fecha1">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3">

                        {{-- <div class="form-group mb-4">

                        <label for="category">Categories</label>
                        <select name="category" class="custom-select rounded-0" id="category">
                            <option selected="" disabled="">Select Category</option>
                            <select name="category_id" id="category_id" class="form-control select2">
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>

                        </select>

                    </div> --}}
                        <div class="form-group">
                            <label for="name">Categories</label>
                            <select name="category_id" id="category_id" name="category_name" class="form-control select2">
                                <option selected="" disabled="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- <div class="col-lg-3 col-md-3">

                    <div class="form-group mb-4">

                        <label for="category">Select Module</label>
                        <select name="category" class="custom-select rounded-0" id="category">
                            <option selected="" disabled="">Select Module</option>
                            <option value="13">Simple Post</option>
                            <option value="12">Live Chat</option>
                            <option value="11">Greeting</option>
                            <option value="10">Learning Session</option>
                            <option value="9">Meetup Event</option>
                            <option value="8">Audition</option>
                            <option value="7">Q&A</option>
                            <option value="6">Auction</option>
                            <option value="5">Marketplace</option>
                            <option value="4">Souvenir</option>
                            <option value="3">Fan Group</option>
                        </select>

                    </div>
                </div> --}}
                </div>
                <div class="mb-5">

                    <button type="submit" class="btn btn-lm btn-success">Get Report</button>
                </div>
            </div>
        </section>
    </form>
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $assignment_fee }}</h3>
                            <p>Total Certificate Fee</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $registration_fee }}<sup style="font-size: 20px"></sup></h3>
                            <p>Total Registration Fee</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                {{-- <div class="col-lg-3 col-6">

                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3>44</h3>
                            <p>Total Certificate Fee</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div> --}}

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $certificate }}</h3>
                            <p>Total Certificate</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $assignment }}</h3>
                            <p>Total Assignment</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>150</h3>
                            <p>New Orders</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>53<sup style="font-size: 20px">%</sup></h3>
                            <p>Bounce Rate</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>44</h3>
                            <p>User Registrations</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>65</h3>
                            <p>Unique Visitors</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
@endsection
@push('css')
    <!-- datepicker styles -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css">
@endpush

@push('js')
    <script>
        $(function() {
            $('.datepicker').datepicker({
                language: "es",
                autoclose: true,
                format: "yyyy/mm/dd"
            });
        });
    </script>
    <!-- Datepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
@endpush
