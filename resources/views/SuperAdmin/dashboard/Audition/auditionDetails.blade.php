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


    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

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
                                                            <img src="{{ asset($judge->user->image) }}"
                                                                class="star-judge" />
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
                                                            <img src="{{ asset($jury->user->image) }}"
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


                    <div>
                        <ul class="nav nav-tabs" role="tablist">
                            <li class=" nav-item custom-nav-item m-2 mt-4 TextBH">
                                <a class="nav-link border-warning text-warning font-weight-bold" data-toggle="tab"
                                    href="" role="tab">
                                    <center class="mb-2">
                                        <h2 class="roundText">Round</h2>
                                        <span class="text-warning roundIndex p-1">1
                                        </span>
                                    </center>
                                    <a onclick="showRules(1)" class="btn border-warning btn-act" data-toggle="tab"
                                        href="" role="tab">Rules</a>
                                </a>
                            </li>

                            <li class=" nav-item custom-nav-item m-2 mt-4 TextBH">
                                <a class="nav-link border-warning text-warning font-weight-bold" data-toggle="tab"
                                    href="" role="tab">
                                    <center class="mb-2">
                                        <h2 class="roundText">Round</h2>
                                        <span class="text-warning roundIndex p-1">2
                                        </span>
                                    </center>
                                    <a onclick="showRules(2)" class="btn border-warning btn-act" data-toggle="tab"
                                        href="" role="tab">Rules</a>
                                </a>
                            </li>

                            <li class=" nav-item custom-nav-item m-2 mt-4 TextBH">
                                <a class="nav-link border-warning text-warning font-weight-bold" data-toggle="tab"
                                    href="" role="tab">
                                    <center class="mb-2">
                                        <h2 class="roundText">Round</h2>
                                        <span class="text-warning roundIndex p-1">3
                                        </span>
                                    </center>
                                    <a onclick="showRules(3)" class="btn border-warning btn-act" data-toggle="tab"
                                        href="" role="tab">Rules</a>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content mx-4 mt-1 mb-4" id="tab-content">
                        sdfds
                    </div>

                    <div class="m-4" id="show-rules" style="display:none">
                        sdflkhsdflk
                    </div>
                </div>
            </div>
        </div>
    @endsection
    <script>
             function showRules(round_id) {
            $('#wildcard_rounds').html('');
            $('#jury_or_judge_mark').val('');

            $("#checkbox1").click(function() {
                var checked = $(this).is(':checked');
                if (checked) {
                    // alert('checked');
                    $('#hid_show_live_or_offile').attr("style", "display:block!important;");
                } else {
                    $('#hid_show_live_or_offile').attr("style", "display:none!important;");
                    // alert('unchecked');
                }
            });
            var wild_card_true = $('input:radio[name=wildcard][value=1]').attr('checked', true) ? 1 : 0;
            var appeal_true = $('input:radio[name=appeal][value=1]').attr('checked', true) ? 1 : 0;

            wilCardNo(wild_card_true);
            IsAppeal(appeal_true);
            var url = "{{ url('super-admin/audition-round-rules/mark/') }}";

            $.ajax({
                url: url + "/" + round_id, // your request url
                type: 'GET',
                success: function(data) {

                    $('#round_id').val(round_id);



                    if (data.mark.has_user_vote_mark == 1) {
                        $('#checkbox1').attr('checked', true);
                        $('#hid_show_live_or_offile').attr("style", "display:block!important;");


                        if (data.mark.mark_live_or_offline == 0) {
                            $('input:radio[name=mark_live_or_offline][value=0]').attr('checked', true);
                        } else {
                            $('input:radio[name=mark_live_or_offline][value=1]').attr('checked', true);
                        }

                    } else {
                        $('#checkbox1').attr('checked', false);
                        $('#hid_show_live_or_offile').attr("style", "display:none!important;");
                    }

                    if (data.mark.has_jury_or_judge_mark == 0) {
                        $('input:radio[name=has_jury_or_judge_mark][value=0]').attr('checked', true);
                    } else if (data.mark.has_jury_or_judge_mark == 1) {
                        $('input:radio[name=has_jury_or_judge_mark][value=1]').attr('checked', true);
                    }


                    $('#user_vote_mark').val(data.mark.user_vote_mark);
                    $('#jury_or_judge_mark').val(data.mark.jury_or_judge_mark);
                    $('#appeal_video_upload_period').val(data.mark.appeal_video_upload_period);
                    $('#appeal_jury_or_judge_mark_period').val(data.mark.appeal_jury_or_judge_mark_period);

                    if (data.mark.wildcard == 0) {
                        $('input:radio[name=wildcard][value=0]').attr('checked', true);
                    } else {
                        $('input:radio[name=wildcard][value=1]').attr('checked', true);
                    }


                    if (data.mark.video_feed == 0) {
                        $('input:radio[name=video_feed][value=0]').attr('checked', true);
                    } else {
                        $('input:radio[name=video_feed][value=1]').attr('checked', true);
                    }

                    if (data.mark.oxygen_feed == 0) {
                        $('input:radio[name=oxygen_feed][value=0]').attr('checked', true);
                    } else {
                        $('input:radio[name=oxygen_feed][value=1]').attr('checked', true);
                    }

                    if (data.mark.round_type == 0) {
                        $('input:radio[name=round_type][value=0]').attr('checked', true);
                    } else {
                        $('input:radio[name=round_type][value=1]').attr('checked', true);
                    }



                    if (data.mark.appeal == 0) {
                        $('input:radio[name=appeal][value=0]').attr('checked', true);
                    } else {
                        $('input:radio[name=appeal][value=1]').attr('checked', true);
                    }


                    // $('#video_duration').val(data.mark.video_duration);
                    // $('#video_slot_num').val(data.mark.video_slot_num);





                    $('#round_period').val(data.mark.round_period);
                    $('#instruction_prepare_period').val(data.mark.instruction_prepare_period);
                    $('#video_upload_period').val(data.mark.video_upload_period);
                    $('#jury_or_judge_mark_period').val(data.mark.jury_or_judge_mark_period);
                    $('#result_publish_period').val(data.mark.result_publish_period);
                    $('#appeal_period').val(data.mark.appeal_period);
                    $('#appeal_result_publish_period').val(data.mark.appeal_result_publish_period);

                    var single_round = "";

                    data.rules.forEach((round, index) => {
                        if (round.id > round_id) {
                            single_round += '<div class="wild_card__two"  style="display: block;">' +
                                '<input type="radio" name="wildcard_round" value="' + round.id +
                                '"><span>Round ' + `${index+1}` + '</span>' +
                                '</div>';
                        }
                    });

                    $('#wildcard_rounds').append(single_round);
                    $('input:radio[name=wildcard_round][value=' + data.mark.wildcard_round + ']').attr(
                        'checked', true);
                },
                error: function(data) {
                    var errorMessage = '<div class="card bg-danger">\n' +
                        '<div class="card-body text-center p-5">\n' +
                        '<span class="text-white">';
                    $.each(data.responseJSON.errors, function(key, value) {
                        errorMessage += ('' + value + '<br>');
                    });
                    errorMessage += '</span>\n' +
                        '</div>\n' +
                        '</div>';
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        footer: errorMessage
                    });

                }
            });

            $('#show-rules').attr("style", "display:block");
        }
    </script>
