@extends('Layouts.ManagerAdmin.master')

@push('title')
Audition Admin
@endpush

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Audition Admin</h1>
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
            <input type="search" name="search_text" id="search_text" class="form-control" style="width:200px!important; margin-right: 5px!important" value="{{isset($search_text) ? $search_text : ''}}">
            <a class="btn btn-success btn-md mr-4" style="float: right; margin-bottom: 10px;" onclick="openLink('{{ url('manager-admin/auditionAdmin') }}/'+$('#search_text').val())" ><i
                    class="fa fa-search" aria-hidden="true"></i>&nbsp;Search</a>
            <a class="btn btn-success btn-sm mr-4" style="float: right; margin-bottom: 10px;"
                onclick="Show('New Audition Admin','{{ route('managerAdmin.auditionAdmin.create') }}')"><i
                    class=" fa fa-plus"></i>&nbsp;Add New</a>
        </div>

        <!-- =========================================================== -->
        <h4 class="mb-2">Audition Admin List</h4>

        <hr>
        <div class="row">

            @foreach ($auditionAdmins as $auditionAdmin)
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow-none bg-light pt-4 pb-4">
                    <img src="{{ asset($auditionAdmin->image ?? get_static_option('user')) }}" alt="Admin Image"
                        class="img-fluid AdminImg mr-3 mt-4">

                    <div class="px-2" style="border-left: 1px solid gray">

                        <a href="{{ route('managerAdmin.auditionAdmin.show', $auditionAdmin->id) }}">
                            <span class="info-box-text AdminName">
                                <h5>{{ $auditionAdmin->first_name }} {{ $auditionAdmin->last_name }}</h5>
                            </span>
                            <b class="AdminMusic">{{$auditionAdmin->subCategory ? $auditionAdmin->subCategory->name : ''}}</b> <br />
                        </a>
                        {{-- <p>Music</p> --}}

                        @if ($auditionAdmin->assignAudition)
                        <span class="right badge bg-danger my-2">Assigned</span>
                        <i class="fa-solid fa-bahai px-2 text-danger"></i><br>
                        @else
                        {{-- <span class="right badge border border-success my-2">Free Now</span> 🏳️<br> --}}
                        @endif

                        {{-- <p class="AtifAdmin">Atif Aslam</p> --}}
                        <p class="{{ $auditionAdmin->status == 0 ? 'text-danger' : 'text-success' }}">
                            {{ $auditionAdmin->status == 0 ? 'Pending For Approval' : 'Approved' }}</p>

                        <p class="{{ $auditionAdmin->active_status == 0 ? 'text-danger' : 'text-success' }}">
                            {{ $auditionAdmin->active_status == 0 ? 'Inactive' : 'Active' }}</p>

                        @if ($auditionAdmin->active_status == 0)
                            <button class="btn btn-sm btn-success" onclick="activeNow(this)" value="{{ route('managerAdmin.auditionAdmin.activeNow', $auditionAdmin->id) }}">
                                <i class="fa fa-check" aria-hidden="true"></i>
                            </button>
                        @elseif($auditionAdmin->active_status == 1)
                            <button class="btn btn-sm btn-danger" onclick="inactiveNow(this)" value="{{ route('managerAdmin.auditionAdmin.inactiveNow', $auditionAdmin->id) }}">
                                <i class="fa fa-close"></i>
                            </button>
                        @endif
                        <a class="btn btn-sm btn-info"
                            onclick="Show('Edit Audition Admin','{{ route('managerAdmin.auditionAdmin.edit', $auditionAdmin->id) }}')"><i
                                class="fa fa-edit text-white"></i></a>

                        <button class="btn btn-sm btn-warning" onclick="delete_function(this)"
                            value="{{ route('managerAdmin.auditionAdmin.destroy', $auditionAdmin->id) }}"><i
                                class="fa fa-trash"></i>
                        </button>
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
