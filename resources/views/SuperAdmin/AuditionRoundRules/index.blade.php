@extends('Layouts.SuperAdmin.master')

@push('title')
Super Admin
@endpush

@section('content')
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<style>
    .audition__mark{
        background: #242424;
        border: 1px solid #B7AEAE;
        border-radius: 4px;
        width: 160px;
        height: 37px;
        text-align: left;
        padding: 5px 15px;
    }

    .audition__mark input{
        border: 2px solid #fdd700;
        appearance: none;
        border-radius: 50%;
        width: 14px;
        height: 14px;
        transition: all ease-in 0.2s;
    }

    .audition__mark span{
        padding-left: 10px;
    }
    .audition__mark input[type='radio']:checked{
        border: 1px solid #FFD910;
        background: #FFD910;
    }

    .wildcard__title{
        padding-top: 10px;
    }
    .wildcard__title p{
        font-weight: 500;
        font-size: 20px;
        letter-spacing: 0.5px;
    }
    .wildcard__title hr{
        height: 0.3px;
        background: #a7a7a7;
    }
    .wild_card__one{
        background: #242424;
        border: 1px solid #B7AEAE;
        border-radius: 4px;
        width: 50%;
        height: 37px;
        text-align: left;
        padding: 5px 15px;
    }
    .wild_card__one input{
        border: 2px solid #fdd700;
        appearance: none;
        border-radius: 50%;
        width: 14px;
        height: 14px;
        transition: all ease-in 0.2s;
    }

    .wild_card__one input[type='radio']:checked{
        border: 1px solid #FFD910;
        background: #FFD910;
    }

    .wild_card__one span{
        padding-left: 10px;
    }

    .wild_card__two{
        background: #242424;
        border: 1px solid #B7AEAE;
        border-radius: 4px;
        width: 125px;
        height: 36px;
        text-align: left;
        padding: 5px 10px;
    }
    .wild_card__two input{
        border: 2px solid #fdd700;
        appearance: none;
        border-radius: 50%;
        width: 14px;
        height: 14px;
        transition: all ease-in 0.2s;
    }
    .wild_card__two input[type='radio']:checked{
        border: 1px solid #FFD910;
        background: #FFD910;
    }
    .wild_card__two span{
        padding-left: 10px;
    }



</style>

<!-- Content Header (Page header) -->
<div class="content-header BorderRpo">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-sm-6">
                <h1 class="m-0">Audition List</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{-- <a href="{{ route('superAdmin.events.edit',1) }}"> <li class="breadcrumb-item active">Events
                        List</li></a> --}}
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active"> Audition List</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<!-- /.content-header -->
<ul class="nav nav-tabs m-4" role="tablist">

    @foreach ($rules_categories as $key => $rules)
    @if($rules->category)
    <li class="nav-item custom-nav-item m-2 TextBH {{ $key == 0 ? 'active' : '' }}" onclick="selectedCategory('{{ $rules->id }}')">
        <a class="nav-link border-warning " data-toggle="tab" href="#tabs-{{ $rules->category ? $rules->category->id : '' }}" role="tab">
            <center>
                <img src="{{ asset($rules->category ? $rules->category->icon : '') }}" class="ARRimg pt-2" alt={{ $rules->category ? $rules->category->name : '' }} icon>
            </center>
            <a class="btn border-warning nav-link  {{ $key == 0 ? 'active' : '' }}" data-toggle="tab" href="#tabs-{{ $rules->category->id ?? '' }}" role="tab">{{ $rules->category ? $rules->category->name : '' }}</a>
        </a>
    </li>
    @endif
    @endforeach
</ul>

<div class="tab-content m-4">
    <h3>Audition List Edit</h3>
    <hr>
</div>

<div class="tab-content m-4" id="tab-content">

</div>

