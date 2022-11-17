@extends('Layouts.SuperAdmin.master')

@push('title')
    Super Admin
@endpush


@section('content')
    <style>
        .btn-act {
            /* border: none; */
            outline: none;
            /* padding: 10px 16px; */
            width: 100%;
            border: 1px solid #ff0;
            color: #ffce00;
            font-weight: bold;
            background-color: #454d55;
            cursor: pointer;
            /* font-size: 18px; */
        }

        /* Style the active class, and buttons on mouse-over */
        .TextBH .active,
        .btn-act:hover {
            background-color: #ffce00;
            color: #000;
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


    <div class="content mb-5">
        <div class="container-fluid mb-5">
            <div class="row">

                <div class="row ">

                    <div class="col-md-6 mb-1">
                        <div class="card p-2">
                            @if ($audition->banner)
                                <img src="{{ asset($audition->banner) }}" style="width: 100%;max-height:400px"
                                    class="img-fulid" />
                            @else
                                <a href="{{ asset('demo_image/banner.jpg') }}">
                                    <img src="{{ asset('demo_image/banner.jpg') }}" alt="Demo Image"
                                        style="width: 100%;max-height:400px" class="img-fulid" />
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6 mb-1">
                        <div class="card p-2">
                            @if ($audition->video)
                                <video class="img-fluid card-img-details" style="width: 100%;max-height:400px" controls
                                    src="{{ asset($audition->video) }}"></video>
                            @else
                                <a href="{{ asset('demo_image/banner.jpg') }}">
                                    <img src="{{ asset('demo_image/banner.jpg') }}" alt="Demo Image"
                                        style="width: 100%;max-height:400px" class="img-fulid" />
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-12 card p-3">
                        <h3>{{ $audition->title }}</h3>
                        <h4 class="text-warning font-bold under-line pb-1">
                            Description :
                        </h4>
                        <span class="font-bold">
                            {!! $audition->description !!}
                        </span>
                        <h4 class="text-warning font-bold under-line pb-1">
                            Instruction :
                        </h4>
                        <span class="font-bold">
                            {!! $audition->instruction !!}
                        </span>

                    </div>

                </div>

                <div class="row">

                    <div class="col-md-3 col-lg-2 mb-2">
                        <div class="card p-2">
                            <span class="font-bold">Registration Start Date</span>
                            <h5 class="text-warning">
                                {{ \Carbon\Carbon::parse($audition->user_reg_start_date)->format('d F,Y') }}
                            </h5>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-2 mb-2">
                        <div class="card p-2">
                            <span class="font-bold">Registration End Date</span>
                            <h5 class="text-warning">
                                {{ \Carbon\Carbon::parse($audition->user_reg_end_date)->format('d F,Y') }}
                            </h5>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-2 mb-2">
                        <div class="card p-2">
                            <span class="font-bold">Event Start Date</span>
                            <h5 class="text-warning">
                                {{ \Carbon\Carbon::parse($audition->start_date)->format('d F,Y') }}
                            </h5>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-2 mb-2">
                        <div class="card p-2">
                            <span class="font-bold"> Event End Date</span>
                            <h5 class="text-warning">
                                {{ \Carbon\Carbon::parse($audition->end_date)->format('d F,Y') }}
                            </h5>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-2 mb-2">
                        <div class="card p-2">
                            <span class="font-bold"> Fee</span>
                            <h5 class="text-warning">
                                {{ $audition->fees }}
                            </h5>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-2 mb-2">
                        <div class="card p-2">
                            <span class="font-bold"> Total Round</span>
                            <h5 class="text-warning">
                                {{ $audition->auditionRound->count() }}
                            </h5>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-2 mb-2">
                        <div class="card p-2">
                            <span class="font-bold"> Active Round</span>
                            <h5 class="text-warning">
                                {{ $audition->activeRoundInfo->round_num }}
                            </h5>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-2 mb-2">
                        <div class="card p-2">
                            <span class="font-bold"> Total Participant</span>
                            <h5 class="text-warning">
                                {{ $audition->auditionParticipant->count() }}
                            </h5>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-2 mb-2">
                        <div class="card p-2">
                            <span class="font-bold"> Total Uploaded Video</span>
                            <h5 class="text-warning">
                                {{ $audition->uploadedVideos->count() }}
                            </h5>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-2 mb-2">
                        <div class="card p-2">
                            <span class="font-bold"> Total Judge</span>
                            <h5 class="text-warning">
                                {{ $audition->assignedJudges->count() }}
                            </h5>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-2 mb-2">
                        <div class="card p-2">
                            <span class="font-bold"> Total Admin</span>
                            <h5 class="text-warning">
                                {{ $audition->admin->count() }}
                            </h5>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-2 mb-2">
                        <div class="card p-2">
                            <span class="font-bold">Total Juries</span>
                            <h5 class="text-warning">
                                {{ $audition->assignedJuries->count() }}
                            </h5>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-6 col-lg-3 mb-2 ">
                        <div class="card px-2 pt-1">
                            <h4 class="under-line py-1">Judge Panel</h4>
                            <div class="row">
                                @foreach ($audition->assignedJudges as $judge)
                                    <div class="col-md-12">
                                        <div class="card p-2">
                                            <div class="d-flex align-content-center align-items-center">
                                                <div class="pr-2">
                                                    @if ($judge->user->image)
                                                        <img src="{{ asset($judge->user->image) }}" class="star-judge" />
                                                    @else
                                                        <a href="{{ asset('demo_image/demo_user.png') }}">
                                                            <img src="{{ asset('demo_image/demo_user.png') }}"
                                                                alt="Demo Image" class="star-judge" />
                                                        </a>
                                                    @endif
                                                </div>
                                                <div>
                                                    <span class="font-bold">Super Stars</span>
                                                    <h5 class="text-warning">
                                                        {{ $judge->user->first_name }} {{ $judge->user->last_name }}
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 mb-2 ">
                        <div class="card px-2 pt-1">
                            <h4 class="under-line py-1">Admin Panel</h4>
                            <div class="row">
                                @foreach ($audition->admin as $admin)
                                    <div class="col-md-12">
                                        <div class="card p-2">
                                            <div class="d-flex align-content-center align-items-center">
                                                <div class="pr-2">
                                                    @if ($admin->admin->image)
                                                        <img src="{{ asset($admin->admin->image) }}"
                                                            class="star-judge" />
                                                    @else
                                                        <a href="{{ asset('demo_image/demo_user.png') }}">
                                                            <img src="{{ asset('demo_image/demo_user.png') }}"
                                                                alt="Demo Image" class="star-judge" />
                                                        </a>
                                                    @endif
                                                </div>
                                                <div>
                                                    <span class="font-bold">Admin</span>
                                                    <h5 class="text-warning">
                                                        {{ $admin->admin->first_name }} {{ $admin->admin->last_name }}
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 mb-2 ">
                        <div class="card px-2 pt-1">
                            <h4 class="under-line py-1">Audition Admin</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card p-2">
                                        <div class="d-flex align-content-center align-items-center">
                                            <div class="pr-2">
                                                @if ($audition->auditionAdmin->image)
                                                    <img src="{{ asset($audition->auditionAdmin->image) }}"
                                                        class="star-judge" />
                                                @else
                                                    <a href="{{ asset('demo_image/demo_user.png') }}">
                                                        <img src="{{ asset('demo_image/demo_user.png') }}"
                                                            alt="Demo Image" class="star-judge" />
                                                    </a>
                                                @endif
                                            </div>
                                            <div>
                                                <span class="font-bold">Jury</span>
                                                <h5 class="text-warning">
                                                    {{ $audition->auditionAdmin->first_name }}
                                                    {{ $audition->auditionAdmin->last_name }}
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-12 mb-2 ">
                        <div class="card px-2 pt-1">
                            <h4 class="under-line py-1">Jury Board</h4>
                            <div class="row">
                                @foreach ($audition->assignedJuries as $jury)
                                    <div class="col-md-4 col-lg-3 mb-2">
                                        <div class="card p-2">
                                            <div class="d-flex align-content-center align-items-center">
                                                <div class="pr-2">
                                                    @if ($jury->user->image)
                                                        <img src="{{ asset($jury->user->image) }}" class="star-judge" />
                                                    @else
                                                        <a href="{{ asset('demo_image/demo_user.png') }}">
                                                            <img src="{{ asset('demo_image/demo_user.png') }}"
                                                                alt="Demo Image" class="star-judge" />
                                                        </a>
                                                    @endif
                                                </div>
                                                <div>
                                                    <span class="font-bold">Jury</span>
                                                    <h5 class="text-warning">
                                                        {{ $jury->user->first_name }} {{ $jury->user->last_name }}
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>

                <div class="viewMb">
                    <ul class="nav nav-tabs" role="tablist">

                        @foreach ($audition->auditionRound as $key => $round)
                            <li class=" nav-item custom-nav-item m-2 mt-4 TextBH">
                                <a class="nav-link border-warning text-warning font-weight-bold" data-toggle="tab"
                                    href="" role="tab">
                                    <center class="mb-2">
                                        <h2 class="roundText">Round</h2>
                                        <span class="text-warning roundIndex p-1">{{ $key + 1 }}
                                        </span>
                                    </center>
                                    <a onclick="showData({{ $round->id }})" class="btn border-warning btn-act"
                                        data-toggle="tab" href="" role="tab">Show</a>
                                </a>
                            </li>
                        @endforeach



                    </ul>


                    {{-- Tab Components --}}
                    <div class="my-3 col-md-12 col-lg-12" id="show-views" style="display:none">

                        {{-- show code here --}}


                    </div>

                </div>


            </div>
        </div>
    @endsection


    <script>
        function showData(round_id) {
            var url = "{{ url('super-admin/audition-events/round/details') }}";

            $.ajax({
                url: url + "/" + round_id, // your request url
                type: 'GET',
                success: function(data) {
                    console.log(data);


                    var htmlcode =
                        `<div class="row">
                            <div class=" col-md-3 col-lg-3 ">
                                <div class='card mx-1'> <h3 class='text-warning p-4'>Total Participant :&nbsp${data.roundParticipant}</h3></div>

                                </div>
                            <div class="col-md-3 col-lg-3">
     
                                <div class='card mx-1'> <h3 class='mx-2 text-warning p-4'>Total Videos :&nbsp${data.roundParticipantVideos}</h3></div>
                                
                                </div>
                            <div class="col-md-3 col-lg-3"> 
                                <div class='card mx-1'>  <h3 class='text-warning p-4'>Total Appeal :&nbsp${data.roundAppeal}</h3></div>
          
                                </div>
                            <div class="col-md-3 col-lg-3">
                                <div class='card mx-1'>    <h3 class='text-warning p-4'>Total Certification :&nbsp${data.roundCertification}</h3></div>
                 
                                </div>
                            <div class="col-md-3 col-lg-3">
                                <div class='card mx-1'>      <h3 class='text-warning p-4'>Total Winner :&nbsp${data.roundWinner}</h3></div>
        
                                </div>
                            <div class="col-md-3 col-lg-3">
                                <div class='card mx-1'> <h3 class='text-warning p-4'>Total Failed :&nbsp${data.roundFailed}</h3></div>
                      
                                </div>

                        </div>`

                    $('#show-views').html(htmlcode);
                    $('#show-views').attr("style", "display:block");
                }
            })

        }
    </script>
