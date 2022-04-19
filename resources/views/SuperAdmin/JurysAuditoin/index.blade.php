@extends('Layouts.SuperAdmin.master')
@push('title')
Audition Admin
@endpush

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
    /* Style the search field */
    form.example input[type=text] {
        padding: 4px 2px 2px 3px;
        font-size: 17px;
        border: 1px solid grey;
        float: left;
        width: 70%;
        background: #f1f1f1;
    }

    /* Style the submit button */
    form.example button {
        padding: 4px 2px 2px 3px;
        float: left;
        width: 20%;
        background: #21f3bf;
        color: white;
        font-size: 17px;
        border: 1px solid grey;
        border-left: none;
        /* Prevent double borders */
        cursor: pointer;
        margin-right: 10px;
    }

    form.example button:hover {
        background: #0b7dda;
    }

    /* Clear floats */
    form.example::after {
        content: "";
        clear: both;
        display: table;
    }

    .ImgBlue {
        border-radius: 50%;
        width: 130px;
        height: 130px;
        border: 2px solid white;
    }

    .Free{
        background: #2EFF82;
/* shadow */

box-shadow: 0px 2px 25px rgba(67, 86, 84, 0.1);
border-radius: 10px;
    }


</style>

<br>
<!-- /.content-header -->
<div class="content ">
    <div class="container-fluid ">
        <div class="row float-right">
            <!-- Right navbar links -->

            <form class="example" action="action_page.php">
                <input type="text" placeholder="Search.." name="search">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>

            <button type="button" class="btn btn-success btn-sm mr-4" data-toggle="dropdown"
                style="float: right; margin-bottom: 10px;">
                <i class=" fa fa-filter"></i> Filter
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="">Show assigned jurrys</a>
                <a class="dropdown-item" href="">Show reserved jurrys</a>
            </div>
            <a class="btn btn-success btn-sm mr-4" style="float: right; margin-bottom: 10px;"
                {{-- onclick="Show('New Audition Admin','{{ route('managerAdmin.auditionAdmin.create') }}')" --}}>
                <i class=" fa fa-plus"></i>&nbsp;Add New</a>
        </div>
        <!-- =========================================================== -->
        <h4 class="mb-2">Jury list</h4>

        <hr>
    </div>
</div>

{{-- <div class=" bg-dark shadow-none">
    <div>
        <img src="{{ asset('assets/super-admin/images/unsplash_hUHzaiAHuUc (1).png') }}" alt="Admin Image"
class="img-fluid ImgBlue mr-3 mb-2">
</div>

<div>
    <h5 class="text-center text-bold">Oni Hasan</h5>
    <p class="text-center">
        Music Specialist</p>
</div>
</div> --}}

<div class="row">
    <div class="col-md-3 col-sm-6 col-12">
        <div class="card bg-dark m-2">
            <center class="BGa">
                <img src="{{ asset('assets/super-admin/images/unsplash_hUHzaiAHuUc (1).png') }}" alt="Admin Image"
                    class="img-fluid ImgBlue mr-3 mb-2 mt-2">
                <div class="mt-2">
                    <h5 class="text-center text-bold">Oni Hasan</h5>
                    <p class="text-center">
                        Music Specialist</p>
                </div>
                <button class="btn bg-warning px-5 text-bold mt-2 mb-2">Assigned</button>
            </center>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <div class="card bg-dark m-2">
            <center class="BGa">
                <img src="{{ asset('assets/super-admin/images/unsplash_hUHzaiAHuUc (1).png') }}" alt="Admin Image"
                    class="img-fluid ImgBlue mr-3 mb-2 mt-2">
                <div class="mt-2">
                    <h5 class="text-center text-bold">Rafa</h5>
                    <p class="text-center">Music Specialist</p>
                </div>
                <button class="btn Free px-5 text-bold mt-2 mb-2">Free now</button>
            </center>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-12">
        <div class="card bg-dark m-2">
            <center class="BGa">
                <img src="{{ asset('assets/super-admin/images/unsplash_hUHzaiAHuUc (1).png') }}" alt="Admin Image"
                    class="img-fluid ImgBlue mr-3 mb-2 mt-2">
                <div class="mt-2">
                    <h5 class="text-center text-bold">Oni Hasan</h5>
                    <p class="text-center">
                        Music Specialist</p>
                </div>
                <button class="btn bg-warning px-5 text-bold mt-2 mb-2">Assigned</button>
            </center>
        </div>
    </div>

</div>

@endsection
