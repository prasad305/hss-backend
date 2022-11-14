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
                <a class="btn btn-success btn-sm" style="float: right;"
                    href="{{ route('superAdmin.auditionEvents.dashboard') }}"><i class=" fa fa-arrow"></i>&nbsp;Go Back</a>
            </div>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Audition Events</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Audition Event Details</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-6">

                    @if ($audition->banner)
                        <img src="{{ asset($audition->banner) }}" style="width: 100%" class="banner-image" />
                    @else
                        <a href="{{ asset('demo_image/banner.jpg') }}">
                            <img src="{{ asset('demo_image/banner.jpg') }}" alt="Demo Image" style="width: 100%"
                                class="banner-image" />
                        </a>
                    @endif

                </div>
                <div class="col-md-6">
                    @if ($audition->video)
                        <video class="img-fluid card-img-details" style="width: 80%" controls
                            src="{{ asset($audition->video) }}"></video>
                    @else
                        <a href="{{ asset('demo_image/banner.jpg') }}">
                            <img src="{{ asset('demo_image/banner.jpg') }}" alt="Demo Image" style="width: 100%"
                                class="banner-image" />
                        </a>
                    @endif
                </div>



            </div>


            <div class="row py-5">

                <div class="col-md-12">
                    <div class="row card p-5">
                        <h3>{{ $audition->title }}</h3>

                        <h6>Description:</h6>
                        <p>
                            {!! $audition->description !!}
                        </p>

                        <h6>Instruction:</h6>
                        <p>
                            {!! $audition->instruction !!}
                        </p>

                    </div>
                    <div class="row">
                        <div class="col-md-2 card py-3 mr-3">
                            Registration Start Date
                            <h4 class="text-warning">
                                {{ \Carbon\Carbon::parse($audition->user_reg_start_date)->format('d F,Y') }}
                            </h4>
                        </div>
                        <div class="col-md-2 card py-3 mr-3">
                            Registration End Date
                            <h4 class="text-warning">
                                {{ \Carbon\Carbon::parse($audition->user_reg_end_date)->format('d F,Y') }}
                                {{-- {{ \Carbon\Carbon::parse($meetup->end_time)->format('h:i A') }}</h4> --}}
                        </div>
                        <div class="col-md-2 card py-3 mr-3">
                            Event Start Date
                            <h4 class="text-warning">
                                {{ \Carbon\Carbon::parse($audition->start_date)->format('d F,Y') }}
                            </h4>
                        </div>
                        <div class="col-md-2 card py-3 mr-3">
                            Event End Date
                            <h4 class="text-warning">
                                {{ \Carbon\Carbon::parse($audition->end_date)->format('d F,Y') }}
                                {{-- {{ \Carbon\Carbon::parse($meetup->end_time)->format('h:i A') }}</h4> --}}
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-md-2 card py-3 mr-3">
                            Fee
                            <h4 class="text-warning">
                                {{ $audition->fees }}
                            </h4>
                        </div>
                        <div class="col-md-2 card py-3 mr-3">
                            Total Round
                            <h4 class="text-warning">
                                {{ $audition->auditionRound->count() }}
                            </h4>
                        </div>
                        <div class="col-md-2 card py-3 mr-3">
                            Active Round
                            <h4 class="text-warning">
                                {{ $audition->activeRoundInfo->round_num }}
                            </h4>
                        </div>
                        <div class="col-md-2 card py-3 mr-3">
                            Total Participant
                            <h4 class="text-warning">
                                00
                            </h4>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-2 card py-3 mr-3">
                            Total Uploaded Video:
                            <h4 class="text-warning">
                                {{ $audition->uploadedVideos->count() }}
                            </h4>
                        </div>
                        <div class="col-md-2 card py-3 mr-3">
                            Total Judge
                            <h4 class="text-warning">
                                {{ $audition->assignedJudges->count() }}
                            </h4>
                        </div>
                        <div class="col-md-2 card py-3 mr-3">
                            Total Admin
                            <h4 class="text-warning">
                                {{ $audition->admin->count() }}
                            </h4>
                        </div>
                        <div class="col-md-2 card py-3 mr-3">
                            Total Juries
                            <h4 class="text-warning">
                                {{ $audition->assignedJuries->count() }}
                            </h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            @foreach ($audition->assignedJudges as $judge)
                                @if ($judge->user->image)
                                    <img src="{{ asset($judge->user->image) }}"
                                        style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray" />
                                @else
                                    <a href="{{ asset('demo_image/demo_user.png') }}">
                                        <img src="{{ asset('demo_image/demo_user.png') }}" alt="Demo Image"
                                            style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray" />
                                    </a>
                                @endif



                                <h3>{{ $judge->user->first_name }} {{ $judge->user->last_name }}</h3>
                            @endforeach
                        </div>

                        <div class="col-md-6">
                            @foreach ($audition->admin as $admin)
                                @if ($admin->user->image)
                                    <img src="{{ asset($admin->user->image) }}"
                                        style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray" />
                                @else
                                    <a href="{{ asset('demo_image/demo_user.png') }}">
                                        <img src="{{ asset('demo_image/demo_user.png') }}" alt="Demo Image"
                                            style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray" />
                                    </a>
                                @endif



                                <h3>{{ $admin->user->first_name }} {{ $admin->user->last_name }}</h3>
                            @endforeach
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            @foreach ($audition->assignedJuries as $jury)
                                @if ($jury->user->image)
                                    <img src="{{ asset($jury->user->image) }}"
                                        style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray" />
                                @else
                                    <a href="{{ asset('demo_image/demo_user.png') }}">
                                        <img src="{{ asset('demo_image/demo_user.png') }}" alt="Demo Image"
                                            style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray" />
                                    </a>
                                @endif



                                <h3>{{ $jury->user->first_name }} {{ $jury->user->last_name }}</h3>
                            @endforeach
                        </div>
                        <div class="col-md-6">

                            @if ($audition->auditionAdmin->image)
                                <img src="{{ asset($audition->auditionAdmin->image) }}"
                                    style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray" />
                            @else
                                <a href="{{ asset('demo_image/demo_user.png') }}">
                                    <img src="{{ asset('demo_image/demo_user.png') }}" alt="Demo Image"
                                        style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray" />
                                </a>
                            @endif



                            <h3>{{ $audition->auditionAdmin->first_name }}
                                {{ $audition->auditionAdmin->last_name }}</h3>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
