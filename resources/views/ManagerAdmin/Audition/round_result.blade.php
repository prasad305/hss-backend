@extends('Layouts.ManagerAdmin.master')

@push('title')
    Admin
@endpush

@section('content')
    <style>
        .completedMeetupBlack {
            background-color: #151515 !important;
            border-radius: 10px;
        }

        .BGa {
            border: 1px solid rgb(255, 217, 0);
        }

        .BGaB {
            border: 1px solid goldenrod;


        }

        .GoldBtn {
            background: linear-gradient(90deg, #FFCE00 0%, #DFA434 100%) !important;
            border-radius: 25px;
        }

        .GoldBtn:hover {
            background: rgb(16, 20, 29) !important;
            color: white;
            border: 1px solid #FFCE00 !important;
        }

        .BlueBtn {
            background: linear-gradient(90deg, #22AADD 0%, #3A8FF2 100%);
            border-radius: 25px;
        }

        .BlueBtn:hover {
            background: rgb(16, 20, 29) !important;
            color: white;
            border: 1px solid rgb(0, 183, 255) !important;
        }

        .bottomBlackLine {
            border-bottom: 2px solid white;
        }

        .displaySide {
            display: flex;
            justify-content: center
        }

        .fontBold {
            font-size: 40px;
            font-weight: 800;
        }

        .view-rslt {
            background: linear-gradient(90deg, rgba(2, 0, 36, 1) 0%, rgba(9, 79, 121, 1) 0%, rgba(0, 212, 255, 1) 100%);
        }

        .view-rslt:hover {
            background: linear-gradient(90deg, rgba(2, 0, 36, 1) 0%, rgba(40, 126, 167, 1) 0%, rgba(0, 212, 255, 1) 100%);
        }

        .apel-rslt {
            background: linear-gradient(270deg, #ffad00, #ffd273 18.7%, #e19a04 42.13%, #facf75 68.82%, #e7a725 85.94%, #ffad00);
            /* color: #000 !important;     */
        }

        .apel-rslt:hover {
            background: linear-gradient(to bottom, #ffcc00 0%, #ffff66 100%);

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


    <div class="row m-3">
        @foreach ($auditions as $val)
            <!--card-->

            <div class="col-sm-12 col-md-4 col-lg-3">
                <div class="card">
                    <div class="panel panel-primary p-2 text-center">


                        <img src="{{ asset($val->banner) }}" class="img-fluid card-img" />

                        <div class="panel-body pt-1">
                            <h5 class="text-ellipsis-line-1">{{ $val->title }}</h5>

                            <a href="{{ route('managerAdmin.audition.showRoundResult', $val->id) }}" type="button"
                                class="btn btnPublish waves-effect waves-light mb-2">Round Result</a>
                            @if ($val->activeRoundInfo->appeal == 1)
                                <a href="{{ route('managerAdmin.audition.viewRoundAppealResult', $val->id) }}"
                                    type="button" class="btn btnDetails waves-effect fw-bold waves-light mb-2">Appeal
                                    Result</a>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
            <!--card end-->
        @endforeach
    </div>


   
@endsection
