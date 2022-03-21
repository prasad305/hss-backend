@extends('Layouts.ManagerAdmin.master')

@push('title')
Manager Admin
@endpush

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Admin</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Admin List</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="content">

    <div class="container-fluid">

        <div class="row float-right">
            <button type="button" class="btn btn-success btn-sm mr-4" data-toggle="dropdown"
                style="float: right; margin-bottom: 10px;">
                <i class=" fa fa-filter"></i> Filter
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('managerAdmin.admin_assinged') }}">Show assigned admins</a>
                <a class="dropdown-item" href="{{ route('managerAdmin.admin_notAssinged') }}">Show available admins</a>
                <a class="dropdown-item" href="{{ route('managerAdmin.admin.index') }}">All Admins</a>
            </div>
            <a class="btn btn-success btn-sm mr-4" style="float: right; margin-bottom: 10px;" onclick=""><i
                    class="fa fa-search" aria-hidden="true"></i>&nbsp;Search</a>
            <a class="btn btn-success btn-sm mr-4" style="float: right; margin-bottom: 10px;"
                onclick="Show('New Admin','{{ route('managerAdmin.admin.create') }}')"><i
                    class=" fa fa-plus"></i>&nbsp;Add New</a>
        </div>

        <!-- =========================================================== -->
        <h4 class="mb-2">Admin List</h4>

        <hr>
        <div class="row">

            @foreach ($admins as $admin)
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow-none bg-light pt-4 pb-4">
                    <img src="{{ asset($admin->image ?? get_static_option('user')) }}" alt="Admin Image"
                        class="img-fluid AdminImg mr-3 mt-4">

                    <div class="px-2" style="border-left: 1px solid gray">
                        <a href="{{ route('managerAdmin.admin.show', $admin->id) }}">
                            <span class="info-box-text AdminName">
                                <h5>{{ $admin->first_name }} {{ $admin->last_name }}</h5>
                            </span>
                            <b class="AdminMusic">Music</b> <br />
                        </a>
                        {{-- <p>Music</p> --}}

                        @if ($admin->assignAudition)
                        <span class="right badge bg-danger my-2">Assigned</span>
                        <i class="fa-solid fa-bahai px-2 text-danger"></i><br>
                        @else
                        {{-- <span class="right badge border border-success my-2">Free Now</span> 🏳️<br> --}}
                        @endif

                        <p class="AtifAdmin">Atif Aslam</p>
                        <a class="btn btn-sm btn-info"
                            onclick="Show('Edit Admin','{{ route('managerAdmin.admin.edit', $admin->id) }}')"><i
                                class="fa fa-edit text-white"></i></a>
                        <button class="btn btn-sm btn-warning" onclick="delete_function(this)"
                            value="{{ route('managerAdmin.admin.destroy', $admin->id) }}"><i class="fa fa-trash"></i>
                        </button>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            @endforeach

        </div>

        {{-- <div class="row mt-5">
            <div class="col-md-12">
                <div class="panel panel-primary" style="background: #f3f4f6;">
                    <div class="panel-heading">
                        <span class="panel-title">Admin Table
                    </div>
                    <div class="panel-body row bg-light">

                        @foreach ($admins as $admin)
                            <div class="col-sm-6 col-lg-4 ">
                                <div class="panel panel-primary">
                                    <div class="panel-body row">
                                        <div class="col-md-6 col-sm-6" style="display: flex; justify-content: center">
                                            <img src="{{ $admin->image ? asset($admin->image) : asset(get_static_option('no_image')) }}"
        alt="admin Image" class="img-fluid" style="height: 150px; width: 150px; border-radius: 50%;">
    </div>
    <div class="col-md-6 col-sm-6" style="border-left: 1px solid gray">
        <a href="{{ route('managerAdmin.admin.show', $admin->id) }}">
            <h3 class="name text-ellipsis">{{ $admin->first_name }} {{ $admin->last_name }}</h3>
        </a>
        <b>Music</b>
        <br>

        <button class="badge badge-success p-3">Assigned</button>
        <h4>Atif Aslam</h4>
        <a class="btn btn-sm btn-info"
            onclick="Show('Edit Admin','{{ route('managerAdmin.admin.edit', $admin->id) }}')"><i
                class="fa fa-edit text-white"></i></a>
        <button class="btn btn-sm btn-danger" onclick="delete_function(this)"
            value="{{ route('managerAdmin.admin.destroy', $admin->id) }}"><i class="fa fa-trash"></i> </button>
    </div>
</div>

</div>
</div>
@endforeach
</div>
</div>
</div>
</div> <!-- End Row --> --}}

</div> <!-- container -->
</div> <!-- content -->

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
