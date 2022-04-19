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
  border-left: none; /* Prevent double borders */
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
</style>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                {{-- <h1 class="m-0">Audition Admin</h1> --}}
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Audition Admin List</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="content">
    <div class="container-fluid">
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
                <a class="dropdown-item" href="">Show assigned admins</a>
                <a class="dropdown-item" href="">Show reserved admins</a>
            </div>
            <a class="btn btn-success btn-sm mr-4" style="float: right; margin-bottom: 10px;"
                {{-- onclick="Show('New Audition Admin','{{ route('managerAdmin.auditionAdmin.create') }}')" --}}>
                <i class=" fa fa-plus"></i>&nbsp;Add New</a>
        </div>
        <!-- =========================================================== -->
        <h4 class="mb-2">Audition Admin List</h4>

        <hr>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box bg-dark shadow-none pt-4 pb-4 m-3">
                    <img src="http://localhost:8000/assets/manager-admin/avatarProfile.png" alt="Admin Image"
                        class="img-fluid AdminImg mr-3 mt-4">

                    <div class="px-2 mt-3" style="border-left: 1px solid gray">

                        <a href="">
                            <span class="info-box-text AdminName">
                                <h5 class="text-light">Aktaruzzaman Joti</h5>
                            </span>
                            <b class="AdminMusic">Music</b> <br />
                        </a>

                        <span class="right badge bg-danger my-2">Assigned</span>
                        <i class="fa-solid fa-bahai px-2 text-danger"></i><br>

                        <p class="AtifAdmin">Atif Aslam</p>

                        <!-- <a class="btn btn-sm btn-info">
                                                                                                                    <i class="fa fa-edit text-white"></i></a> -->

                        <!-- <button class="btn btn-sm btn-warning" ><i class="fa fa-trash"></i>
                                                                                                                </button> -->
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box bg-dark shadow-none pt-4 pb-4 m-3">
                    <img src="http://localhost:8000/assets/manager-admin/notAssigned.png" alt="Admin Image"
                        class="img-fluid AdminImg mr-3 mt-4">

                    <div class="px-2 mt-3" style="border-left: 1px solid gray">

                        <a href="">
                            <span class="info-box-text AdminName">
                                <h5 class="text-light">Srabon Hossain</h5>
                            </span>
                            <b class="AdminMusic">Music</b> <br />
                        </a>

                        <span class="right badge bg-success my-2">Not assigned</span>
                        <i class="fa-solid fa-bahai px-2 text-danger"></i><br>

                        <p class="AtifAdmin">Atif Aslam</p>

                        <!-- <a class="btn btn-sm btn-info">
                                                                                                                    <i class="fa fa-edit text-white"></i></a> -->

                        <!-- <button class="btn btn-sm btn-warning" ><i class="fa fa-trash"></i>
                                                                                                                </button> -->
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box bg-dark shadow-none pt-4 pb-4 m-3">
                    <img src="http://localhost:8000/assets/manager-admin/freeNow.png" alt="Admin Image"
                        class="img-fluid AdminImg mr-3 mt-4">

                    <div class="px-2 mt-3" style="border-left: 1px solid gray">

                        <a href="http://localhost:8000/manager-admin/audition/admin-assign">
                            <span class="info-box-text AdminName">
                                <h5 class="text-light">Abdullah Al Zabenr</h5>
                            </span>
                            <b class="AdminMusic">Music</b> <br />
                        </a>

                        <span class="right badge bg-warning my-2">Free now</span>
                        <i class="fa-solid fa-bahai px-2 text-danger"></i><br>

                        <p class="AtifAdmin">Atif Aslam</p>

                        <!-- <a class="btn btn-sm btn-info">
                                                                                                                    <i class="fa fa-edit text-white"></i></a> -->

                        <!-- <button class="btn btn-sm btn-warning" ><i class="fa fa-trash"></i>
                                                                                                                </button> -->
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box bg-dark shadow-none pt-4 pb-4 m-3">
                    <img src="http://localhost:8000/assets/manager-admin/avatarProfile.png" alt="Admin Image"
                        class="img-fluid AdminImg mr-3 mt-4">

                    <div class="px-2 mt-3" style="border-left: 1px solid gray">

                        <a href="">
                            <span class="info-box-text AdminName">
                                <h5 class="text-light">Aktaruzzaman Joti</h5>
                            </span>
                            <b class="AdminMusic">Music</b> <br />
                        </a>

                        <span class="right badge bg-danger my-2">Assigned</span>
                        <i class="fa-solid fa-bahai px-2 text-danger"></i><br>

                        <p class="AtifAdmin">Atif Aslam</p>

                        <!-- <a class="btn btn-sm btn-info">
                                                                                                                    <i class="fa fa-edit text-white"></i></a> -->

                        <!-- <button class="btn btn-sm btn-warning" ><i class="fa fa-trash"></i>
                                                                                                                </button> -->
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box bg-dark shadow-none pt-4 pb-4 m-3">
                    <img src="http://localhost:8000/assets/manager-admin/notAssigned.png" alt="Admin Image"
                        class="img-fluid AdminImg mr-3 mt-4">

                    <div class="px-2 mt-3" style="border-left: 1px solid gray">

                        <a href="">
                            <span class="info-box-text AdminName">
                                <h5 class="text-light">Srabon Hossain</h5>
                            </span>
                            <b class="AdminMusic">Music</b> <br />
                        </a>

                        <span class="right badge bg-success my-2">not Assigned</span>
                        <i class="fa-solid fa-bahai px-2 text-danger"></i><br>

                        <p class="AtifAdmin">Atif Aslam</p>

                        <!-- <a class="btn btn-sm btn-info">
                                                                                                                    <i class="fa fa-edit text-white"></i></a> -->

                        <!-- <button class="btn btn-sm btn-warning" ><i class="fa fa-trash"></i>
                                                                                                                </button> -->
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box bg-dark shadow-none pt-4 pb-4 m-3">
                    <img src="http://localhost:8000/assets/manager-admin/freeNow.png" alt="Admin Image"
                        class="img-fluid AdminImg mr-3 mt-4">

                    <div class="px-2 mt-3" style="border-left: 1px solid gray">

                        <a href="">
                            <span class="info-box-text AdminName">
                                <h5 class="text-light">Abdullah Al Zaber</h5>
                            </span>
                            <b class="AdminMusic">Music</b> <br />
                        </a>

                        <span class="right badge bg-warning my-2">free now</span>
                        <i class="fa-solid fa-bahai px-2 text-danger"></i><br>

                        <p class="AtifAdmin">Atif Aslam</p>

                        <!-- <a class="btn btn-sm btn-info">
                                                                                                                    <i class="fa fa-edit text-white"></i></a> -->

                        <!-- <button class="btn btn-sm btn-warning" ><i class="fa fa-trash"></i>
                                                                                                                </button> -->
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box bg-dark shadow-none pt-4 pb-4 m-3">
                    <img src="http://localhost:8000/assets/manager-admin/avatarProfile.png" alt="Admin Image"
                        class="img-fluid AdminImg mr-3 mt-4">

                    <div class="px-2 mt-3" style="border-left: 1px solid gray">

                        <a href="">
                            <span class="info-box-text AdminName">
                                <h5 class="text-light">Aktaruzzaman Joti</h5>
                            </span>
                            <b class="AdminMusic">Music</b> <br />
                        </a>

                        <span class="right badge bg-danger my-2">Assigned</span>
                        <i class="fa-solid fa-bahai px-2 text-danger"></i><br>

                        <p class="AtifAdmin">Atif Aslam</p>

                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box bg-dark shadow-none pt-4 pb-4 m-3">
                    <img src="http://localhost:8000/assets/manager-admin/notAssigned.png" alt="Admin Image"
                        class="img-fluid AdminImg mr-3 mt-4">

                    <div class="px-2 mt-3" style="border-left: 1px solid gray">

                        <a href="">
                            <span class="info-box-text AdminName">
                                <h5 class="text-light">Srabon Hossain</h5>
                            </span>
                            <b class="AdminMusic">Music</b> <br />
                        </a>

                        <span class="right badge bg-success my-2">not Assigned</span>
                        <i class="fa-solid fa-bahai px-2 text-danger"></i><br>

                        <p class="AtifAdmin">Atif Aslam</p>

                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box bg-dark shadow-none pt-4 pb-4 m-3">
                    <img src="http://localhost:8000/assets/manager-admin/freeNow.png" alt="Admin Image"
                        class="img-fluid AdminImg mr-3 mt-4">

                    <div class="px-2 mt-3" style="border-left: 1px solid gray">

                        <a href="">
                            <span class="info-box-text AdminName">
                                <h5 class="text-light">Abdullah Al Zabenr</h5>
                            </span>
                            <b class="AdminMusic">Music</b> <br />
                        </a>

                        <span class="right badge bg-warning my-2">free now</span>
                        <i class="fa-solid fa-bahai px-2 text-danger"></i><br>

                        <p class="AtifAdmin">Atif Aslam</p>

                        <!-- <a class="btn btn-sm btn-info">
                                                                                                                    <i class="fa fa-edit text-white"></i></a> -->

                        <!-- <button class="btn btn-sm btn-warning" ><i class="fa fa-trash"></i>
                                                                                                                </button> -->
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

        </div>
    </div>
</div>

<style>
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
</style>

<script>
    function activeNow(objButton) {
        var url = objButton.value;
        // alert(objButton.value)
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Active !'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: 'POST',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        if (data.type == 'success') {
                            Swal.fire(
                                'Activated !',
                                'This account has been Activated. ' + data.message,
                                'success'
                            )
                            setTimeout(function() {
                                location.reload();
                            }, 800);
                        } else {
                            Swal.fire(
                                'Wrong !',
                                'Something going wrong. ' + data.message,
                                'warning'
                            )
                        }
                    },
                })
            }
        })
    }

    function inactiveNow(objButton) {
        var url = objButton.value;
        // alert(objButton.value)
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Inactive !'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: 'POST',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        if (data.type == 'success') {
                            Swal.fire(
                                'Inactivated !',
                                'This account has been Inactivated. ' + data.message,
                                'success'
                            )
                            setTimeout(function() {
                                location.reload();
                            }, 800);
                        } else {
                            Swal.fire(
                                'Wrong !',
                                'Something going wrong. ' + data.message,
                                'warning'
                            )
                        }
                    },
                })
            }
        })
    }
</script>
@endsection
