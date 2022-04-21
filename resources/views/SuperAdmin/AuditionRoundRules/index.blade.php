@extends('Layouts.SuperAdmin.master')

@push('title')
Super Admin
@endpush

@section('content')

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
    <li class="nav-item custom-nav-item m-2 TextBH">
        <a class="nav-link border-warning " data-toggle="tab" href="#tabs-1" role="tab">
            <center>
                <img src="{{ asset('assets/super-admin/images/Music.png') }}" class="ARRimg pt-2" alt="">
            </center>
            <a class="btn border-warning nav-link active " data-toggle="tab" href="#tabs-1" role="tab">Music</a>
        </a>

    </li>
    <li class="nav-item custom-nav-item m-2 ">
        <a class="nav-link border-warning" data-toggle="tab" href="#tabs-2" role="tab">
            <center>
                <img src="{{ asset('assets/super-admin/images/sports.png') }}" class="ARRimg pt-2" alt="">
            </center>
            <a class="btn border-warning nav-link " data-toggle="tab" href="#tabs-2" role="tab">Sports</a>
        </a>
    </li>
    <li class="nav-item custom-nav-item m-2 ">
        <a class="nav-link border-warning" data-toggle="tab" href="#tabs-3" role="tab">
            <center>
                <img src="{{ asset('assets/super-admin/images/dance.png') }}" class="ARRimg pt-2" alt="">
            </center>
            <a class="btn border-warning nav-link " data-toggle="tab" href="#tabs-3" role="tab">Dance</a>
        </a>
    </li>
    <li class="nav-item custom-nav-item m-2 ">
        <a class="nav-link border-warning" data-toggle="tab" href="#tabs-4" role="tab">
            <center>
                <img src="{{ asset('assets/super-admin/images/drama.png') }}" class="ARRimg pt-2" alt="">
            </center>
            <a class="btn border-warning nav-link " data-toggle="tab" href="#tabs-4" role="tab">Drama</a>
        </a>
    </li>
    <li class="nav-item custom-nav-item m-2 ">
        <a class="nav-link border-warning" data-toggle="tab" href="#tabs-5" role="tab">
            <center>
                <img src="{{ asset('assets/super-admin/images/comedy.png') }}" class="ARRimg pt-2" alt="">
            </center>
            <a class="btn border-warning nav-link " data-toggle="tab" href="#tabs-5" role="tab">Comedy</a>
        </a>
    </li>
    <li class="nav-item custom-nav-item m-2 ">
        <a class="nav-link border-warning" data-toggle="tab" href="#tabs-6" role="tab">
            <center>
                <img src="{{ asset('assets/super-admin/images/kids.png') }}" class="ARRimg pt-2" alt="">
            </center>
            <a class="btn border-warning nav-link " data-toggle="tab" href="#tabs-6" role="tab">Kids</a>
        </a>
    </li>
    <li class="nav-item custom-nav-item m-2 ">
        <a class="nav-link border-warning" data-toggle="tab" href="#tabs-7" role="tab">
            <center>
                <img src="{{ asset('assets/super-admin/images/tech.png') }}" class="ARRimg pt-2" alt="">
            </center>
            <a class="btn border-warning nav-link " data-toggle="tab" href="#tabs-7" role="tab">Tech</a>
        </a>
    </li>
    <li class="nav-item custom-nav-item m-2 ">
        <a class="nav-link border-warning custom-navx" data-toggle="tab" href="#tabs-8" role="tab">
            <center>
                <img src="{{ asset('assets/super-admin/images/chef.png') }}" class="ARRimg pt-2" alt="">
            </center>
        </a>
        <p class="btn nav-link border-warning mnssa" data-toggle="tab" href="#tabs-8" role="tab">Chef</p>
    </li>
    <li class="nav-item custom-nav-item m-2 ">
        <a class="nav-link border-warning custom-navx" data-toggle="tab" href="#tabs-9" role="tab">
            <center>
                <img src="{{ asset('assets/super-admin/images/chef.png') }}" class="ARRimg pt-2" alt="">
            </center>
        </a>
        <p class="btn nav-link border-warning mnssa" data-toggle="tab" href="#tabs-9" role="tab">Extra</p>
    </li>
</ul><!-- Tab panes -->

<div class="tab-content m-4">
    <h3>Audition List Edit</h3>
    <hr>
</div>

