@extends('Layouts.ManagerAdmin.master')


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
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="invoice p-3 mb-3">

                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <i class="fas fa-globe"></i> {{ $data->title }}
                                    <small class="float-right">{{ date('d-M-y', strtotime($data->created_at)) }}</small>
                                </h4>
                            </div>

                        </div>

                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                Category
                                <address>
                                    <strong>{{ $data->category->name }}</strong><br>
                                </address>
                            </div>

                            <div class="col-sm-4 invoice-col">
                                <h3>Judges</h3>
                                <address>
                                    @foreach ($data->assignedJudges as $judge)
                                        <strong>{{ $judge->user->first_name }}{{ $judge->user->last_name }}
                                        </strong><br>
                                    @endforeach

                                </address>
                            </div>

                            <div class="col-sm-4 invoice-col">
                                <b>Total Participant</b><br>
                                <b>{{ $data->auditionParticipant->count() }}</b><br>
                            </div>

                        </div>




                        <div class="row">

                            <div class="col-8">
                                <p class="lead">Banner</p>
                                @if ($data->banner)
                                    <img src=" {{ asset($data->banner) }}" alt="No-Image">
                                @else
                                    <a href="{{ asset('demo_image/banner.jpg') }}" target="_blank">
                                        <img src="{{ asset('demo_image/banner.jpg') }}" alt="Demo Image" />
                                    </a>
                                @endif

                                <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                    {!! $data->description !!}
                                </p>
                            </div>

                            <div class="col-4">
                                <p class="lead">Summary</p>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th style="width:50%">Total Registration:</th>
                                                <td>{{ $data->auditionParticipant->count() }}</td>
                                            </tr>
                                            <tr>
                                                <th>Total Fee:</th>
                                                <td>{{ $data->fees }}</td>
                                            </tr>
                                            <tr>
                                                <th>Total Judge:</th>
                                                <td>{{ $data->assignedJudges->count() }}</td>
                                            </tr>
                                            <tr>
                                                <th>Total Jury</th>
                                                <td>{{ $data->assignedJuries->count() }}</td>
                                            </tr>
                                            <tr>
                                                <th>Total Round:</th>
                                                <td>{{ $data->auditionRound->count() }}</td>
                                            </tr>
                                            <tr>
                                                <th>Registration Start Date</th>
                                                <td>{{ date('d-m-y', strtotime($data->registration_start_date)) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Registration End Date</th>
                                                <td>{{ date('d-m-y', strtotime($data->registration_start_date)) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                {{-- new section --}}

                <div class="row">

                    <div class="col-md-6 col-lg-3 mb-2 ">
                        <div class="card px-2 pt-1">
                            <h4 class="under-line py-1">Judge Panel</h4>
                            <div class="row">
                                @foreach ($data->assignedJudges as $judge)
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
                                @foreach ($data->admin as $admin)
                                    <div class="col-md-12">
                                        <div class="card p-2">
                                            <div class="d-flex align-content-center align-items-center">
                                                <div class="pr-2">
                                                    @if ($admin->admin->image)
                                                        <img src="{{ asset($admin->admin->image) }}" class="star-judge" />
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
                                                @if ($data->auditionAdmin->image)
                                                    <img src="{{ asset($data->auditionAdmin->image) }}"
                                                        class="star-judge" />
                                                @else
                                                    <a href="{{ asset('demo_image/demo_user.png') }}">
                                                        <img src="{{ asset('demo_image/demo_user.png') }}" alt="Demo Image"
                                                            class="star-judge" />
                                                    </a>
                                                @endif
                                            </div>
                                            <div>
                                                <span class="font-bold">Jury</span>
                                                <h5 class="text-warning">
                                                    {{ $data->auditionAdmin->first_name }}
                                                    {{ $data->auditionAdmin->last_name }}
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
                                @foreach ($data->assignedJuries as $jury)
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

                        @foreach ($data->auditionRound as $key => $round)
                            <li class="nav-item custom-nav-item m-2 mt-4 TextBH">
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

                {{-- end new section --}}

            </div>
        </div>
    </section>
@endsection
<script>
    function showData(round_id) {
        var url = "{{ url('manager-admin/audition-events/round/details') }}";

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
