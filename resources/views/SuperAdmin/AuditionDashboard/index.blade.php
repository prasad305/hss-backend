@extends('Layouts.SuperAdmin.master')

@push('title')
Super Admin
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
        background: rgb(16, 20, 29)!important;
        color: white;
        border: 1px solid #FFCE00 !important;
    }

    .BlueBtn {
        background: linear-gradient(90deg, #22AADD 0%, #3A8FF2 100%);
        border-radius: 25px;
    }

    .BlueBtn:hover {
        background: rgb(16, 20, 29)!important;
        color: white;
        border: 1px solid rgb(0, 183, 255) !important;
    }

    /* .ImgBlue{
        height: 150px;
        width: 100% !important;
    } */
</style>

<div class="row">
    <div class="col-md-12 mx-2 mt-3">
        <h4>Events list</h4>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col-md-3 col-sm-6 col-12">
        <div class="row info-box bg-dark shadow-none pb-4 m-3 BGa">
            <img src="{{ asset('assets/super-admin/images/unsplash_hUHzaiAHuUc (1).png') }}" alt="Admin Image"
                class="img-fluid ImgBlue mr-3 mb-2">

            <div className="d-flex py-3 justify-contnet-center ">
                <div >
                    <h5 class="text-center text-bold">Guitar Competition</h5>
                    <p class="text-center">Lorem Ipsum is simply dummy text of the printing and typesetting
                        industry. Lorem
                        Ipsum has been. </p>
                        <center><button class="text-center btn GoldBtn px-4 text-bold ">On Going</button></center>

                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-12">
        <div class="row info-box bg-dark shadow-none pb-4 m-3 BGaB">
            <img src="{{ asset('assets/super-admin/images/unsplash_hUHzaiAHuUc.png') }}" alt="Admin Image"
                class="img-fluid ImgBlue mr-3 mb-2">

            <div className="d-flex py-3 justify-contnet-center ">
                <div >
                    <h5 class="text-center text-bold">Swimming Competition</h5>
                    <p class="text-center">Lorem Ipsum is simply dummy text of the printing and typesetting
                        industry. Lorem
                        Ipsum has been. </p>
                        <center><button class="text-center btn BlueBtn px-4 text-bold ">Done</button></center>

                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-12">
        <div class="row info-box bg-dark shadow-none pb-4 m-3 BGaB">
            <img src="{{ asset('assets/super-admin/images/unsplash_hUHzaiAHuUc (2).png') }}" alt="Admin Image"
                class="img-fluid ImgBlue mr-3 mb-2">

            <div className="d-flex py-3 justify-contnet-center ">
                <div >
                    <h5 class="text-center text-bold">Football Competition</h5>
                    <p class="text-center">Lorem Ipsum is simply dummy text of the printing and typesetting
                        industry. Lorem
                        Ipsum has been. </p>
                        <center><button class="text-center btn BlueBtn px-4 text-bold ">Done</button></center>

                </div>
            </div>
        </div>
    </div>

</div>
    <div class="row">
        <div class="col-md-12 mx-2 mt-3">
            <h4>Audition Admin List</h4>
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-light shadow-none pt-4 pb-4 m-3">
                <img src="http://localhost:8000/assets/manager-admin/avatarProfile.png" alt="Admin Image"
                    class="img-fluid AdminImg mr-3 mt-4">
                <div class="px-2 mt-3" style="border-left: 1px solid gray">
                    <a href="">
                        <span class="info-box-text AdminName">
                            <h5 class="" style="color: black">Aktaruzzaman Joti</h5>
                        </span>
                        <b class="AdminMusic">Music</b> <br />
                    </a>
                    {{-- <span class="right badge bg-danger my-2">Assigned</span>
                <i class="fa-solid fa-bahai px-2 text-danger"></i><br>
                <p class="AtifAdmin">Atif Aslam</p> --}}

                    <!-- <a class="btn btn-sm btn-info">
                    <i class="fa fa-edit text-white"></i>
                </a> -->
                    <!-- <button class="btn btn-sm btn-warning" >
                    <i class="fa fa-trash"></i>
                </button> -->
                </div>
            </div>
        </div>
    </div>
    @endsection
