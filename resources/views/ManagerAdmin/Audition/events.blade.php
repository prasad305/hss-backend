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
        border: 1px solid rgb(0, 204, 255);
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
    <div class="row">
        @foreach ($auditions as $audition)
            <div class="col-md-3 col-sm-6 col-12">
                <div class="p-2 bg-dark shadow-none pb-4 m-3 BGaB">
                    <img src="{{ asset($audition->banner ?? get_static_option('audition_demo_image')) }}" alt="Admin Image"
                        class="img-fluid ImgBlue mr-3 mb-2 w-100">

                <div className="">
                    <div>
                        <h5 class="text-center text-bold">{{ $audition->title }}</h5>

                        <a href="{{ route('managerAdmin.audition.promoInstruction', $audition->id) }}" class="btn a-bg-color mb-2">Promo Instruction</a>
                        <a href="{{ route('managerAdmin.audition.roundInstruction', $audition->id) }}" class="btn a-bg-color mb-2">Round Instruction</a>
                        <a href="{{ route('managerAdmin.audition.registerUser', $audition->id) }}" class="btn a-bg-color mb-2">Register User</a>

                                {{-- <span class="text-center btn btn-info px-4 text-bold">Done</span> --}}
                                {{-- <a href="{{ route('managerAdmin.audition.promoInstruction', $audition->id) }}"
                                    class="btn btn-warning">Promo Instruction</a><br>

                                <a href="{{ route('managerAdmin.audition.roundInstruction', $audition->id) }}"
                                    class="btn btn-warning">Round Instruction</a><br> --}}


                                @if ($audition->audition_admin_id == null)
                                    <a href="{{ route('managerAdmin.audition.assignManpower', $audition->id) }}"
                                        class="btn btn-warning m-2">Assign Manpower</a>
                                @else
                                    <a href="{{ route('managerAdmin.audition.registerUser', $audition->id) }}"
                                        class="btn btn-warning">Register User</a>
                                @endif
                            </center>

                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>

</div>
@endsection