<div class="tab-content m-4">

    <div class="tab-pane active" id="tabs-1" role="tabpanel">

        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item custom-nav-item m-2 TextBH">
                <a class="nav-link border-warning text-warning font-weight-bold" data-toggle="tab" href="#tabs-1"
                    role="tab">
                    <center class="mb-2">
                        <h4>Round</h4>
                        <span class="bg-gray p-1 btn ">01</span>
                    </center>
                    <a class="btn border-warning nav-link " data-toggle="tab" href="#tabs-90" role="tab">Rolls</a>
                </a>
            </li>
            <li class="nav-item custom-nav-item m-2 TextBH">
                <a class="nav-link border-warning text-warning font-weight-bold " data-toggle="tab" href="#tabs-91"
                    role="tab">
                    <center class="mb-2">
                        <h4>Round</h4>
                        <span class="bg-gray p-1 btn ">02</span>
                    </center>
                    <a class="btn border-warning nav-link " data-toggle="tab" href="#tabs-91" role="tab">Rolls</a>
                </a>
            </li>
            <li class="nav-item custom-nav-item m-2 TextBH">
                <a class="nav-link border-warning text-warning font-weight-bold " data-toggle="tab" href="#tabs-92"
                    role="tab">
                    <center class="mb-2">
                        <h4>Round</h4>
                        <span class="bg-gray p-1 btn ">03</span>
                    </center>
                    <a class="btn border-warning nav-link " data-toggle="tab" href="#tabs-92" role="tab">Rolls</a>
                </a>
            </li>

        </ul>

        <div class="tab-content m-4">
            <div class="tab-pane " id="tabs-90" role="tabpanel">
                <div class="container">

                    <div class="row">

                        <div class="d-flex  justify-content-between BorderInSA p-2 m-1 col-md-12">
                            <div class="text-light mt-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" id="customCheckbox2" name="customCheck"
                                        class="custom-control-input">
                                    <label class="custom-control-label" for="customCheckbox2"><span class="px-3">User Vote</span></label>
                                </div>
                            </div>
                            <div class="text-light"><input type="text" class="Chexka form-control" placeholder="NA">
                            </div>
                        </div>
                        <div class="d-flex  justify-content-between BorderInSA p-2 m-1 col-md-12">
                            <div class="text-light mt-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" id="customCheckbox2" name="customCheck"
                                        class="custom-control-input">
                                    <label class="custom-control-label" for="customCheckbox2"><span class="px-3">Jury Mark</span></label>
                                </div>
                            </div>
                            <div class="text-light"><input type="text" class="Chexka form-control" placeholder="30">
                            </div>
                        </div>
                        <div class="d-flex  justify-content-between BorderInSA p-2 m-1 col-md-12">
                            <div class="text-light mt-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" id="customCheckbox2" name="customCheck"
                                        class="custom-control-input">
                                    <label class="custom-control-label" for="customCheckbox2"><span class="px-3">Stae Mark</span></label>
                                </div>
                            </div>
                            <div class="text-light"><input type="text" class="Chexka form-control" placeholder="40">
                            </div>
                        </div>
                        <div class="d-flex col-md-12 justify-content-center mt-4 mb-4">
                            <button class="btn bg-warning px-3 BTNdone"  data-toggle="modal" data-target="#exampleModalCenter">Done</button>
                        </div>

                    </div>
                </div>
            </div>
            <div class="tab-pane " id="tabs-91" role="tabpanel">
                <p>ewr Panel</p>
            </div>
            <div class="tab-pane " id="tabs-92" role="tabpanel">
                <p>93 Panel</p>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="background: #151515;
                border: 1px solid #FFD910;
                box-sizing: border-box;
                border-radius: 10px;">
                    <center>
                        <img src="{{ asset('assets/super-admin/images/modal.png') }}" width="150" class="p-3" alt="">
                        <div>
                            <h5 class="text-warning">Event Create</h5>
                            <h4 class="text-warning"> <b> Succesfully Done!!</b></h4>
                        </div>

                        <button type="button" class="btn  px-3 m-4" data-dismiss="modal" style="
                        background: #ADF1E7;color:black;
                        border-radius: 10px;">Done</button>
                    </center>
                </div>
            </div>
        </div>

    </div>

    <div class="tab-pane" id="tabs-2" role="tabpanel">
        <p>Second Panel</p>
    </div>
    <div class="tab-pane" id="tabs-3" role="tabpanel">
        <p>Third Panel</p>
    </div>
    <div class="tab-pane" id="tabs-4" role="tabpanel">
        <p>Four Panel</p>
    </div>
    <div class="tab-pane" id="tabs-5" role="tabpanel">
        <p>5Panel</p>
    </div>

    <div class="tab-pane" id="tabs-6" role="tabpanel">
        <p>6 Panel</p>
    </div>

    <div class="tab-pane" id="tabs-7" role="tabpanel">
        <p>7 Panel</p>
    </div>
    <div class="tab-pane" id="tabs-8" role="tabpanel">
        <p>8 Panel</p>
    </div>
    <div class="tab-pane" id="tabs-9" role="tabpanel">
        <p>9 Panel</p>
    </div>
</div>

@endsection
