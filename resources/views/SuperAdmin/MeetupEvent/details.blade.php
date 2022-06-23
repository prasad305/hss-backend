@extends('Layouts.SuperAdmin.master')

@push('title')
    Super Admin
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
                <a class="btn btn-success btn-sm" style="float: right;" href="{{ route('superAdmin.meetupEvent.index') }}"><i
                        class=" fa fa-arrow"></i>&nbsp;Go Back</a>
            </div>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Meetup Events</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Meetup Event Details</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <img src="{{ asset($meetup->banner) }}" style="width: 100%" class="banner-image" />
                </div>

            </div>


            <div class="row py-5">

                <div class="col-md-8 ">
                    <div class="row card p-5">
                        <h3>{{ $meetup->title }}</h3>

                        <h6><u>Description:</u></h6>
                        <p>
                            {!! $meetup->description !!}
                        </p>

                        <h6><u>Instruction:</u></h6>
                        <p>
                            {!! $meetup->instruction !!}
                        </p>

                    </div>
                    <div class="row">
                        <div class="col-md-6 card py-3">
                            Date
                            <h4 class="text-warning">{{ \Carbon\Carbon::parse($meetup->event_date)->format('d F,Y') }}
                            </h4>
                        </div>
                        <div class="col-md-6 card py-3">
                            Time
                            <h4 class="text-warning">{{ \Carbon\Carbon::parse($meetup->start_time)->format('h:i A') }} -
                                {{ \Carbon\Carbon::parse($meetup->end_time)->format('h:i A') }}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card px-5">
                        <div class="row py-3">
                            <div class="col-xs-6 content-center">
                                <img src="{{ asset($meetup->star->image) }}"
                                    style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray" />
                            </div>
                            <div class="col-xs-6">
                                Star
                                <h3>{{ $meetup->star->first_name }} {{ $meetup->star->last_name }}</h3>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-6 content-center mr-2">
                                <img src="{{ asset($meetup->admin->image) }}" class="user_image"
                                    style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray"
                                    alt="Image not found"
                                    onerror="this.onerror=null;this.src='{{ asset('demo_image/demo_user.png') }}';" />
                            </div>
                            <div class="col-xs-6">
                                Admin
                                <h3>{{ $meetup->admin->first_name }} {{ $meetup->admin->last_name }}</h3>
                            </div>
                        </div>

                    </div>

                    <div class="card px-5 py-3">
                        <h5>Registration: </h5>
                        <hr>
                        <div class="row">
                            <div class="col-4">Registration Start:</div>
                            <div class="col-8 text-warning">
                                {{ \Carbon\Carbon::parse($meetup->reg_start_date)->format('d F,Y') }}</div>
                        </div>
                        <div class="row">
                            <div class="col-4">Registration End:</div>
                            <div class="col-8 text-warning">
                                {{ \Carbon\Carbon::parse($meetup->reg_end_date)->format('d F,Y') }}</div>
                        </div>
                        <div class="row">
                            <div class="col-4">Type:</div>
                            <div class="col-8 text-warning">{{ $meetup->meetup_type }}</div>
                        </div>

                        @if ($meetup->meetup_type == 'Offline')
                            <div class="row">
                                <div class="col-4">Venue:</div>
                                <div class="col-8 text-warning">{{ $meetup->venue }}</div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
