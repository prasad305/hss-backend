@extends('Layouts.ManagerAdmin.master')

@push('title')
Jury Board
@endpush

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Jury Board</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Jury Board List</li>
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
            {{-- <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('managerAdmin.auditionAdmin_assinged') }}">Show assigned
            audition admins</a>
            <a class="dropdown-item" href="{{ route('managerAdmin.auditionAdmin_notAssinged') }}">Show available
                audition admins</a>
            <a class="dropdown-item" href="{{ route('managerAdmin.jury.index') }}">All Jury Boards</a>
        </div> --}}
        <a class="btn btn-success btn-sm mr-4" style="float: right; margin-bottom: 10px;" onclick=""><i
                class="fa fa-search" aria-hidden="true"></i>&nbsp;Search</a>
        <a class="btn btn-success btn-sm mr-4" style="float: right; margin-bottom: 10px;"
            onclick="Show('New Jury Board','{{ route('managerAdmin.jury.create') }}')"><i
                class=" fa fa-plus"></i>&nbsp;Add New</a>
    </div>

    <!-- =========================================================== -->
    <h4 class="mb-2">Jury Board List</h4>

    <hr>
    <div class="row">

        @foreach ($juries as $jury)
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box shadow-none bg-light pt-4 pb-4">
                <img src="{{ asset($jury->image ?? get_static_option('user')) }}" alt="Admin Image"
                    class="img-fluid AdminImg mr-3 mt-4">

                <div class="px-2" style="border-left: 1px solid gray">

                    <a href="{{ route('managerAdmin.jury.show', $jury->id) }}">
                        <span class="info-box-text AdminName">
                            <h5>{{ $jury->first_name }} {{ $jury->last_name }}</h5>
                        </span>
                        <b class="AdminMusic">Music</b> <br />
                    </a>

                    @if ($jury->assignAudition)
                    <span class="right badge bg-danger my-2">Assigned</span>
                    <i class="fa-solid fa-bahai px-2 text-danger"></i><br>
                    @else
                    @endif

                    <p class="{{ $jury->status == 0 ? 'text-danger' : 'text-success' }}">
                        {{ $jury->status == 0 ? 'Pending For Approval' : 'Approved' }}</p>
                    <p class="text-success">{{ $jury->jury ? $jury->jury->qr_code : '' }}</p>
                    <a class="btn btn-sm btn-info"
                        onclick="Show('Edit Jury Board','{{ route('managerAdmin.jury.edit', $jury->id) }}')"><i
                            class="fa fa-edit text-white"></i></a>
                    <a class="btn btn-sm btn-success">
                        <i class="fa-solid fa-eye text-white"></i>
                    </a>

                    <button class="btn btn-sm btn-warning" onclick="delete_function(this)"
                        value="{{ route('managerAdmin.jury.destroy', $jury->id) }}"><i class="fa fa-trash"></i>
                    </button>

                </div>
            </div>
        </div>
        @endforeach

    </div>

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