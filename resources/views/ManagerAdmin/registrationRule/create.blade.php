@extends('Layouts.ManagerAdmin.master')

@push('title')
Create new audition rules
@endpush

@section('content')

<style>
    .audition_type {
        width: 100px;
        height: 134px;
        background: #E1C116;
        border-radius: 5px;
        padding: 2px;
    }

    .audition_type img {
        padding: 10px 0px;
        width: 73%;
        margin: 0 auto;
    }

    .audition_type p {
        background: #151515;
        text-align: center;
        padding: 5px 0px;
        border-radius: 5px;
        color: #E1C116;
        font-size: 12px;
        font-weight: bold;
    }

    .audition__rules {
        height: 100%;
        width: 100%;
        background: #151515;
        padding: 20px 10px;
        border-radius: 6px;
        border: 1px solid #eecd1e;
    }

    .audition__rules p {
        font-weight: 500;
        font-size: 20px;
        letter-spacing: 0.5px;
        margin-bottom: 0px;
    }

    .audition__rules hr {
        margin: 10px 0px;
        height: 0px;
        background: #797979;
    }

    .audition__rules__summary {
        height: 225px;
        width: auto;
        background: #2D2D2D;
        border-radius: 6px;
    }

    .audition__rules__summary__item {
        width: 160px;
        height: auto;
        border: 1px solid #e8af06;
        text-align: center;
        border-radius: 5px;
        margin: 20px 0px;
    }

    .audition__rules__summary__item img {
        width: 25px;
        margin: 0 auto;
        padding: 10px 0px 0px;
    }

    .audition__rules__summary__item p {
        font-size: 14px;
        padding: 5px 0px;
        color: #f7e80a;
    }

    .audition__rules__summary__item div {
        border-top: 1px solid #e8af06;
        background: #151515;
        height: 64%;
        border-radius: 5px;
        justify-content: center;
        align-items: center;
        display: flex;
    }

    .audition__rules__summary__item div h3 {
        font-weight: bold;
        font-size: 40px;
        background: #0a0909;
        padding: 0px 10px;
        border-radius: 6px;
    }

    .audition__rules__summary__item__two {
        width: 160px;
        height: auto;
        border: 1px solid #e8af06;
        text-align: center;
        border-radius: 5px;
        margin: 20px 0px;
    }

    .audition__rules__summary__item__two p {
        font-size: 14px;
        padding: 5px 0px;
        color: #f7e80a;
    }

    .audition__rules__summary__item__two img {
        width: 25px;
        margin: 0 auto;
        padding: 10px 0px 0px;
    }

    .audition__rules__summary__item__two>div {
        border-top: 1px solid #e8af06;
        background: #151515;
        height: 64%;
        border-radius: 5px;
        justify-content: center;
        align-items: center;
        display: flex;
    }


    .audition__rules__summary__item__two .month__date__word {
        background: #0a0909;
        padding: 4px 10px;
        border-bottom: 0.5px solid #484848;
        border-radius: 4px 4px 0 0;
        font-size: 14px;
        font-weight: bold;
    }

    .audition__rules__summary__item__two .month__date__numeric {
        background: #0a0909;
        padding: 4px 22px;
        border-radius: 0 0 4px 4px;
        font-size: 16px;
        font-weight: bold;
    }

    .audition__rules__final__time {
        background: #2d2d2d;
        width: 60%;
        margin: 0 auto;
        padding: 18px;
        border-radius: 6px;
    }

    .audition__rules__final__time img {
        width: 30px;
    }

    .audition__rules__final__time p {
        font-weight: bold;
        padding-left: 20px;
        font-size: 22px;
        letter-spacing: 1.5px;
        line-height: 36px;
    }

    .audition__rule__time {}

    .audition__rule__time p {
        font-size: 18px;
        font-weight: bold;
    }

    .audition__rule__time__item {
        border: 1px solid #b7aeae;
        border-radius: 5px;
        padding: 5px 10px;
    }

    /* .audition__rule__time__item input{
            border: 2px solid #fdd700;
            appearance: none;
            border-radius: 50%;
            width: 14px;
            height: 14px;
            transition: all ease-in 0.2s;
            margin-top: 10px;
        } */
    .audition__rule__time__item input {
        /* border: 2px solid #fdd700; */
        /* appearance: none; */
        border-radius: 10px;
        background-color: #343434;
        color: white;
        /* width: 14px; */
        /* height: 14px; */
        /* transition: all ease-in 0.2s; */
        /* margin-top: 10px; */
    }

    .audition__rule__time__item input[type='checkbox']:checked {
        border: 1px solid #FFD910;
        background: #FFD910;
    }


    .audition__rule__time__item__user {
        font-size: 14px !important;
        font-weight: initial !important;
        padding: 7px;
    }

    .audition__rule__time__item__time img {
        width: 22px;
        height: 22px;
        margin-right: 5px;
        border-radius: 50%;
    }

    .audition__rule__time__item__time {
        background: rgba(55, 52, 52, 0.75) !important;
        font-size: 12px !important;
        font-weight: inherit !important;
        border-radius: 20px;
        padding: 7px 28px 0px;
        min-height: 27px;
    }

    .audition__rule__time__item span {
        font-size: 12px !important;
        padding: 10px;
    }

    .checktime {
        margin-top: 10px !important;
        width: 20px;
        height: 20px;
        accent-color: #e7d03c;
    }
