@extends('Layouts.SuperAdmin.master')

@push('title')
    Super Admin
@endpush

@section('content')
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .container {
            display: block;
            position: relative;
            padding-left: 35px;
            margin-bottom: 12px;
            cursor: pointer;
            font-size: 22px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        /* Hide the browser's default radio button */
        .container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        /* Create a custom radio button */
        .checkmark {
            position: absolute;
            top: 6px;
            left: 0;
            height: 25px;
            width: 25px;
            background-color: white;
            border-radius: 50%;
        }

        /* On mouse-over, add a grey background color */
        .container:hover input~.checkmark {
            background-color: #ccc;
        }

        /* When the radio button is checked, add a blue background */
        .container input:checked~.checkmark {
            background-color: #dfa431;
        }

        /* Create the indicator (the dot/circle - hidden when not checked) */
        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        /* Show the indicator (dot/circle) when checked */
        .container input:checked~.checkmark:after {
            display: block;
        }

        /* Style the indicator (dot/circle) */
        .container .checkmark:after {
            top: 9px;
            left: 9px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: white;
        }

        .card-bg {
            border-radius: 10px;
            background: #2D2D2D !important;
        }

        .juryBord {
            background: #2D2D2D;
            border-radius: 6px;
            padding: 15px 0px;
        }

        .from-contro-day {
            border: 1px solid #2D2D2D !important;
            border-radius: 10px !important;
        }

        .jurys-group-name {
            text-align: center;
            width: 80px;
            border-top-left-radius: 10px;
            border-bottom-right-radius: 10px
        }

        .juryBord input {
            margin: 0px 15px;
            margin: 0px 15px;
            background: #0A0909;
            color: #fff;
            font-weight: 600;
            font-size: 30px;
            padding: 0;
            border: none;
            text-align: center;
            border-radius: 7px;
        }

        .juryBord p {
            padding-left: 20px;
        }
    </style>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Create Audition Rules</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Create New Audition Rules</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <style>
        .AddC {
            border-color: 1px solid gold !important;
        }
    </style>
    <div class="content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-header">
                    {{-- <h3 class="card-title">Create New Audition Rules</h3> --}}
                    {{-- <a class="btn    btn-sm" style="float: right;"
                    onclick="Show('New Audition','{{ route('superAdmin.events.create') }}')"><i
                    class=" fa fa-plus"></i>&nbsp;New Audition</a> --}}
                </div>
                <form id="create-form">
                    @csrf
                    <!-- /.card-header -->
                    <div class="card-body d-flex justify-content-between mx-2">


                        <div class="row">

                            <div class="col-md-3 my-2 mx-auto">

                                <div class=" WidthEvent">
                                    <div class="divS my-3">
                                        <center>
                                            <img src="{{ asset('assets/super-admin/images/Category.png') }}" class="mb-1"
                                                width="35" height="35" alt="">
                                            <p style=" margin-bottom: 16px;"><b class="fw-bold pt-4"
                                                    style="color:#F8EE00;font-size: 20px;">Select
                                                    Category</b>
                                            </p>
                                        </center>
                                    </div>

                                    <div class=" border-warning mx-5 mt-3 mb-5">
                                        @if (isset($categories[0]))
                                            @foreach ($categories as $key => $category)
                                                <label class="container"><span
                                                        style="color:#F8EE00; font-size: 16px; margin-bottom: 18px">{{ $category->name }}</span>
                                                    <input type="radio" name="category_id" class="radioBtnClass "
                                                        value="{{ $category->id }}"
                                                        {{ $category->id == $rule->category_id ? 'checked' : '' }}
                                                        onchange="resetAll()">
                                                    <span class="checkmark"></span>
                                                </label>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 my-2 mx-auto">
                                <div class=" WidthEvent" style="position: relative">
                                    <div class="divS my-2">
                                        <center>
                                            <img src="{{ asset('assets/super-admin/images/select.png') }}" class="mb-1"
                                                width="35" height="35" alt="">
                                            <p style=" margin-bottom: 16px;"><b class="fw-bold pt-4"
                                                    style="color:#F8EE00;font-size: 20px;">Select
                                                    Rounds</b>
                                            </p>
                                        </center>
                                    </div>

                                    <div class=" border-warning centerContent">
                                        {{-- <div class=" mx-5 mt-2 mb-3 my-5 responsiveRound">
                                            <span data-decrease class="minus btn btn-sm  btnRes NumAdd">-</span>

                                            <input data-value id="round"
                                                class="Number inputColor text-center fw-bold p-3 mx-2 " type="text"
                                                value="{{ isset($rule) ? $rule->round_num : 0 }}" min="0" disabled />
                                            <span class="btn btn-sm minus NumAdd btnRes" data-increase>+</span>
                                        </div> --}}

                                        <div class="d-flex flex-row resDiv justify-content-center my-5"
                                            style="padding: 5rem 0 !important;">
                                            <span data-decrease class="btn btn-sm minus NumAdd">-</span>

                                            <input data-value id="round"
                                                class="Number inputColor mx-2 text-center fw-bold" type="text"
                                                value="{{ isset($rule) ? $rule->round_num : 0 }}" min="0" disabled />

                                            <span class="btn btn-sm minus NumAdd" data-increase>+</span>
                                        </div>

                                        <div class="centeredSXSThird d-flex justify-content-center px-2 pt-2 mx-3 mt-5">
                                            <div>

                                                <b class="text-danger">#Note :</b><br>
                                                <small>You can’t create more than 8 rounds</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 my-2 mx-auto">
                                <div class=" WidthEvent" style="position: relative">
                                    <div class="divS my-2">
                                        <center>
                                            <img src="{{ asset('assets/super-admin/images/star.png') }}" class="mb-1"
                                                width="35" height="35" alt="">
                                            <p style=" margin-bottom: 16px;"><b class="fw-bold pt-4"
                                                    style="color:#F8EE00;font-size: 20px;">Select
                                                    Judges</b>
                                            </p>
                                        </center>
                                    </div>

                                    <div class=" border-warning centerContent">
                                        {{-- <div class="mx-5 mt-2 mb-3 my-5 responsiveRound">
                                            <span data-decrease class="btn btn-sm minus btnRes  NumAdd">-</span>
                                            <input data-value id="superstar"
                                                class="Number inputColor text-center fw-bold  p-3 mx-2 " type="text"
                                                value="{{ isset($rule) ? $rule->judge_num : 0 }}" />
                                            <span class="btn btn-sm  btnRes  minus NumAdd" data-increase>+</span>
                                        </div> --}}
                                        <div class="d-flex flex-row justify-content-center my-5"
                                            style="padding: 5rem 0 !important;">
                                            <span data-decrease class="btn btn-sm minus NumAdd">-</span>

                                            <input data-value id="superstar"
                                                class="Number inputColor mx-2 text-center fw-bold" type="text"
                                                value="{{ isset($rule) ? $rule->judge_num : 0 }}" />

                                            <span class="btn btn-sm minus NumAdd" data-increase>+</span>
                                        </div>
                                        <div class="centeredSXSThird d-flex justify-content-center px-1 mt-5 pt-2 mx-2">
                                            <div>

                                                <b class="text-danger">#Note :</b><br>
                                                <small> You can’t create more than 3 superstars</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 my-2 mx-auto">
                                <div class=" WidthEvent py-2" style="position: relative">
                                    <div class="divS mt-2">
                                        <center>
                                            <img src="{{ asset('assets/super-admin/images/jury.png') }}" class="mb-1"
                                                width="35" height="35" alt="">
                                            <p style=" margin-bottom: 16px;"><b class="fw-bold pt-4"
                                                    style="color:#F8EE00;font-size: 20px;">Select
                                                    Jurys</b>
                                            </p>
                                        </center>
                                    </div>

                                    <div class="border-warning m-3">
                                        @if (isset($groups[0]))
                                            @foreach ($groups as $key => $group)
                                                <div class="card card-bg">
                                                    <div class='bg-warning jurys-group-name'> {{ $group->name }}</div>
                                                    <div class="d-flex flex-column juryBord">

                                                        <div class="d-flex flex-row justify-content-center">
                                                            <span data-decrease class="btn btn-sm minus NumAdd">-</span>
                                                            <input type="hidden" name="groups_id[]"
                                                                value="{{ $group->id }}" />
                                                            <input data-value id="jury-{{ $group->id }}"
                                                                name="group_members[]" type="text"
                                                                class="w-25 inputColor" type="text"
                                                                value="{{ $group_data != null ? $group_data[$key] : 0 }}" />
                                                            <span class="btn btn-sm minus NumAdd" data-increase>+</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif

                                        <div class="centeredSXSThird d-flex justify-content-center px-1 pt-2">
                                            <div>

                                                <b class="text-danger">#Note :</b><br>
                                                <small>You can’t create more than 23 jurys</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 my-2 mx-auto">
                                <div class=" WidthEvent" style="position: relative">
                                    <div class="divS mt-2">
                                        <center>
                                            <img src="{{ asset('assets/super-admin/images/table.png') }}" class="mb-1"
                                                width="35" height="35" alt="">
                                            <p style=" margin-bottom: 16px;"><b class="fw-bold pt-4"
                                                    style="color:#F8EE00;font-size: 20px;">Event
                                                    Time</b>
                                            </p>
                                        </center>
                                    </div>

                                    <h6 class="text-center bg-dark p-2 my-3"> Select Time :</h6>
                                    {{-- <center><small>Select Time : </small></center> --}}

                                    <div class=" border-warning mx-5 mt-5 mb-3">

                                        <div class="sds">
                                            <div class="row  mb-3">
                                                <label for="" class="text-warning">Event Period (Day)</label>
                                                <input type="text" class="form-control from-contro-day"
                                                    name="event_period" placeholder="Enter Event day"
                                                    value="{{ $rule->event_period > 0 ? $rule->event_period : '' }}">
                                                <span id="event_preiod_error" class="text-danger"></span>
                                            </div>
                                            <div class="row  mt-2 mb-5">
                                                <label for="" class="text-warning">Registration Period
                                                    (Day)</label>
                                                <input type="text" class="form-control from-contro-day"
                                                    name="registration_period" placeholder="Enter Registration Period"
                                                    value="{{ $rule->registration_period > 0 ? $rule->registration_period : '' }}">
                                                <span id="registration_preiod_error" class="text-danger"></span>
                                            </div>

                                            {{-- <div class="row justify-content-around mt-2">
                                            <label for="">Instruction Prepare Period</label>
                                            <input type="text" class="form-control from-contro-day" name="instruction_prepare_period" placeholder="2 days" value="{{ $rule->instruction_prepare_period > 0 ? $rule->instruction_prepare_period : '' }}">
                                        <span id="instruction_prepare_period_error" class="text-danger"></span>
                                    </div> --}}
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>








                    </div>
                    <!-- /.card-body -->

                    <center>
                        <div class="row mb-3">
                            <div class="col-md-4 row mx-auto">
                                <div class="col-md-6">
                                    <button class="btn btnBack w-100 fw-bold">

                                        <a href="{{ route('superAdmin.audition-rules.index') }}" class="fw-bold">Back</a>
                                    </button>
                                </div>
                                <div class="col-md-6">

                                    <button class="btn btnConfirm w-100 fw-bolder"
                                        id="submitAuditionRules">Confirm</button>
                                </div>
                            </div>
                        </div>
                    </center>

                </form>
            </div>

        </div> <!-- container -->
    </div> <!-- content -->

    <script>
        // resetAll();
        function resetAll() {
            if ($("input[type='radio'].radioBtnClass").is(':checked')) {
                var category_id = $("input[type='radio'].radioBtnClass:checked").val();
            }
            var url = "{{ url('super-admin/audition-rules') }}";
            // var rule_id = "{{ $rule->id }}";
            $.ajax({
                url: url + "/" + category_id, // your request url
                type: 'GET',
                success: function(data) {
                    window.open(url + '/' + data.rules.id + '/edit', '_parent');
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
        }
        $(document).on('click', '#submitAuditionRules', function(event) {
            event.preventDefault();
            ErrorMessageClear();
            var form = $('#create-form')[0];
            // var category_id = "";
            if ($("input[type='radio'].radioBtnClass").is(':checked')) {
                var category_id = $("input[type='radio'].radioBtnClass:checked").val();
            }
            var category_id = category_id;
            var round_num = $("#round").val();
            var judge_num = $("#superstar").val();
            var month = $("#root3").text();
            var day = $("#root4").text();
            var formData = new FormData(form);
            formData.append('category_id', category_id);
            formData.append('round_num', round_num);
            formData.append('judge_num', judge_num);
            // Set header if need any otherwise remove setup part
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
                }
            });
            $.ajax({
                url: "{{ route('superAdmin.audition-rules.store') }}", // your request url
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
                },
                error: function(data) {
                    $.each(data.responseJSON.errors, function(key, value) {
                        ErrorMessage(key, value);
                    });
                }
            });
        });
    </script>
@endsection
