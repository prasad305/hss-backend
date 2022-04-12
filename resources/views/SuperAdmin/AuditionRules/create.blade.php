@extends('Layouts.SuperAdmin.master')

@push('title')
Super Admin
@endpush

@section('content')
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
                {{-- <a class="btn btn-success btn-sm" style="float: right;"
                        onclick="Show('New Audition','{{ route('superAdmin.events.create') }}')"><i
                    class=" fa fa-plus"></i>&nbsp;New Audition</a> --}}
            </div>
            <!-- /.card-header -->
            <div class="card-body d-flex justify-content-between mx-2">

                <div class=" WidhtEvent pys-3">
                    <div class="divS mt-3">
                        <center>
                            <img src="{{ asset('assets/super-admin/images/Category.png') }}" class="mb-1" width="35"
                                height="35" alt="">
                            <p><b class="fw-bold pt-4" style="color:#F8EE00;font-size: 20px;">Select Category</b></p>
                        </center>
                    </div>

                    <div class=" border-warning mx-5 mt-3 mb-5">
                        <div class="custom-control custom-checkbox mt-2">
                            <input id="checked" class="custom-control-input" type="checkbox" />
                            <label for="checked" class="custom-control-label fontLA">Sports</label>
                        </div>
                        <div class="custom-control custom-checkbox mt-2">
                            <input id="checked1" class="custom-control-input" type="checkbox" />
                            <label for="checked1" class="custom-control-label fontLA">Music</label>
                        </div>
                        <div class="custom-control custom-checkbox mt-2">
                            <input id="checked2" class="custom-control-input" type="checkbox" />
                            <label for="checked2" class="custom-control-label fontLA">Film</label>
                        </div>
                        <div class="custom-control custom-checkbox mt-2">
                            <input id="checked3" class="custom-control-input" type="checkbox" />
                            <label for="checked3" class="custom-control-label fontLA">Dance</label>
                        </div>
                        <div class="custom-control custom-checkbox mt-2">
                            <input id="checked4" class="custom-control-input" type="checkbox" />
                            <label for="checked4" class="custom-control-label fontLA">Teaching</label>
                        </div>
                        <div class="custom-control custom-checkbox mt-2">
                            <input id="checked5" class="custom-control-input" type="checkbox" />
                            <label for="checked5" class="custom-control-label fontLA">Comedy</label>
                        </div>
                        <div class="custom-control custom-checkbox mt-2">
                            <input id="checked6" class="custom-control-input" type="checkbox" />
                            <label for="checked6" class="custom-control-label fontLA">Drama</label>
                        </div>

                    </div>
                </div>

                <div class=" WidhtEvent " style="position: relative">
                    <div class="divS mt-2">
                        <center>
                            <img src="{{ asset('assets/super-admin/images/select.png') }}" class="mb-1" width="35"
                                height="35" alt="">
                            <p><b class="fw-bold pt-4" style="color:#F8EE00;font-size: 20px;">Select Rounds</b></p>
                        </center>
                    </div>

                    <div class=" border-warning mx-5 mt-2 mb-3">
                        <div class="centeredSX">
                            <button data-decrease class="minus NumAdd">-</button>
                            <input data-value class="Number text-center fw-bold p-3 mx-2 " type="text" value="0"
                                disabled />
                            <button class="minus NumAdd" data-increase>+</button>
                        </div>

                        <div class="centeredSXS text-center">
                            <b class="text-danger">#Note:</b><br>
                            <small>You can’t create more than 6 rounds</small>
                        </div>
                    </div>
                </div>

                <div class=" WidhtEvent " style="position: relative">
                    <div class="divS mt-2">
                        <center>
                            <img src="{{ asset('assets/super-admin/images/star.png') }}" class="mb-1" width="35"
                                height="35" alt="">
                            <p><b class="fw-bold pt-4" style="color:#F8EE00;font-size: 20px;">Select SuperStar</b></p>
                        </center>
                    </div>

                    <div class=" border-warning mx-5 mt-2 mb-3">
                        <div class="centeredSX">
                            <button data-decrease class="minus NumAdd">-</button>
                            <input data-value class="Number text-center fw-bold  p-3 mx-2 " type="text" value="0" />
                            <button class="minus NumAdd" data-increase>+</button>
                        </div>
                        <div class="centeredSXS text-center">
                            <b class="text-danger">#Note:</b><br>
                            <small> You can’t create more than 4 superstars</small>
                        </div>
                    </div>
                </div>

                <div class=" WidhtEvent " style="position: relative">
                    <div class="divS mt-2">
                        <center>
                            <img src="{{ asset('assets/super-admin/images/jury.png') }}" class="mb-1" width="35"
                                height="35" alt="">
                            <p><b class="fw-bold pt-4" style="color:#F8EE00;font-size: 20px;">Select Jurys</b></p>
                        </center>
                    </div>

                    <div class=" border-warning mx-5 mt-2 mb-3">
                        <div class="centeredSX">
                            <button data-decrease class="minus NumAdd">-</button>
                            <input data-value class="Number text-center fw-bold  p-3 mx-2 " type="text" value="0" />
                            <button class="minus NumAdd" data-increase>+</button>
                        </div>
                        <div class="centeredSXS text-center">
                            <b class="text-danger">#Note:</b><br>
                            <small>You can’t create more than 8 jurys</small>
                        </div>
                    </div>
                </div>

                <div class=" WidhtEvent" style="position: relative">
                    <div class="divS mt-2">
                        <center>
                            <img src="{{ asset('assets/super-admin/images/table.png') }}" class="mb-1" width="35"
                                height="35" alt="">
                            <p><b class="fw-bold pt-4" style="color:#F8EE00;font-size: 20px;">Select Time</b></p>
                        </center>
                    </div>
                    <center><small>Select Time : </small></center>

                    <div class=" border-warning mx-5 mt-5 mb-3">

                        <div class="sds">
                            <div class="row justify-content-around mb-2">
                                <button class="d-flex ms-2 NumAdd" onclick="increment3()">+</button>
                                <button class="d-flex ms-2 NumAdd" onclick="increment4()">+</button>
                            </div>
                            <div class="bg-dark card mb-2 py-1">
                                <div class="row justify-content-around py-2">
                                    <b class="d-flex ms-2  px-3 ">Month</b>
                                    <b class="d-flex ms-2  px-3 ">Day</b>
                                </div>

                                <div class="row justify-content-around pb-2">
                                    <b class="d-flex ms-2 selects px-3 " id="root3">0</b>
                                    <b class="d-flex ms-2 selects px-3 " id="root4">0</b>
                                </div>
                            </div>

                            <div class="row justify-content-around mt-2">
                                <button class="d-flex ms-2 NumAdd" onclick="decrement3()">-</button>
                                <button class="d-flex ms-2 NumAdd" onclick="decrement4()">-</button>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <!-- /.card-body -->

            <center>
                <div class="Footerbtn">
                    {{-- <a href="{{ route('superAdmin.events.edit',1) }}"> <li class="breadcrumb-item active">Events
                        List</li></a> --}}
                    <a href="{{ route('superAdmin.audition-rules.index') }}"><button class="btn Back">Back</button></a>
                    <button class="btn Confirm" data-toggle="modal" data-target="#exampleModalCenter">Confirm</button>
                </div>
            </center>
        </div>

        <!-- Button trigger modal -->

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

    </div> <!-- container -->
</div> <!-- content -->

@endsection