</style>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="audition_type d-flex flex-column">
            <img src="{{asset($audition->category ? $audition->category->icon : '')}}" class="img-fluid" alt="music">
            <p>{{$audition->category ? $audition->category->name : ''}}</p>
        </div>

        <div class="audition__rules d-flex flex-column my-4">
            <p>{{$audition->title}}</p>
            <hr>
            <div class="audition__rules__summary d-flex flex-row justify-content-around">
                <div class="audition__rules__summary__item d-flex flex-column">
                    <img src="{{asset('assets/manager-admin/select.png')}}" class="img-fluid" alt="music">
                    <p>Rounds</p>
                    <div>
                        <h3>{{$audition->auditionRules ? $audition->auditionRules->round_num : ''}}</h3>
                    </div>
                </div>
                <div class="audition__rules__summary__item">
                    <img src="{{asset('assets/manager-admin/star.png')}}" class="img-fluid" alt="star">
                    <p style="padding: 2px 0px">Judges</p>
                    <div>
                        <h3>{{$audition->auditionRules ? $audition->auditionRules->judge_num : ''}}</h3>
                    </div>
                </div>
                <div class="audition__rules__summary__item">
                    <img src="{{asset('assets/manager-admin/jury.png')}}" class="img-fluid" alt="jury">
                    <p>Juries</p>
                    <div>
                        @foreach ($groups as $key => $group)
                        <span>Group {{juryGroup($group)}} : </span>
                        <h3>{{$juries_num[$key]}}</h3>
                        @endforeach

                    </div>
                </div>

                <div class="audition__rules__summary__item__two">
                    <img src="{{asset('assets/manager-admin/table.png')}}" class="img-fluid" alt="calender">
                    <p>Select time</p>
                    <div class="d-flex flex-column">
                        <div class="d-flex flex-row month__date__word">
                            <div class="pr-2">Month</div>
                            <div class="pr-2">Day</div>
                        </div>
                        <div class="d-flex flex-row month__date__numeric">
                            <div class="pr-2">{{$audition->auditionRules ? $audition->auditionRules->month : ''}}</div>
                            <div class="pl-3">{{$audition->auditionRules ? $audition->auditionRules->day : ''}}</div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="audition__rules__final__time d-flex flex-row justify-content-center my-4">
                <img src="{{asset('assets/manager-admin/table.png')}}" class="img-fluid" alt="calender">
                <p class="text-capitalize">{{$audition->auditionRules ? $audition->auditionRules->month : ''}} month
                    {{$audition->auditionRules ? $audition->auditionRules->day : ''}} day</p>
            </div>

            <form id="create-form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="audition_id" value="{{$audition->id}}">
                <div class="audition__rule__time d-flex flex-column">
                    <p>Post Requirement Before Started Rounds</p>
                    <div class="audition__rule__time__item d-flex flex-row my-1 justify-content-between">
                        <div class="d-flex flex-row">
                            <p class="audition__rule__time__item__user">User Registration Date</p>
                        </div>
                        <div class="d-flex flex-row mr-4">

                            <input type="text" class="form-control" id="datepicker" name="registration_start_date" value="{{date('Y-m-d',strtotime($audition->user_reg_start_date))}}">
                            &nbsp;<h6 class="mt-2">To</h6>&nbsp;
                            <input type="text" class="form-control" id="datepicker1" name="registration_end_date" value="{{date('Y-m-d',strtotime($audition->user_reg_end_date))}}">
                        </div>
                    </div>

                    @if (isset($round_rules[0]))
                    @foreach ($round_rules as $key => $round)
                    <div class="audition__rule__time__item d-flex flex-row my-1 justify-content-between">
                        <div class="d-flex flex-row">
                            <input type="hidden" name="round_ids[]" value="{{$round->id}}">
                            <p class="audition__rule__time__item__user">Round {{ $key+1 }} time duration </p>
                        </div>
                        <div class="d-flex flex-row mr-4">
                            <input type="date" 
                            value="{{date('Y-m-d',strtotime($round->start_date))}}"
                            name="round_start_date[]" className='form-control'
                                min="{{\Carbon\Carbon::now()->format('Y-m-d')}}"
                                max="{{\Carbon\Carbon::now()->addDays($audition->auditionRules ? ($audition->auditionRules->month * 30 + $audition->auditionRules->day)  : 0)->format('Y-m-d')}}">
                            <span>To</span>
                            <input type="date" value="{{date('Y-m-d',strtotime($round->end_date))}}" name="round_end_date[]" className='form-control'
                                min="{{\Carbon\Carbon::now()->format('Y-m-d')}}"
                                max="{{\Carbon\Carbon::now()->addDays($audition->auditionRules ? ($audition->auditionRules->month * 30 + $audition->auditionRules->day)  : 0)->format('Y-m-d')}}">
                        </div>
                    </div>
                    @endforeach
                    @endif

                    <div class="audition__rule__time__item d-flex flex-row my-1 justify-content-between">
                        <div class="d-flex flex-row">
                            <p class="audition__rule__time__item__user">Final result publish date</p>
                        </div>
                        <div class="d-flex flex-row mr-4">
                            <input type="date" name="final_result_published_date" value="{{date('Y-m-d',strtotime($audition->final_result_published_date))}}" className='form-control'>
                        </div>
                    </div>

                    <div class="audition__rule__time__item d-flex flex-row my-1 justify-content-between">
                        <div class="d-flex flex-row">
                            <p class="audition__rule__time__item__user">Fees for the audition</p>
                        </div>
                        <div class="d-flex flex-row mr-4">
                            <input type="number" class="form-control" name="fees" value="{{$audition->fees}}">
                        </div>
                    </div>
                </div>

                <div class="my-4 text-right mr-4">
                    <button class="btn bg-info px-5" id="SubmitRules">Next</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>