<div class="m-4" id="show-rules" style="display:none">
    <div class="tab-pane " id="tabs-90" role="tabpanel">
        <div class="container">
            <p>Mark Distribution</p>
            <form id="create-form">
                @csrf

                <div class="row">
                    <input type="hidden" name="round_id" id="round_id">
                    <div class="d-flex  justify-content-between BorderInSA p-2 m-1 col-md-12">
                        <div class="text-light mt-1">
                            <div class="custom-control">
                                <input type="checkbox" id="checkbox1" class=" mt-3" />
                                <label class="" for="jury"><span class="px-3">User Vote Mark</span></label>
                            </div>
                        </div>
                        <div class="text-light">
                            <input type="number" min="0" max="100" id="textbox1" class="Chexka form-control" placeholder="0" />
                        </div>
                    </div>

                    <div class="d-flex  justify-content-between BorderInSA p-2 m-1 col-md-12">
                        <div class="text-light mt-1">
                            <div class="custom-control">
                                <input type="checkbox" id="checkbox2" class=" mt-3" />
                                <label class="" for="jury"><span class="px-3">Jury Mark</span></label>
                            </div>
                        </div>
                        <div class="text-light">
                            <input type="number" min="0" max="100" id="textbox2" class="Chexka form-control" placeholder="0" />
                        </div>
                    </div>

                    <div class="d-flex  justify-content-between BorderInSA p-2 m-1 col-md-12">
                        <div class="text-light mt-1">
                            <div class="custom-control">
                                <input type="checkbox" id="checkbox3" class=" mt-3" />
                                <label class="" for="jury"><span class="px-3">Judge Mark</span></label>
                            </div>
                        </div>
                        <div class="text-light">
                            <input type="number" min="0" max="100" id="textbox3" class="Chexka form-control" placeholder="0" />
                        </div>
                    </div>

                    <div class="d-flex flex-row my-3 w-100">
                        <div class="audition__mark">
                            <input type="radio" name="mark" value="Live Mark"> <span>Live Mark</span>
                        </div>
                        <div class="audition__mark ml-3">
                            <input type="radio" name="mark" value="Offline Mark"> <span>Offline Mark</span>
                        </div>
                    </div>

                    <div class="d-flex flex-column w-100 mt-2">
                       <div class="wildcard__title">
                           <p>WildCard</p>
                           <hr>
                       </div>
                       <div class="d-flex flex-row">
                           <div class="wild_card__one">
                               <input type="radio" name="wildcard" value="Yes"> <span>Yes</span>
                           </div>
                           <div class="wild_card__one ml-3">
                               <input type="radio" name="wildcard" value="No"> <span>No</span>
                           </div>
                       </div>

                        <div class="d-flex flex-row justify-content-between my-2">
                            <div class="wild_card__two">
                                <input type="radio" name="wildcardTwo" value="Round 01"><span>Round 01</span>
                            </div>
                            <div class="wild_card__two">
                                <input type="radio" name="wildcardTwo" value="Round 02"><span>Round 02</span>
                            </div>
                            <div class="wild_card__two">
                                <input type="radio" name="wildcardTwo" value="Round 03"><span>Round 03</span>
                            </div>
                            <div class="wild_card__two">
                                <input type="radio" name="wildcardTwo" value="Round 04"><span>Round 04</span>
                            </div>
                            <div class="wild_card__two">
                                <input type="radio" name="wildcardTwo" value="Round 05"><span>Round 05</span>
                            </div>
                            <div class="wild_card__two">
                                <input type="radio" name="wildcardTwo" value="Round 06"><span>Round 06</span>
                            </div>
                            <div class="wild_card__two">
                                <input type="radio" name="wildcardTwo" value="Round 07"><span>Round 07</span>
                            </div>
                            <div class="wild_card__two">
                                <input type="radio" name="wildcardTwo" value="Round 08"><span>Round 08</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-column w-100 mt-2">
                        <div class="wildcard__title">
                            <p>Applie</p>
                            <hr>
                        </div>
                        <div class="d-flex flex-row">
                            <div class="wild_card__one">
                                <input type="radio" name="applie" value="Yes"> <span>Yes</span>
                            </div>
                            <div class="wild_card__one ml-3">
                                <input type="radio" name="applie" value="No"> <span>No</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-column w-100 mt-2">
                        <div class="wildcard__title">
                            <p>Video Feed</p>
                            <hr>
                        </div>
                        <div class="d-flex flex-row">
                            <div class="wild_card__one">
                                <input type="radio" name="videoFeed" value="Yes"> <span>Yes</span>
                            </div>
                            <div class="wild_card__one ml-3">
                                <input type="radio" name="videoFeed" value="No"> <span>No</span>
                            </div>
                        </div>

                        <div class="d-flex flex-row my-2">
                            <div class="wild_card__two w-25">
                                <input type="radio" name="videoFeedType" value="Live video"><span>Live video</span>
                            </div>
                            <div class="wild_card__two w-25 ml-3">
                                <input type="radio" name="videoFeedType" value="Uploaded Video"><span>Uploaded Video</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex col-md-12 justify-content-center mt-4 mb-4">
                        <button class="btn bg-info px-3 BTNback mr-3" id="SubmitRules">Back</button>
                        <button class="btn bg-warning px-3 BTNdone" id="SubmitRules">Done</button>
                    </div>

                </div>
            </form>
        </div>
    </div>

