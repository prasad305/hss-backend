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
    @include('ManagerAdmin.Audition.includes.audition-sub-nav')
    <div class="bg-gray mx-2 my-3">

        <div class="row">
            <div class="col-md-12">
                <div class="row bg-black-custom">
                    <h4 class="mx-3">Events list</h4>
                    <a class="btn btn-success btn-sm mr-4 " style="margin-bottom: 10px; margin-left: auto;"
                        href="{{ route('managerAdmin.audition.create') }}">
                        <i class=" fa fa-plus"></i>&nbsp;Add New
                    </a>
                </div>
            </div>
        </div>


        <div class="row mt-3 mx-2">
            @foreach ($auditions as $audition)
                <!--card-->
                <div class="col-sm-12 col-md-4 col-lg-3">
                    <div class="card">
                        <div class="panel panel-primary p-2 text-center">

                            <img src="@if (isset($audition->banner)) {{ asset($audition->banner) }}
                @else {{ asset('assets/manager-admin/clock.png') }} @endif"
                                alt="Admin Image" class="img-fluid card-img">

                            <div class="panel-body pt-1">
                                <h5 class="text-ellipsis-line-1">{{ $audition->title }}</h5>

                                <a href="{{ route('managerAdmin.audition.registerUser', $audition->id) }}"
                                    class="btn btnPublish waves-effect waves-light mb-2">Register User</a>

                                @if ($audition->audition_admin_id == null)
                                    <a href="{{ route('managerAdmin.audition.assignManpower', $audition->id) }}"
                                        class="btn btnPending waves-effect fw-bold waves-light mb-2">Assign Manpower</a>
                                @else
                                @endif
                            </div>

                        </div>
                    </div>
                    <!--card end-->
            @endforeach
        </div>


    </div>

    </div>
@endsection