</script>

@endsection

@push('js')
{{-- <script src="{{ asset('assets/manager-admin/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script> --}}
<script src="{{ asset('assets/manager-admin/pages/dashborad.js') }}"></script>


<script>
    $(function() {
            $("#datepicker").datepicker({
                minDate: "{{\Carbon\Carbon::now()->format('m/d/Y')}}",
                maxDate: "{{$audition->auditionRules ? '+'.($audition->auditionRules->month * 30 + $audition->auditionRules->day).'D'  : ''}}"
            });
        });

        $(function() {
            $("#datepicker1").datepicker({
                minDate: "{{\Carbon\Carbon::now()->format('m/d/Y')}}",
                maxDate: "{{$audition->auditionRules ? '+'.($audition->auditionRules->month * 30 + $audition->auditionRules->day).'D'  : ''}}"
            });
        });

  $(document).on('click','#SubmitRules',function (event) {
    
    event.preventDefault();
    ErrorMessageClear();
    var form = $('#create-form')[0];
    var formData = new FormData(form);

    // Set header if need any otherwise remove setup part
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
        }
    });
    $.ajax({
        url: "{{route('managerAdmin.audition.registration.rules.store')}}",// your request url
        data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (data) {
            Swal.fire(
                    'Success!',
                     data.message,
                    'success'
                )
                setTimeout(function() {
                    location.reload();
                }, 1000);
        },
        error: function (data) {
            $.each(data.responseJSON.errors, function(key, value) {
                ErrorMessage(key,value);
            });
        }
    });

});
       
</script>
@endpush

@push('script')
{{-- <script src="{{ asset('assets/manager-admin/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script> --}}
<script src="{{ asset('assets/manager-admin/pages/dashborad.js') }}"></script>
@endpush

@push('jsstyle')
<!-- <script src="https://code.jquery.com/jquery-3.6.0.js"></script> -->
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
@endpush