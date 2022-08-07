@extends('Layouts.ManagerAdmin.master')

@push('title')
 Admin
@endpush

@section('content')

<div class="content text-center px-5 adminAssignPadding">

    <div class="container-fluid widgetUserPadding">

        <!-- Widget: user widget style 1 -->
        <div class=" card-widget widget-user paddingWidget">
            <!-- Add the bg color to the header using any of the bg-* classes -->

            <div class=" text-white AdminCover" style="background-image: url({{ asset('assets/manager-admin/adminAssignBg.png') }})">
                {{-- <h3 class="widget-user-username text-right">Elizabeth Pierce</h3>
                <h5 class="widget-user-desc text-right">Web Designer</h5> --}}

                <div class="centeredImg">
                    <img class="img-circle ImGAdmin" src="{{ asset('assets/manager-admin/freeNow.png') }}" alt="User Avatar">
                    <h4 class="text-center nameAdmin">Abdullah Al Zaber</h4>
                    <span class=" text-center fw-bold text-warning"><b>Music</b></span>
                </div>
            </div>

            <br /> <br /> <br/>

            <div class="mt-5 pt-2">

                <div class="container mt-5">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card Cardnew">
                                <div style="height:170px; width:100%;"
                                    class="justify-content-center  d-flex align-items-center">
                                    <div style="background-color:#ffff; border-radius:50%; border: 3px solid rgb(0, 183, 255); height:110px; width:110px; color:rgb(0, 183, 255); font-size:25px;"
                                        class="justify-content-center  d-flex align-items-center">
                                        <h4><b>-</b></h4>
                                    </div>
                                </div>
                                <h5 class="mb-5" style="color:#638bc9;">Star assigned</h5>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card Cardnew">
                                <div style="height:170px; width:100%;"
                                    class="justify-content-center  d-flex align-items-center">
                                    <div style="background-color:#ffff; border-radius:50%; border: 3px solid rgb(0, 183, 255); height:110px; width:110px; color:rgb(0, 183, 255); font-size:25px;"
                                        class="justify-content-center  d-flex align-items-center">
                                        <h4><b>-</b></h4>
                                    </div>
                                </div>
                                <h5 class="mb-5" style="color:#638bc9;">Event assigned</h5>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card Cardnew">
                                <div style="height:170px; width:100%;"
                                    class="justify-content-center  d-flex align-items-center">
                                    <div style="background-color:rgb(0, 183, 255); border-radius:50%; border: 2px solid rgba(190, 11, 11, 0.067); height:110px; width:110px; color:white; font-size:25px; "
                                        class="justify-content-center  d-flex align-items-center">
                                        <h4><b>12</b></h4>
                                    </div>
                                </div>
                                <h5 class="mb-5" style="color: #638bc9;">Event Completed</h5>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card Cardnew">
                                <div style="height:170px; width:100%;"
                                    class="justify-content-center  d-flex align-items-center">
                                    <div style="background-color:rgb(0, 183, 255); border-radius:50%; border: 2px solid rgba(190, 11, 11, 0.067); height:110px; width:110px; color:white; font-size:25px; "
                                        class="justify-content-center  d-flex align-items-center">
                                        <h4><b>12</b></h4>
                                    </div>
                                </div>
                                <h5 class="mb-5" style="color:#638bc9;">Months Supervised</h5>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row justify-content-center mt-5">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <button class="nav-link active btn  mx-2 bg-light" data-toggle="tab" href="#home">Cancel
                            </button>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('managerAdmin.audition.adminAssignSubmit')}}"><button class="nav-link btn  mx-2 bg-info">Assign
                            </button></a>
                        </li>
                    </ul>
                </div>

            </div>

            <!-- /.widget-user -->

        </div>

    </div>
</div>

    <style>
        .dark-mode .card {
            /* background-color: #343a40; */
            color: #fff;
        }
        .paddingWidget{
            padding: 20px !important;
        }
        .AdminCover {
            background-repeat: none !important;
            background-size: cover !important;
            /* object-fit: cover !important; */
            height: 350px !important;
            margin-bottom: 20px;
            border: 2px solid #ff0;
            border-radius: 15px;
        }


        .ImGAdmin {
            width: 180px !important;
            height: 180px !important;
            margin-top: 50px;
            border: 8px solid white;
        }

        .nav-tabs {
            border-bottom: none;
        }

        .centeredImg {
            position: absolute;
            top: 350px;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .Cardnew{
            background-color: #2d2d2d !important;
        }

        .nameAdmin{
            color: #ff0;
            font-weight: 700;
            fontSize: 25px;
            margin-top: 10px;
        }

        .adminAssignPadding{
            background-color: #000000;
        }
        .widgetUserPadding{
            border: 2px solid gray;
            border-radius: 10px;
        }


    </style>

@endsection
