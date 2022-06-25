@extends('Layouts.ManagerAdmin.master')

@push('title')
    Edit Audition Rules
@endpush

@section('content')

    <style>
        .audition_type{
            width: 100px;
            height: 134px;
            background: #E1C116;
            border-radius: 5px;
            padding: 2px;
        }
        .audition_type img{
            padding: 10px 0px;
            width: 73%;
            margin: 0 auto;
        }
        .audition_type p{
            background: #151515;
            text-align: center;
            padding: 5px 0px;
            border-radius: 5px;
            color: #E1C116;
            font-size: 12px;
            font-weight: bold;
        }

        .audition__rules{
            height: 100%;
            width: 100%;
            background: #151515;
            padding: 20px 10px;
            border-radius: 6px;
            border: 1px solid #eecd1e;
        }
        .audition__rules p{
            font-weight: 500;
            font-size: 20px;
            letter-spacing: 0.5px;
            margin-bottom: 0px;
        }
        .audition__rules hr{
            margin: 10px 0px;
            height: 0px;
            background: #797979;
        }
        .audition__rules__summary{
            height: 225px;
            width: auto;
            background: #2D2D2D;
            border-radius: 6px;
        }
        .audition__rules__summary__item{
            width: 160px;
            height: auto;
            border: 1px solid #e8af06;
            text-align: center;
            border-radius: 5px;
            margin: 20px 0px;
        }
        .audition__rules__summary__item img{
            width: 25px;
            margin: 0 auto;
            padding: 10px 0px 0px;
        }
        .audition__rules__summary__item p{
            font-size: 14px;
            padding: 5px 0px;
            color: #f7e80a;
        }
        .audition__rules__summary__item div{
            border-top: 1px solid #e8af06;
            background: #151515;
            height: 64%;
            border-radius: 5px;
            justify-content: center;
            align-items: center;
            display: flex;
        }
        .audition__rules__summary__item div h3{
            font-weight: bold;
            font-size: 40px;
            background: #0a0909;
            padding: 0px 10px;
            border-radius: 6px;
        }

        .audition__rules__final__time{
            background: #2d2d2d;
            width: 60%;
            margin: 0 auto;
            padding: 18px;
            border-radius: 6px;
        }
        .audition__rules__final__time img{
            width: 30px;
        }
        .audition__rules__final__time p{
            font-weight: bold;
            padding-left: 20px;
            font-size: 22px;
            letter-spacing: 1.5px;
            line-height: 36px;
        }

        .audition__rules__summary__item__two{
            width: 160px;
            height: auto;
            border: 1px solid #e8af06;
            text-align: center;
            border-radius: 5px;
            margin: 20px 0px;
        }
        .audition__rules__summary__item__two p{
            font-size: 14px;
            padding: 5px 0px;
            color: #f7e80a;
        }
        .audition__rules__summary__item__two img{
            width: 25px;
            margin: 0 auto;
            padding: 10px 0px 0px;
        }

        .audition__rules__summary__item__two > div{
            border-top: 1px solid #e8af06;
            background: #151515;
            height: 64%;
            border-radius: 5px;
            justify-content: center;
            align-items: center;
            display: flex;
        }


        .audition__rules__summary__item__two .month__date__word{
            background: #0a0909;
            padding: 4px 10px;
            border-bottom: 0.5px solid #484848;
            border-radius: 4px 4px 0 0;
            font-size: 14px;
            font-weight: bold;
        }
        .audition__rules__summary__item__two .month__date__numeric{
            background: #0a0909;
            padding: 4px 16px;
            border-radius: 0 0 4px 4px;
            font-size: 14px;
            font-weight: bold;
        }

        .audition__rule__time{}
        .audition__rule__time p{
            font-size: 18px;
            font-weight: bold;
        }
        .audition__rule__time__item{
            border: 1px solid #b7aeae;
            border-radius: 5px;
            padding: 5px 10px;
        }
        .audition__rule__time__item input{
            border: 2px solid #fdd700;
            appearance: none;
            /* border-radius: 50%;
            width: 14px;
            height: 14px; */
            transition: all ease-in 0.2s;
            margin-top: 10px;
        }

        .audition__rule__time__item input[type='radio']:checked{
            border: 1px solid #FFD910;
            background: #FFD910;
        }


        .audition__rule__time__item__user{
            font-size: 14px !important;
            font-weight: initial !important;
            padding: 7px;
        }
        .audition__rule__time__item__time img{
            width: 22px;
            height: 22px;
            margin-right: 5px;
            border-radius: 50%;
        }
        .audition__rule__time__item__time{
            background: rgba(55, 52, 52, 0.75) !important;
            font-size: 12px!important;
            font-weight: inherit!important;
            border-radius: 20px;
            padding: 7px 28px 0px;
            min-height: 27px;
        }

        .audition__rule__time__item span{
            font-size: 12px !important;
            padding: 10px;
        }


        .audition__round__summary .round__wrap{
            border: 2px solid #FFCE00;
            border-radius: 8px;
            min-width: 160px;
            background: #2D2D2D;
            padding-top: 7px;
        }

        .audition__round__summary .audition__round__button_active {
            background: #FFD910;
            border: 2px solid #FFD910;
            border-radius: 4px;
        }
        .audition__round__summary .audition__round__text{
           color: #FFD910;
        }
        .audition__round__summary .audition__round__number{
            background: #151515;
            display: inline-block;
            padding: 0px 4px;
            border-radius: 5px;
            margin-bottom: 5px;
            margin-top: 7px;
            font-weight: bold;
            font-size: 22px;
            color: #FFD910;
        }

        .audition__round__summary .audition__round__button__inactive {
            background: #151515;
            border-top: 2px solid #FFD910;
            border-radius: 4px;
            color: #FFD910;
            border-bottom: 0;
            border-right: 0;
            border-left: 0;
        }
    </style>

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                {{--<div class="col-sm-6">
                    <h1 class="m-0">Create Audition Reg. Rules</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Create New Audition Reg. Rules</li>
                    </ol>
                </div>--}}<!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="content">
        <div class="container-fluid">

            <div class="audition_type d-flex flex-column">
                <img src="{{asset($audition->category ? $audition->category->icon : '')}}" class="img-fluid" alt="music">
                <p>{{$audition->category ? $audition->category->name : ''}}</p> 
            </div>

            <div class="audition__rules d-flex flex-column my-4">
                <p>{{ $audition->title }}</p>
                <hr>
                <div class="audition__rules__summary d-flex flex-row justify-content-around">

                    <div class="audition__rules__summary__item d-flex flex-column">
                        <img src="{{asset('assets/manager-admin/select.png')}}" class="img-fluid" alt="music">
                        <p>Rounds</p>
                        <div>
                            <h3>{{ $audition->auditionRules ? $audition->auditionRules->round_num : '' }}</h3>
                        </div>
                    </div>

                    <div class="audition__rules__summary__item">
                        <img src="{{asset('assets/manager-admin/star.png')}}" class="img-fluid" alt="star">
                        <p style="padding: 2px 0px">SuperStart</p>
                        <div>
                            <h3>{{ $audition->auditionRules ? $audition->auditionRules->judge_num : '' }}</h3>
                        </div>
                    </div>

                    <div class="audition__rules__summary__item">
                        <img src="{{asset('assets/manager-admin/jury.png')}}" class="img-fluid" alt="jury">
                        <p>Jurys</p>
                        <div>
                            @foreach($groups as $key => $group)
                                <span>Group {{ juryGroup($group) }} : </span>
                                <h3>{{ $juries_num[$key] }}</h3>
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
                                <div class="pr-2">{{ $audition->auditionRules ? $audition->auditionRules->month : '' }}</div>
                                <div class="pl-3">{{ $audition->auditionRules ? $audition->auditionRules->day : '' }}</div>
                            </div>
                        </div>
                    </div>
                </div>




                <div class="audition__round__summary d-flex flex-row justify-content-around mt-4 mb-3">
                    @if (isset($round_rules[0]))
                    @foreach ($round_rules as $key => $round)
                        <div class="text-center round__wrap" onclick="changeRound('{{$round->id}}')">
                            <p class="font-weight-bold audition__round__text">Round</p>
                            <div class="audition__round__number">{{ $key+1 }}</div>
                            <button class="w-100 audition__round__button_active">Rolls</button>
                        </div>
                    @endforeach
                    @endif
                   

                    {{-- <div class="text-center round__wrap">
                        <p class="font-weight-bold audition__round__text">Round</p>
                        <div class="audition__round__number">02</div>
                        <button class="w-100 audition__round__button__inactive">Rolls</button>
                        </div> --}}


                </div>

               <div id="round_rules">
                
               </div>

        </div>
    </div>

    <script>
        function changeRound(round_id) {
            // alert(round_id);
            $("#round_rules").html('');
            
            var url = "{{ url('manager-admin/audition/registration-rules/') }}";
            console.log(url + "/" + round_id);
            $.ajax({
                url: url + "/" + round_id, // your request url
                type: 'GET',
                success: function(data) {
                    $("#round_rules").append(data);
                },
                error: function(data) {
                    $("#round_rules").html('Sorry!! Something Went Wrong.');
                }
            });

        }

      
    </script>

@endsection

