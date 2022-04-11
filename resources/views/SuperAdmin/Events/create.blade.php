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
                <h1 class="m-0">Events</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Create New Audition</li>
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
                <h3 class="card-title">Update Music Audition</h3>
                {{-- <a class="btn btn-success btn-sm" style="float: right;"
                        onclick="Show('New Audition','{{ route('superAdmin.events.create') }}')"><i
                    class=" fa fa-plus"></i>&nbsp;New Audition</a> --}}
            </div>
            <!-- /.card-header -->
            <div class="card-body d-flex justify-content-between mx-2">

                <div class=" WidhtEvent ">
                    <div class="divS mt-3">
                        <center>
                            <img src="{{ asset('assets/super-admin/images/Category.png') }}" width="35" height="35"
                                alt="">
                            <p><b class="text-warning fw-bold pt-4">Select Category</b></p>
                        </center>
                    </div>

                    <div class=" border-warning mx-5 mt-3 mb-3">
                        <input type="checkbox" class="CheckIB" id="vehicle1" name="vehicle1" value="Bike">
                        <label class="mx-3 text-warning" for="vehicle1"> Sports</label><br>
                        <input type="checkbox" class="CheckIB" id="vehicle1" name="vehicle1" value="Bike">
                        <label class="mx-3 text-warning" for="vehicle1">Music</label><br>
                        <input type="checkbox" class="CheckIB" id="vehicle2" name="vehicle2" value="Car">
                        <label class="mx-3 text-warning" for="vehicle2"> Film</label><br>
                        <input type="checkbox" class="CheckIB" id="vehicle3" name="vehicle3" value="Boat">
                        <label class="mx-3 text-warning" for="vehicle3">Dance</label><br>
                        <input type="checkbox" class="CheckIB" id="vehicle1" name="vehicle1" value="Bike">
                        <label class="mx-3 text-warning" for="vehicle1">Teaching</label><br>
                        <input type="checkbox" class="CheckIB" id="vehicle2" name="vehicle2" value="Car">
                        <label class="mx-3 text-warning" for="vehicle2"> Comedy</label><br>
                        <input type="checkbox" class="CheckIB" id="vehicle3" name="vehicle3" value="Boat">
                        <label class="mx-3 text-warning" for="vehicle3">Drama</label>
                    </div>
                </div>

                <div class=" WidhtEvent " style="position: relative">
                    <div class="divS mt-3">
                        <center>
                            <img src="{{ asset('assets/super-admin/images/Category.png') }}" width="35" height="35"
                                alt="">
                            <p><b class="text-warning fw-bold pt-4">Select Category</b></p>
                        </center>
                    </div>

                    <div class=" border-warning mx-5 mt-3 mb-3">
                        <div class="centeredSX">
                            <button class="minus NumAdd" onclick="decrement()">-</button> <b
                                class="text-warning Number p-3 mx-3" id="root">01</b> <button class=" NumAdd plus"
                                onclick="increment()">+</button>
                        </div>
                        <div class="centeredSXS text-center">
                            <b class="text-danger">#Note:</b><br>
                            <small>You can’t create more than 6 rounds</small>
                        </div>
                    </div>
                </div>

                <div class=" WidhtEvent " style="position: relative">
                    <div class="divS mt-3">
                        <center>
                            <img src="{{ asset('assets/super-admin/images/star.png') }}" width="35" height="35" alt="">
                            <p><b class="text-warning fw-bold pt-4">Select SuperStar</b></p>
                        </center>
                    </div>

                    <div class=" border-warning mx-5 mt-3 mb-3">
                        <div class="centeredSX">
                            <button class="minus NumAdd" onclick="decrement1()">-</button> <b
                                class="text-warning Number p-3 mx-3" id="root1">01</b> <button class=" NumAdd plus"
                                onclick="increment1()">+</button>
                        </div>
                        <div class="centeredSXS text-center">
                            <b class="text-danger">#Note:</b><br>
                            <small> You can’t create more than 4 superstars</small>
                        </div>
                    </div>
                </div>

                <div class=" WidhtEvent " style="position: relative">
                    <div class="divS mt-3">
                        <center>
                            <img src="{{ asset('assets/super-admin/images/jury.png') }}" width="35" height="35" alt="">
                            <p><b class="text-warning fw-bold pt-4">Select Jurys</b></p>
                        </center>
                    </div>

                    <div class=" border-warning mx-5 mt-3 mb-3">
                        <div class="centeredSX">
                            <button class="minus NumAdd" onclick="decrement2()">-</button> <b
                                class="text-warning Number p-3 mx-3" id="root2">01</b> <button class=" NumAdd plus"
                                onclick="increment2()">+</button>
                        </div>
                        <div class="centeredSXS text-center">
                            <b class="text-danger">#Note:</b><br>
                            <small>You can’t create more than 8 jurys</small>
                        </div>
                    </div>
                </div>

                <div class=" WidhtEvent"  style="position: relative">
                    <div class="divS mt-3">
                        <center>
                            <img src="{{ asset('assets/super-admin/images/table.png') }}" width="35" height="35" alt="">
                            <p><b class="text-warning fw-bold pt-4">Select Time</b></p>
                        </center>
                    </div>
                    <center><small>Select Time : </small></center>

                    <div class=" border-warning mx-5 mt-3 mb-3">

                        <div class="sds">
                            <div class="row justify-content-around">
                                <button class="d-flex ms-2">+</button>
                                <button class="d-flex ms-2">+</button>
                            </div>

                            <div class="row justify-content-around">
                                <b class="d-flex ms-2 selects px-3 ">0</b>
                                <b class="d-flex ms-2 selects px-3 ">0</b>
                            </div>

                            <div class="row justify-content-around">
                                <button class="d-flex ms-2">+</button>
                                <button class="d-flex ms-2">+</button>
                            </div>
                        </div>

                        <div class="centeredSXS text-center">
                            <b class="text-danger">#Note:</b><br>
                            <small>You can’t create more than 8 jurys</small>
                        </div>
                        
                    </div>



                </div>
            </div>
            <!-- /.card-body -->

            <center>
                <div class="Footerbtn">
                    {{-- <a href="{{ route('superAdmin.events.edit',1) }}"> <li class="breadcrumb-item active">Events List</li></a> --}}
                    <a href="{{ route('superAdmin.events.index') }}"><button class="btn Back">Back</button></a>
                    <button class="btn Confirm">Update</button>
                </div>
            </center>
        </div>


    </div> <!-- container -->
</div> <!-- content -->

@endsection
