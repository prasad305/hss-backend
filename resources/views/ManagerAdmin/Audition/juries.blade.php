@extends('Layouts.ManagerAdmin.master')

@push('title')
    Admin
@endpush

@section('content')
    <div>
        <div class="d-flex justify-content-between marginTopAdminList">
            <div>
                <p class='AdminListText'>Jury list</p>
            </div>
            <div class="d-flex">

                <div class="search-container mx-2">
                    <form action="/search" method="get">
                        <input class="search expandright" id="searchright" type="search" name="q" placeholder="Search">
                        <label class="button searchbutton" for="searchright"><span
                                class="mglass">&#9906;</span></label>
                    </form>
                </div>

                <br>

                <div>
                    <button class='btn filterBtn'><i class="fa-solid fa-arrow-down-short-wide"></i> Filter</button>
                </div>
                <div class='mx-2'>
                    <button class='btn filterBtn'><i class="fa-solid fa-circle-plus"></i> New</button>
                </div>
            </div>
        </div>

        <div class='borderBottom'>
        </div>

        <div class="row">
            <div class="col-sm-6 col-md-4  col-lg-3">
                <div class=" bg-dark shadow-none pb-4 m-3 BGaB">
                    <img src="{{ asset('assets/manager-admin/events/person-2.png') }}" class="img-fluid w-100 h-75"style="max-height:200px borderRadius: 50% " alt="Admin Image"
                        class="img-fluid ImgBlue mr-3 mb-2 w-100">

                    <div className="">
                        <div>
                            <h5 class="text-muted text-center">Oni Hasan</h5>
                            <h6 class="text-muted text-center">Music</h6>
                            <p class="text-muted text-center">Specialist</p>

                            <center>
                                <a type="button" class="btn reg-btn-user ">Assigned <i class="fa fa-angle-double-right"></i></a>

                            </center>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4  col-lg-3">
                <div class=" bg-dark shadow-none pb-4 m-3 BGaB">
                    <img src="{{ asset('assets/manager-admin/events/person-2.png') }}" class="img-fluid w-100"style="max-height:200px borderRadius: 50% " alt="Admin Image"
                        class="img-fluid ImgBlue mr-3 mb-2 w-100">

                    <div className="">
                        <div>
                            <h5 class="text-muted text-center">Oni Hasan</h5>
                            <h6 class="text-muted text-center">Music</h6>
                            <p class="text-muted text-center">Specialist</p>

                            <center>
                                <button class="border-0 p-2 detail-btn-use" style="width: 100px">Free <i class="fa fa-angle-double-right"></i></button >

                            </center>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4  col-lg-3">
                <div class=" bg-dark shadow-none pb-4 m-3 BGaB">
                    <img src="{{ asset('assets/manager-admin/events/person-2.png') }}" class="img-fluid w-100"style="max-height:200px borderRadius: 50% " alt="Admin Image"
                        class="img-fluid ImgBlue mr-3 mb-2 w-100">

                    <div className="">
                        <div>
                            <h5 class="text-muted text-center">Oni Hasan</h5>
                            <h6 class="text-muted text-center">Music</h6>
                            <p class="text-muted text-center">Specialist</p>

                            <center>
                                <a type="button" class="btn  reg-btn-user ">Assigned<i class="fa fa-angle-double-right"></i></a>

                            </center>

                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class='col-sm-6 col-md-4  col-lg-3 '>
                <div class="card m-3" style=" backgroundColor: black;">
                    <div class="card-body">
                        <div class="text-center d-flex justify-content-center">
                            <img src={{ asset('assets/manager-admin/events/person-2.png') }} alt=""   class="img-fluid ImgBlue mr-3 mb-2 w-100">
                                  
                        </div>
                        <h5 class="text-muted text-center">Oni Hasan</h5>
                        <h6 class="text-muted text-center">Music</h6>
                        <p class="text-muted text-center">Specialist</p>
                    </div>
                    <div class="text-center mb-2">
                        <button class="btn btn-success"> Free Now</button>

                    </div>
                </div>
            </div>
            <div class='col-sm-6 col-md-4  col-lg-3'>
                <div class="card m-3" style="  backgroundColor: black;  ">
                    <div class="card-body">
                        <div class="text-center d-flex justify-content-center">
                            <img src={{ asset('assets/manager-admin/events/person-3.png') }} alt="" height="150"
                                width="150" style=" borderRadius: 50% " />
                        </div>
                        <h5 class="text-muted text-center">Oni Hasan</h5>
                        <h6 class="text-muted text-center">Music</h6>
                        <p class="text-muted text-center">Specialist</p>
                    </div>
                    <div class="text-center mb-2">
                        <button class="btn btn-danger"> Assigned</button>

                    </div>
                </div>
            </div> --}}
        </div>

    </div>

    <style>
        .marginTopAdminList {
            margin-top: 4rem;
        }

        .borderBottom {
            border: 1px solid gray;
        }

        .AdminListText {
            font-size: 30px;
            margin-left: 2rem
        }

        .filterBtn {
            margin-top: 2px;
            background-color: #3c506f;
            width: 150px;
            height: 50px;
            border-radius: 10px;
            color: #ffffff;
            border: 1px solid gray;
        }

        .button {
            display: inline-block;
            margin: 4px 2px;
            background-color: #3c506f;
            font-size: 14px;
            padding-left: 32px;
            padding-right: 0px;
            height: 50px;
            border: 1px solid gray;
            border-radius: 10px;
            line-height: 50px;
            text-align: center;
            color: white;
            text-decoration: none;
            cursor: pointer;
            -moz-user-select: none;
            -khtml-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .button:hover {
            transition-duration: 0.4s;
            -moz-transition-duration: 0.4s;
            -webkit-transition-duration: 0.4s;
            -o-transition-duration: 0.4s;
            background-color: white;
            color: black;
        }

        .search-container {
            position: relative;
            display: inline-block;
            margin: 4px 2px;
            height: 50px;
            width: 50px;
            vertical-align: bottom;
        }

        .mglass {
            display: inline-block;
            pointer-events: none;
            -webkit-transform: rotate(-45deg);
            -moz-transform: rotate(-45deg);
            -o-transform: rotate(-45deg);
            -ms-transform: rotate(-45deg);
        }

        .searchbutton {
            position: absolute;
            font-size: 22px;
            width: 100%;
            margin: 0;
            padding: 0;
        }

        .search:focus+.searchbutton {
            transition-duration: 0.4s;
            -moz-transition-duration: 0.4s;
            -webkit-transition-duration: 0.4s;
            -o-transition-duration: 0.4s;
            background-color: white;
            color: black;
        }

        .search {
            position: absolute;
            left: 49px;
            /* Button width-1px (Not 50px/100% because that will sometimes show a 1px line between the search box and button) */
            background-color: white;
            outline: none;
            border: none;
            padding: 0;
            width: 0;
            height: 100%;
            z-index: 10;
            transition-duration: 0.4s;
            -moz-transition-duration: 0.4s;
            -webkit-transition-duration: 0.4s;
            -o-transition-duration: 0.4s;
        }

        .search:focus {
            width: 363px;
            /* Bar width+1px */
            padding: 0 16px 0 0;
        }

        .expandright {
            left: auto;
            right: 49px;
            /* Button width-1px */
        }

        .expandright:focus {
            padding: 0 0 0 16px;
        }

        /* .testing {
                                                                                                                                            position: relative;
                                                                                                                                        } */

        .AdminImg {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;

        }

        .AdminName {
            color: black;
            font-size: 1rem;
        }

        .AdminMusic {
            color: #638BC9 !important:
        }

        .AtifAdmin {
            color: #FF602E;
        }


        @media only screen and (min-width: 1100px) and (max-width: 1400px) {

            .AdminName {
                white-space: nowrap;
                width: 8vw;
                overflow: hidden;
            }
        }

        @media only screen and (max-width: 600px) {
            .AdminListText {
                font-size: 15px;
            }
        }

    </style>
@endsection
