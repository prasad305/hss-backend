@extends('Layouts.SuperAdmin.master')

@push('title')
    Manager Admin
@endpush


@section('content')
    <style>
        .banner-image {
            height: 300px;
            object-fit: cover;
        }
    </style>



    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="card-header">
                <a class="btn btn-success btn-sm" style="float: right;"
                    href="{{ route('superAdmin.learningSession.index') }}"><i class=" fa fa-arrow"></i>&nbsp;Go Back</a>
            </div>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Learning Session</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Learning Session Details</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <div class="content">
        <div class="container-fluid">

            <div class="row">
                @if ($event->banner)
                    <img src="{{ asset($event->banner) }}" style="width: 100%" class="banner-image" />
                @elseif($event->video)
                    <video controls>
                        <source src="{{ asset($event->video) }}" />
                    </video>
                @else
                    <a href="{{ asset('demo_image/banner.jpg') }}" target="_blank">
                        <img src="{{ asset('demo_image/banner.jpg') }}" alt="Demo Image"  style="width: 100%" class="banner-image" />
                    </a>
                @endif
            </div>


            <div class="row py-5">
                <div class="col-md-8 ">
                    <div class="row card p-5">
                        <h3>{{ $event->title }}</h3>
                        <u>Description</u>
                        <p>
                            {!! $event->description !!}
                        </p>
                        <hr>
                        <u>Instruction</u>
                        <p>
                            {!! $event->instruction !!}
                        </p>
                    </div>
                    <div class="row">
                        <div class="col-md-4 card py-3">
                            Date
                            <h4 class="text-danger">{{ \Carbon\Carbon::parse($event->event_date)->format('d F,Y') }}</h4>
                        </div>
                        <div class="col-md-3 card py-3 ml-3">
                            Time
                            <h4 class="text-danger">{{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }} -
                                {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}
                            </h4>
                        </div>
                        <div class="col-md-4 card py-3 ml-3">
                            Registration Date
                            <h4 class="text-danger">
                                {{ \Carbon\Carbon::parse($event->registration_start_date)->format('d
                                                                                                                                                            M,Y') }}
                                - {{ \Carbon\Carbon::parse($event->registration_end_date)->format('d M,Y') }}</h4>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-4 card py-3">
                            Participant
                            <h4 class="text-danger">{{ $event->participant_number }}</h4>
                        </div>
                        <div class="col-md-3 card py-3 ml-3">
                            Fee
                            <h4 class="text-danger">{{ $event->fee }}</h4>
                        </div>
                        <div class="col-md-4 card py-3 ml-3">
                            Assignment
                            <h4 class="text-danger">
                                @if ($event->assignment == 0)
                                    Without Assignment
                                @else
                                    With Assignment
                                @endif
                            </h4>
                        </div>

                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card px-5">
                        <div class="row py-3">
                            <div class="col-xs-6 content-center">
                                @if($event->star->image)
                                    <img src="{{ asset($event->star->image) }}"
                                        style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray" />
                                @else
                                    <a href="{{ asset('demo_image/demo_user.png') }}" target="_blank">
                                        <img src="{{ asset('demo_image/demo_user.png') }}" alt="Demo Image" style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray" />
                                    </a>
                                @endif
                            </div>
                            <div class="col-xs-6">
                                Star
                                <h3>{{ $event->star->first_name }} {{ $event->star->last_name }}</h3>
                            </div>
                        </div>
                        @if ($event->admin)
                            <div class="row py-3">
                                <div class="col-xs-6 content-center">
                                    @if($event->admin->image)
                                        <img src="{{ asset($event->admin->image) }}"
                                            style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray" />
                                    @else
                                        <a href="{{ asset('demo_image/demo_user.png') }}" target="_blank">
                                            <img src="{{ asset('demo_image/demo_user.png') }}" alt="Demo Image" style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray" />
                                        </a>
                                    @endif
                                </div>

                                <div class="col-xs-6">
                                    Admin
                                    <h3>{{ $event->admin->first_name }} {{ $event->admin->last_name }}</h3>
                                </div>

                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
