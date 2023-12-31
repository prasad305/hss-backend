@extends('Layouts.SuperAdmin.master')

@push('title')
    Super Admin
@endpush


@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Q&A Event</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Q&A Event Details</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <div class="content">
        <div class="container-fluid">
            <div class="card-header">
                <a class="btn btn-success btn-sm" style="float: right;" href="{{ route('superAdmin.qna.index') }}"><i
                        class=" fa fa-arrow"></i>&nbsp;Go Back</a>
            </div>
            <div class="row">
                <div class="col-md-6">
                    @if($event->banner)
                    <img src="{{ asset($event->banner) }}" style="width: 100%" />
                    @else
                        <a href="{{ asset('demo_image/banner.jpg') }}" target="_blank">
                            <img src="{{ asset('demo_image/banner.jpg') }}" alt="Demo Image" style="width: 100%" />
                        </a>
                    @endif
                </div>
            </div>


            <div class="row pt-5">

                <div class="col-md-8 ">
                    <div class="row card p-5">
                        <h3>{{ $event->title }}</h3>

                        <h4><u>Description</u></h4>
                        {!! $event->description !!}

                        <h4><u>Instruction</u></h4>
                        {!! $event->instruction !!}
                    </div>
                    <div class="row">
                        <div class="col-md-6 card py-3">
                            Event Date
                            <h4 class="text-warning">{{ \Carbon\Carbon::parse($event->event_date)->format('d F,Y') }}
                            </h4>
                        </div>
                        <div class="col-md-6 card py-3">
                            Event Time
                            <h4 class="text-warning">{{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }} -
                                {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card px-5 py-4">
                        <div class="row">
                            <div class="col-xs-6 content-center mr-2">
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
                        <div class="row">
                            <div class="col-xs-6 content-center mr-2">
                                @if($event->admin->image)
                                <img src="{{ asset($event->admin->image) }}" class="user_image"
                                    style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray"
                                    alt="Image not found" />
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
                    </div>

                    <div class="card px-5 py-3">
                        <h5>Registration: </h5>
                        <hr>
                        <div class="row">
                            <div class="col-4">Registration Start:</div>
                            <div class="col-8 text-warning">
                                {{ \Carbon\Carbon::parse($event->registration_start_date)->format('d F,Y') }}</div>
                        </div>
                        <div class="row">
                            <div class="col-4">Registration End:</div>
                            <div class="col-8 text-warning">
                                {{ \Carbon\Carbon::parse($event->registration_end_date)->format('d F,Y') }}</div>
                        </div>
                        <div class="row">
                            <div class="col-4">Maximum Time:</div>
                            <div class="col-8 text-warning">{{ $event->max_time }} Minute(s)</div>
                        </div>
                        <div class="row">
                            <div class="col-4">Minimum Time:</div>
                            <div class="col-8 text-warning">{{ $event->min_time }} Minute(s)</div>
                        </div>
                        <div class="row">
                            <div class="col-4">Interval:</div>
                            <div class="col-8 text-warning">{{ $event->interval }} Minute(s)</div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
