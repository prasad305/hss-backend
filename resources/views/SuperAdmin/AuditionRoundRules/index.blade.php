@extends('Layouts.SuperAdmin.master')

@push('title')
    Super Admin
@endpush

@section('content')
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap');


        #icon-layout .active {
            background-color: #ff4136;
            color: white;
        }

        .btn {
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
        .active,
        .btn:hover {
            background-color: #ffce00;
            color: #000;
        }

        .displayNine {
            display: flex;
            justify-content: flex-end;
        }

        .audition__mark {
            background: #242424;
            border: 1px solid #B7AEAE;
            border-radius: 4px;
            width: 160px;
            height: 37px;
            text-align: left;
            padding: 5px 15px;
        }

        .audition__mark input {
            border: 2px solid #fdd700;
            appearance: none;
            border-radius: 50%;
            width: 14px;
            height: 14px;
            transition: all ease-in 0.2s;
        }

        .audition__mark span {
            padding-left: 10px;
        }

        .audition__mark input[type='radio']:checked {
            border: 1px solid #FFD910;
            background: #FFD910;
        }

        .wildcard__title {
            padding-top: 10px;
        }

        .wildcard__title p {
            font-weight: 500;
            font-size: 20px;
            letter-spacing: 0.5px;
        }

        .wildcard__title hr {
            height: 0.3px;
            background: #a7a7a7;
        }

        .wild_card__one {
            background: #242424;
            border: 1px solid #B7AEAE;
            border-radius: 4px;
            width: 50%;
            /* height: 37px; */
            text-align: left;
            padding: 5px 15px;
        }

        .wild_card__one input {
            border: 2px solid #fdd700;
            appearance: none;
            border-radius: 50%;
            width: 14px;
            height: 14px;
            transition: all ease-in 0.2s;
        }

        .wild_card__one input[type='radio']:checked {
            border: 1px solid #FFD910;
            background: #FFD910;
        }

        .wild_card__one span {
            padding-left: 10px;
        }

        .wild_card__two {
            background: #242424;
            border: 1px solid #B7AEAE;
            border-radius: 10px;
            width: 125px;
            height: 36px;
            text-align: left;
            padding: 5px 10px;
            margin: 0 10px;
        }


        .wild_card__two input {
            border: 2px solid #fdd700;
            appearance: none;
            border-radius: 50%;
            width: 14px;
            height: 14px;
            transition: all ease-in 0.2s;
        }

        .wild_card__two input[type='radio']:checked {
            border: 1px solid #FFD910;
            background: #FFD910;
        }

        .wild_card__two span {
            padding-left: 10px;
        }

        .availableBanner {
            background: linear-gradient(270deg, #FFAD00 0%, #FFD273 18.7%, #E19A04 42.13%, #FACF75 68.82%, #E7A725 85.94%, #FFAD00 100%);
            width: 40%;
            display: flex;
            height: 130px;
            justify-content: center;
            border-radius: 80px;
        }

        .clockBg {
            background-color: #000;
            display: inline-block;
            border-radius: 50%;
            width: 150px;
            display: flex;
            justify-content: center;
            align-items: center
        }

        .textFontBold {
            font-size: 40px;
            color: #000;
            /* font-weight: bold; */
            font-family: 'Bebas Neue', cursive;
        }

        .textFontBolder {
            font-size: 50px;
            color: #000;
            /* font-weight: bold; */
            font-family: 'Bebas Neue', cursive;
        }

        .textDark {
            color: #000;
            font-weight: bold
        }

        .bottomDiv {
            border-bottom: 1px solid #fff
        }

        .flexRow {
            background-color: #242424;
            padding: 10px;
            border-radius: 15px;
        }

        .roundedYesNo {
            border-radius: 15px
        }

        .imgWidth {
            width: 100% !important;
        }

        .pbSetTime {
            margin-top: -20px;
        }

        .roundIndex {
            font-size: 30px;
            font-weight: bold;
        }

        .roundText {
            font-weight: bold;
        }
    </style>

    <!-- Content Header (Page header) -->


    <div class="content-header BorderRpo">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-sm-6">
                    <h1 class="m-0">Audition List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">

                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"> Audition List</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>



    <!-- /.content-header -->
    <ul class="nav nav-tabs m-4" role="tablist">

        @foreach ($rules_categories as $key => $rules)
            @if ($rules->category)
                <li class="nav-item custom-nav-item m-2 TextBH" {{-- <li class="nav-item custom-nav-item m-2 TextBH {{ $key == 0 ? 'active' : '' }}" --}}>
                    <a class="nav-link border-warning " data-toggle="tab"
                        href="#tabs-{{ $rules->category ? $rules->category->id : '' }}" role="tab">
                        {{-- <center> --}}
                        <img src="{{ asset($rules->category ? $rules->category->icon : '') }}" class="imgWidth pt-2"
                            alt={{ $rules->category ? $rules->category->name : '' }} icon>
                        {{-- </center> --}}
                        <a class="btn  border-warning
                        {{-- {{ $key == 0 ? 'active' : '' }} --}}
                        "
                            onclick="selectedCategory('{{ $rules->id }}')" data-toggle="tab"
                            href="#tabs-{{ $rules->category->id ?? '' }}"
                            role="tab">{{ $rules->category ? $rules->category->name : '' }}</a>
                    </a>
                </li>
            @endif
        @endforeach
    </ul>



    <div class="tab-content m-4">
        <h3>Audition List Edit</h3>

    </div>
    <div class="bottomDiv">

    </div>

    <div class="tab-content m-4" id="tab-content">

    </div>

    <div class="m-4" id="show-rules" style="display:none">
        <div class="tab-pane " id="tabs-90" role="tabpanel">
            <div class="container">

                <h5 class="text-warning">Mark Distribution </h5>
                <div class="bottomDiv">

                </div>

                <form id="create-form">
                    @csrf

                    <div class="row">
                        <input type="hidden" name="round_id" id="round_id">
                        <div class="d-flex  justify-content-between BorderInSA p-2 m-1 mt-3 col-md-12">
                            <div class="text-light mt-1">
                                <div class="custom-control">
                                    <input type="checkbox" id="checkbox1" class="mt-3" value="1" />
                                    <label class="" for="jury"><span class="px-3">User Vote Mark</span></label>
                                </div>
                            </div>
                        </div>
                        {{-- <div id="hid_show_live_or_offile" style="display: none!important">
                        </div> --}}
                    </div>
                    <div class="d-flex flex-row flexRow mx-2 my-3 w-100">
                        <div class="audition__mark">
                            <input type="radio" name="mark_live_or_offline" value="1"> <span>Live Mark</span>
                        </div>
                        <div class="audition__mark ml-3">
                            <input type="radio" name="mark_live_or_offline" value="0"> <span>Offline
                                Mark</span>
                        </div>
                        <span class="text-danger" id="mark_live_or_offline_error"></span>

                        <div class="col-md-8 displayNine">

                            <div class="col-md-3">
                                <input type="text" name="user_vote_mark" id="user_vote_mark" onkeyup="markCheck()"
                                    class="form-control text-center" placeholder="User Vote Mark">
                                <span class="text-danger" id="user_vote_mark_error"></span>
                            </div>
                        </div>
                    </div>


                    <div class="d-flex flex-row flexRow my-3 mx-2 w-100">
                        <div class="audition__mark">
                            <input type="radio" name="has_jury_or_judge_mark" value="0"> <span>Jury
                                Mark</span>
                        </div>
                        <div class="audition__mark ml-3">
                            <input type="radio" name="has_jury_or_judge_mark" value="1"> <span>Judge
                                Mark</span>
                        </div>

                        <span class="text-danger" id="jury_or_judge_error"></span>

                        <div class='col-md-8 displayNine'>

                            <div class="col-md-3">
                                <input type="text" name="jury_or_judge_mark" id="jury_or_judge_mark"
                                    onkeyup="markCheck()" class="form-control text-center" placeholder="Mark">
                                <span class="text-danger" id="jury_or_judge_mark_error"></span>
                            </div>
                        </div>

                    </div>
                    <center><span id="mark_check_error" class="text-danger"></span></center>



                    <div class="d-flex flex-column w-100 mt-2">
                        <div class="wildcard__title">
                            <p class="text-warning">WildCard</p>
                            <hr>
                        </div>
                        <div class="d-flex flex-row">
                            <div class="wild_card__one roundedYesNo p-3">
                                <input type="radio" name="wildcard" value="1" onchange="wilCardNo(this.value)">
                                <span>Yes</span>
                            </div>
                            <div class="wild_card__one ml-3 roundedYesNo p-3">
                                <input type="radio" name="wildcard" value="0" onchange="wilCardNo(this.value)">
                                <span>No</span>
                            </div>
                            <span class="text-danger" id="wildcard_error"></span>
                        </div>

                        <div class="d-flex flex-wrap my-4" id="wildcard_rounds">

                        </div>

                    </div>



                    <div class="d-flex flex-column w-100 mt-2">
                        <div class="wildcard__title">
                            <p class='text-warning'>Video Feed</p>
                            <hr>
                        </div>
                        <div class="d-flex flex-row">
                            <div class="wild_card__one roundedYesNo p-3">
                                <input type="radio" name="video_feed" value="1"> <span>Yes</span>
                            </div>
                            <div class="wild_card__one ml-3 roundedYesNo p-3">
                                <input type="radio" name="video_feed" value="0"> <span>No</span>
                            </div>
                            <span class="text-danger" id="video_feed_error"></span>
                        </div>

                    </div>


                    <div class="d-flex flex-row row">
                        {{-- <div class="d-flex flex-column w-100 mt-2">
                            <div class="wildcard__title">
                                <p>Video Duration</p>
                                <hr>
                            </div>
                            <div class="d-flex flex-row col-md-4">
                                <input type="text" class="form-control" name="video_duration" id="video_duration"
                                    placeholder="ex: 3min">
                            </div>
                        </div>

                        <div class="d-flex flex-column w-100 mt-2">
                            <div class="wildcard__title">
                                <p>Video Slot Num</p>
                                <hr>
                            </div>
                            <div class="d-flex flex-row col-md-4">
                                <input type="text" class="form-control" name="video_slot_num" id="video_slot_num"
                                    placeholder="ex: 4 videos">
                            </div>
                        </div> --}}

                        <div class="col-md-12">
                            <div class="w-100 mt-2">
                                <div class="wildcard__title">
                                    <p class='text-warning'>Round Period</p>
                                    <hr>

                                </div>
                                <div class="d-flex flex-row">
                                    <input type="text" class="form-control" name="round_period" id="round_period"
                                        onkeyup="checkAvaibaleDays()" placeholder="ex: 123 days">
                                </div>
                                <span id="round_peroid_days_error" class="text-danger"></span>
                            </div>

                        </div>
                        <div class="col-md-6">

                            <div class="d-flex flex-column w-100 mt-2">
                                <div class="wildcard__title">
                                    <p class='text-warning'>Video Upload Period</p>
                                    <hr>
                                </div>
                                <div class="d-flex flex-row">
                                    <input type="text" class="form-control" name="video_upload_period"
                                        id="video_upload_period" onkeyup="periodCheck()" placeholder="ex: 123 days">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-row col-md-12">

                    </div>

                    <div class="d-flex flex-row col-md-12">
                        <div class="d-flex flex-column w-100 mt-2">
                            <div class="wildcard__title">
                                <p class='text-warning'>Jury / Judge Mark Period</p>
                                <hr>
                            </div>
                            <div class="d-flex flex-row">
                                <input type="text" class="form-control" name="jury_or_judge_mark_period"
                                    id="jury_or_judge_mark_period" onkeyup="periodCheck()" placeholder="ex: 123 days">
                            </div>
                        </div>

                        <div class="d-flex flex-column w-100 mt-2">
                            <div class="wildcard__title">
                                <p class='text-warning'>Result Publish Period</p>
                                <hr>
                            </div>
                            <div class="d-flex flex-row">
                                <input type="text" class="form-control" name="result_publish_period"
                                    id="result_publish_period" onkeyup="periodCheck()" placeholder="ex: 123 days">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-column w-100 mt-2">
                        <div class="wildcard__title">
                            <p class='text-warning'>Appeal</p>
                            <hr>
                        </div>
                        <div class="d-flex flex-row">
                            <div class="wild_card__one roundedYesNo p-3">
                                <input type="radio" checked="checked" name="appeal" value="1"
                                    onchange="IsAppeal(this.value)"> <span>Yes</span>
                            </div>
                            <div class="wild_card__one ml-3 roundedYesNo p-3">
                                <input type="radio" name="appeal" value="0" onchange="IsAppeal(this.value)">
                                <span>No</span>
                            </div>
                            <span class="text-danger" id="appeal_error"></span>
                        </div>
                    </div>

                    <div id="appeal_section">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="w-100 mt-2">
                                    <div class="wildcard__title">
                                        <p class='text-warning'>Appeal Period</p>
                                        <hr>
                                    </div>
                                    <div class="d-flex flex-row">
                                        <input type="text" class="form-control" onkeyup="periodCheck()"
                                            name="appeal_period" id="appeal_period" placeholder="ex: 123 days">
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="w-100 mt-2">
                                    <div class="wildcard__title">
                                        <p class='text-warning'>Appeal Video Upload Preiod</p>
                                        <hr>
                                    </div>
                                    <div class="d-flex flex-row">
                                        <input type="text" class="form-control" onkeyup="periodCheck()"
                                            name="appeal_video_upload_period" id="appeal_video_upload_period"
                                            placeholder="ex: 10 days">
                                    </div>
                                </div>

                            </div>




                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="w-100 mt-2">
                                    <div class="wildcard__title">
                                        <p class='text-warning'>Appeal Jury Or Judge Mark Preiod</p>
                                        <hr>
                                    </div>
                                    <div class="d-flex flex-row">
                                        <input type="text" class="form-control" onkeyup="periodCheck()"
                                            name="appeal_jury_or_judge_mark_period" id="appeal_jury_or_judge_mark_period"
                                            placeholder="ex: 10 days">
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">

                                <div class="w-100 mt-2">
                                    <div class="wildcard__title">
                                        <p class='text-warning'>Result Publish Period</p>
                                        <hr>
                                    </div>
                                    <div class="d-flex flex-row ">
                                        <input type="text" class="form-control" name="appeal_result_publish_period"
                                            id="appeal_result_publish_period" onkeyup="periodCheck()"
                                            placeholder="ex: 123 days">
                                    </div>
                                </div>

                            </div>
                        </div>





                    </div>

                    <center><span id="hole_round_peroid_error" class="text-danger"></span></center>

                    <div class="d-flex col-md-12 justify-content-center mt-4 mb-4">
                        <button class="btn bg-info px-3 BTNback mr-3" id="back">Back</button>
                        <button class="btn bg-warning px-3 BTNdone" id="SubmitRules">Done</button>
                    </div>


            </div>
            </form>
        </div>
    </div>

    </div>


    <script>
        var round_available_days = 0;

        function selectedCategory(rules_id) {
            console.log('category', rules_id);
            var url = "{{ url('super-admin/audition-round-rules/') }}";

            $.ajax({
                url: url + "/" + rules_id, // your request url
                type: 'GET',
                success: function(data) {
                    console.log('get data', data);
                    $('#tab-content').html("");
                    $('#round_available_days').html(data.round_available_days);
                    round_available_days += data.round_available_days;


                    if (data.round_rules.length === 0) {
                        $('#show-rules').attr("style", "display:none");
                    }

                    var single_round = "";

                    data.round_rules.forEach((round, index) => {
                        single_round +=
                            '<li class=" nav-item custom-nav-item m-2 mt-4 TextBH">' +
                            '<a class="nav-link border-warning text-warning font-weight-bold" data-toggle="tab" href="" role="tab">' +
                            '<center class="mb-2">' +
                            '<h2 class="roundText">Round</h2>' +
                            '<span class="text-warning roundIndex p-1" >' + `${index+1}` +
                            '</span>' +
                            '</center>' +
                            '<a onclick="showRules(' + round.id +
                            ')" class="btn border-warning roundText" data-toggle="tab" href="" role="tab">Rolls</a>' +
                            '</a>' +
                            '</li>'


                        ;
                    });

                    $('#tab-content').append(

                        '<div class="my-5">' +
                        '<div class="d-flex justify-content-center">' +
                        '<div class="availableBanner">' +
                        '<div class="clockBg">' +
                        '<img src="{{ asset('assets/clock1.png') }}" width="120" alt="">' +
                        '</div>' +
                        '<div class="mx-4">' +
                        '<div class="d-flex align-items-center">' +
                        '<p class="textFontBold pt-3">Available Days:</p>' +
                        '<p class="textFontBolder pt-3">' + data.round_available_days + '</p>' +
                        '</div>' +
                        '<p class="text-center textDark pbSetTime">(Set Time Period be Carefully)</p>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +

                        '<div>' +
                        '<ul class="nav nav-tabs" role="tablist">' + single_round + '</ul>' +
                        '</div>' +
                        '</div>'


                    );

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

                    console.log(data);
                }
            });

        };



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

                    console.log(data);
                }
            });

            $('#show-rules').attr("style", "display:block");
        }

        function checkAvaibaleDays() {
            var round_period = $('#round_period').val();
            $('#round_peroid_days_error').html(' ');
            $("#SubmitRules").prop("disabled", false);
            if (round_available_days == 0 || round_available_days < round_period) {
                $('#round_peroid_days_error').html('Round Available Days is Over');
                $("#SubmitRules").prop("disabled", true);
            }
        }

        function periodCheck() {
            $("#SubmitRules").prop("disabled", false);
            $('#hole_round_peroid_error').html('');

            let round_period = Number($('#round_period').val());
            let prepare_period = Number($('#instruction_prepare_period').val());
            let video_upload_period = Number($('#video_upload_period').val());
            let jury_or_judge_mark_period = Number($('#jury_or_judge_mark_period').val());
            let result_publish_period = Number($('#result_publish_period').val());
            let appeal_period = Number($('#appeal_period').val());
            let appeal_result_publish_period = Number($('#appeal_result_publish_period').val());
            let appeal_video_upload_period = Number($('#appeal_video_upload_period').val());
            let appeal_jury_or_judge_mark_period = Number($('#appeal_jury_or_judge_mark_period').val());

            let sum_of_round_period = prepare_period + video_upload_period + jury_or_judge_mark_period +
                result_publish_period + appeal_period + appeal_result_publish_period + appeal_video_upload_period +
                appeal_jury_or_judge_mark_period;

            if (Number(round_period) < Number(sum_of_round_period)) {
                $("#SubmitRules").prop("disabled", true);
                $('#hole_round_peroid_error').html('Round Period Over! Please Cehck and Try Again!');


            }
        }

        function markCheck() {
            $("#SubmitRules").prop("disabled", false);
            $('#mark_check_error').html('');
            var user_mark = Number($('#user_vote_mark').val());
            var jury_or_judge_mark = Number($('#jury_or_judge_mark').val());
            let sum = user_mark + jury_or_judge_mark;
            if (sum > 100) {
                $("#SubmitRules").prop("disabled", true);
                $('#mark_check_error').html('User Vote Mark and Jury/Judge Mark Not More then 100!!');

            }

        }

        $(document).on('click', '#SubmitRules', function(event) {
            event.preventDefault();

            let round_period = Number($('#round_period').val());

            let video_upload_period = Number($('#video_upload_period').val());
            let jury_or_judge_mark_period = Number($('#jury_or_judge_mark_period').val());
            let result_publish_period = Number($('#result_publish_period').val());
            let appeal_period = Number($('#appeal_period').val());
            let appeal_result_publish_period = Number($('#appeal_result_publish_period').val());
            let appeal_video_upload_period = Number($('#appeal_video_upload_period').val());
            let appeal_jury_or_judge_mark_period = Number($('#appeal_jury_or_judge_mark_period').val());

            let sum_of_round_period = video_upload_period + jury_or_judge_mark_period +
                result_publish_period + appeal_period + appeal_result_publish_period + appeal_video_upload_period +
                appeal_jury_or_judge_mark_period;

            if (round_period == sum_of_round_period) {

                ErrorMessageClear();
                $('.wild_card__two').css("display", "block");
                var round_id = $('#round_id').val();
                var form = $('#create-form')[0];


                var formData = new FormData(form);
                formData.append('round_id', round_id);
                formData.append('has_user_vote_mark', $('#checkbox1').prop('checked') ? 1 : 0);

                // Set header if need any otherwise remove setup part
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
                    }
                });

                $.ajax({
                    url: "{{ route('superAdmin.audition-round-rules.store') }}", // your request url
                    data: formData,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    success: function(data) {
                        Swal.fire({
                            position: 'top-end',
                            icon: data.type,
                            title: data.message,
                            showConfirmButton: false,
                            // timer: 1500
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                        console.log(data)
                    },
                    error: function(data) {

                        $.each(data.responseJSON.errors, function(key, value) {
                            ErrorMessage(key, value);
                        });


                        console.log(data);
                    }
                });
                showRules(round_id);
            }else{
                $('#hole_round_peroid_error').html('Total Video should '+round_period+' !');
            }

        });

        $(document).ready(function() {

            $('#textbox1').attr("style", "display:none");
            $('#textbox2').attr("style", "display:none");
            $('#textbox3').attr("style", "display:none");

            $('#checkbox1').change(function() {
                if ($(this).is(":checked")) {
                    $('#textbox1').attr("style", "display:block");
                } else {
                    $('#textbox1').attr("style", "display:none");
                }
            });
            $('#checkbox2').change(function() {
                if ($(this).is(":checked")) {
                    $('#textbox2').attr("style", "display:block");
                } else {
                    $('#textbox2').attr("style", "display:none");
                }
            });

            $('#checkbox3').change(function() {
                if ($(this).is(":checked")) {
                    $('#textbox3').attr("style", "display:block");
                } else {
                    $('#textbox3').attr("style", "display:none");
                }
            });
        });



        function wilCardNo(value) {
            if (value == 0) {
                $('.wild_card__two').css("display", "none");
            } else {
                $('.wild_card__two').css("display", "block");
            }
        }

        function IsAppeal(value) {
            if (value == 0) {
                $('#appeal_section').css("display", "none");
            } else {
                $('#appeal_section').css("display", "block");
            }
        }




        var header = document.getElementById("myDIV");
        var btns = header.getElementsByClassName("btn");
        for (var i = 0; i < btns.length; i++) {
            btns[i].addEventListener("click", function() {
                var current = document.getElementsByClassName("active");
                if (current.length > 0) {
                    current[0].className = current[0].className.replace(" active", "");
                }
                this.className += " active";
            });
        }

        var activeclass = document.querySelectorAll("#icon-layout div");
        for (var i = 0; i < activeclass.length; i++) {
            activeclass[i].addEventListener("click", activateClass);
        }

        function activateClass(e) {
            for (var i = 0; i < activeclass.length; i++) {
                activeclass[i].classList.remove("active");
            }
            e.target.classList.add("active");
        }
    </script>
@endsection