</div>


<script>
    function selectedCategory(rules_id) {


        // var rules_id = $('.selectedCategory').text();
        console.log('category', rules_id);
        var url = "{{ url('super-admin/audition-round-rules/') }}";


        $.ajax({
            url: url + "/" + rules_id, // your request url
            type: 'GET'
            , success: function(data) {
                console.log('get data', data);
                $('#tab-content').html("");

                if (data.round_rules.length === 0) {
                    $('#show-rules').attr("style", "display:none");
                }

                var single_round = "";

                data.round_rules.forEach((round, index) => {
                    single_round += '<li class="nav-item custom-nav-item m-2 TextBH" onclick="showRules(' + round.id + ')">' +
                        '<a class="nav-link border-warning text-warning font-weight-bold" data-toggle="tab" href="" role="tab">' +
                        '<center class="mb-2">' +
                        '<h4>Round</h4>' +
                        '<span class="bg-gray p-1 btn " >' + `${index+1}` + '</span>' +
                        '</center>' +
                        '<a class="btn border-warning nav-link " data-toggle="tab" href="" role="tab">Rolls</a>' +
                        '</a>' +
                        '</li>';
                });

                $('#tab-content').append(
                    '<div>' +
                    '<ul class="nav nav-tabs" role="tablist">' + single_round + '</ul>' +
                    '</div>'
                );

            }
            , error: function(data) {
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
                    icon: 'error'
                    , title: 'Oops...'
                    , footer: errorMessage
                });

                console.log(data);
            }
        });

    };

    function showRules(round_id) {

        // alert(round_id)

        var url = "{{ url('super-admin/audition-round-rules/mark/') }}";


        $.ajax({
            url: url + "/" + round_id, // your request url
            type: 'GET',
            success: function(data) {
                console.log('get data', data);
                $('#round_id').val(round_id);
                if (data.mark.user_vote_mark > 0) {
                    $('#checkbox1').attr('checked', 'checked');
                    $('#textbox1').attr("style", "display:block");
                    $('#textbox1').val(data.mark.user_vote_mark);
                }else{
                    $('#checkbox1').attr('checked', false);
                    $('#textbox1').attr("style", "display:none");
                    $('#textbox1').val(0);
                }

                if (data.mark.jury_mark > 0) {
                    $('#checkbox2').attr('checked', 'checked');
                    $('#textbox2').attr("style", "display:block");
                    $('#textbox2').val(data.mark.jury_mark);
                }else{
                    $('#checkbox2').attr('checked', false);
                    $('#textbox2').attr("style", "display:none");
                    $('#textbox2').val(0);
                }

                if (data.mark.judge_mark > 0) {
                    $('#checkbox3').attr('checked', 'checked');
                    $('#textbox3').attr("style", "display:block");
                    $('#textbox3').val(data.mark.judge_mark);
                }else{
                    $('#checkbox3').attr('checked', false);
                    $('#textbox3').attr("style", "display:none");
                    $('#textbox3').val(0);
                }


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


    $(document).on('click', '#SubmitRules', function(event) {
            event.preventDefault();
            var round_id = $('#round_id').val();
            // alert(round_id);
            var v1 = parseInt($('#textbox1').val()) > 0 ? parseInt($('#textbox1').val()) : 0;
            var v2 = parseInt($('#textbox2').val()) > 0 ? parseInt($('#textbox2').val()) : 0;
            var v3 = parseInt($('#textbox3').val()) > 0 ? parseInt($('#textbox3').val()) : 0;
            var total = v1 + v2 + v3;

            if (total > 100) {
                Swal.fire({
                    position: 'center'
                    , icon: 'error'
                    , title: 'Total Mark Will Not Be More Than 100'
                    , showConfirmButton: true,
                    // timer: 1500
                })
                // alert('Total Mark Will Not Be More Than 100');
            } else {
                var form = $('#create-form')[0];

                var formData = new FormData(form);
                formData.append('round_id', round_id);
                formData.append('user_vote_mark', v1);
                formData.append('jury_mark', v2);
                formData.append('judge_mark', v3);

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
                        })
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                        console.log('success')
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
            }

            showRules(round_id);
    });

    $(document).ready(function() {
        // $('#textbox1').val($(this).is(':checked'));

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

        // var v1 = $('#textbox1').val();
        // var v2 = $('#textbox2').val();
        // var v3 = $('#textbox3').val();

        // var total = v1 + v2 + v3;

        // if (total > 100) {
        //     alert('Total Mark Will Not Be More Than 100');
        // }
    });

</script>

@endsection
