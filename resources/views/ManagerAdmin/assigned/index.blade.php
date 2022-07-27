@extends('Layouts.ManagerAdmin.master')

@push('title')
Assigned Asdmin
@endpush

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Assigned Admin</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Assigned Admin List</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="content">

    <div class="container-fluid">

        <div class="row float-right">
        </div>

        <!-- =========================================================== -->
        <h4 class="mb-2">Unassigned Admin List</h4>

        <hr>
        <div class="row">

            @foreach ($unassigned_admins as $admin)
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow-none bg-light pt-4 pb-4">
                    <img src="{{ asset($admin->image ?? get_static_option('user')) }}" alt="Admin Image"
                        class="img-fluid AdminImg mr-3 mt-4">

                    <div class="px-2" style="border-left: 1px solid gray">

                        {{-- <a href="{{ route('managerAdmin.auditionAdmin.show', $admin->id) }}"> --}}
                            <span class="info-box-text AdminName">
                                <h5>{{ $admin->first_name }} {{ $admin->last_name }}</h5>
                            </span>
                            <b class="AdminMusic text-warning">{{$admin->subCategory ? $admin->subCategory->name : ''}}</b> <br />
                        {{-- </a> --}}


                        @if ($admin->assignAudition)
                        <span class="right badge bg-danger my-2">Assigned</span>
                        <i class="fa-solid fa-bahai px-2 text-danger"></i><br>
                        @else
                        {{-- <span class="right badge border border-success my-2">Free Now</span> 🏳️<br> --}}
                        @endif

                        <p class="{{ $admin->active_status == 0 ? 'text-danger' : 'text-success' }}">
                            {{ $admin->active_status == 0 ? 'Inactive' : 'Active' }}</p>

                            <a class="btn btn-sm btn-info"
                            onclick="Show('Assigned Admin','{{ route('managerAdmin.assigned.edit', $admin->id) }}')"><i
                                class="fa fa-edit text-white"></i></a>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            @endforeach



        </div>
        <hr>
        <h4 class="mb-2">Assigned Asdmin List</h4>


        <div class="row">

            @foreach ($assigned_admins as $admin)
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow-none py-4 d-flex align-items-center">

                        <div class="d-flex justify-content-center align-items-center">
                            <img src="{{ asset($admin->image ?? get_static_option('user')) }}" alt="Admin Image"
                                class="img-fluid AdminImg">
                        </div>
                    <div class="px-2 p-x-i" style="border-left: 1px solid gray">

                        {{-- <a href="{{ route('managerAdmin.auditionAdmin.show', $admin->id) }}"> --}}
                            <span class="info-box-text AdminName">
                                <h5 class="text-light fw-bold">{{ $admin->first_name }} {{ $admin->last_name }}</h5>
                            </span>
                            <b class="AdminMusic text-warning">{{$admin->subCategory ? $admin->subCategory->name : ''}}</b> <br />
                        {{-- </a> --}}


                        @if ($admin->star)
                        <span class="right badge bg-danger my-2">Assigned</span>
                        <i class="fa-solid fa-bahai px-2 text-danger"></i>
                        <p class="text-success text-bold">{{$admin->star ? $admin->star->first_name.' '.$admin->star->last_name : ''}}</p><br>
                        @else
                        {{-- <span class="right badge border border-success my-2">Free Now</span> 🏳️<br> --}}
                        @endif
                            {{-- <a class="btn btn-sm btn-info"
                            onclick="Show('Assigned Asdmin','{{ route('managerAdmin.assigned.edit', $admin->id) }}')"><i
                                class="fa fa-edit text-white"></i></a> --}}
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            @endforeach



        </div>



    </div> <!-- container -->
</div> <!-- content -->

<script>
     function activeNow(objButton) {
        var url = objButton.value;
        // alert(objButton.value)
        Swal.fire({
            title: 'Are you sure?'
            , text: "You won't be able to revert this!"
            , icon: 'warning'
            , showCancelButton: true
            , confirmButtonColor: '#3085d6'
            , cancelButtonColor: '#d33'
            , confirmButtonText: 'Yes, Active !'
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
                    }
                , })
            }
        })
    }

    function inactiveNow(objButton) {
        var url = objButton.value;
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
                    }
                    ,success: function(data) {
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

    function openLink(link,type='_parent') {
        window.open(link,type);
    }
</script>

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
@endsection
