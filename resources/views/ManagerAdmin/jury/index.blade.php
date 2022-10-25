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
            <input type="search" name="search_text" id="search_text" class="form-control"
                style="width:200px!important; margin-right: 5px!important" value="{{isset($search) ? $search : ''}}">
            <a class="btn btn-success btn-md mr-4" style="float: right; margin-bottom: 10px;"
                onclick="openLink('{{ url('manager-admin/jury') }}/'+$('#search_text').val())"><i class="fa fa-search"
                    aria-hidden="true"></i>&nbsp;Search</a>
            <a class="btn btn-success btn-sm mr-4" style="float: right; margin-bottom: 10px;"
                onclick="Show('New Jury','{{ route('managerAdmin.jury.create') }}')"><i
                    class=" fa fa-plus"></i>&nbsp;Add New</a>
        </div>

        <!-- =========================================================== -->
        <h4 class="mb-2">Jury Board List</h4>

        <hr>
        @php 
            $totalgroup = count($group);
            for ($i=0; $i <$totalgroup ; $i++) { 
        @endphp
        <div class="bg-gray-c mb-3">
            <h4 class="px-2 py-2 co-gradient-warning text-center">{{ $group[$i]['name'] }}</h4>
            <div class="row p-2">
                
                @foreach ($group[$i]['board'] as $key => $jury)
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box shadow-none py-4 d-flex align-items-center">

                        <div class="d-flex justify-content-center align-items-center">
                            <img src="{{ asset($jury['assignjuries']['image'] ?? get_static_option('user')) }}" alt="Admin Image"
                                class="img-fluid AdminImg">
                        </div>

                        <div class="px-2 p-x-i" style="border-left: 1px solid gray">
                            <div class="p-x-card">
                                <a href="{{ route('managerAdmin.jury.show', $jury['id']) }}">
                                    <span class="info-box-text AdminName">
                                        <h5 class="text-light fw-bold">{{ $jury['assignjuries']['first_name'] }} {{ $jury['assignjuries']['last_name'] }}
                                        </h5>
                                    </span>
                                    <br />
                                </a>
                                <b class="AdminMusic">{{$jury['assignjuries']['subCategory']['name'] ? $jury['assignjuries']['subCategory']['name'] : ''}}</b>

                                @if ($jury['assignAudition'])
                                <span class="right badge bg-danger my-2">Assigned</span>
                                <i class="fa-solid fa-bahai px-2 text-danger"></i><br>
                                @else
                                @endif

                                <p
                                    class="{{ $jury['assignjuries']['status'] == 0 ? ' bg-danger pending-text rounded-3 px-2 pb-1 mt-1' : 'text-success bg-success approved-text rounded-3 px-2 pb-1 mt-1' }}">
                                    {{ $jury['assignjuries']['status'] == 0 ? 'Pending' : 'Approved' }}</p>

                                <p
                                    class="{{ $jury['assignjuries']['active_status'] == 0 ? 'text-danger text-bold' : 'text-success text-bold'  }}">
                                    {{ $jury['assignjuries']['active_status'] == 0 ? 'Inactive' : 'Active' }}</p>

                                <p class="text-light text-bold">{{ $jury['qr_code'] ? $jury['qr_code'] : '' }}</p>
                                {{-- for active and inactive --}}
                                @if ($jury['assignjuries']['active_status'] == 0)
                                <button class="btn btn-sm btn-success" onclick="activeNow(this)"
                                    value="{{ route('managerAdmin.jury.activeNow', $jury['assignjuries']['id']) }}">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                </button>
                                @elseif($jury['assignjuries']['active_status'] == 1)
                                <button class="btn btn-sm btn-danger" onclick="inactiveNow(this)"
                                    value="{{ route('managerAdmin.jury.inactiveNow', $jury['assignjuries']['id']) }}">
                                    <i class="fa fa-close"></i>
                                </button>
                                @endif
                                <a class="btn btn-sm btn-info"
                                    onclick="Show('Edit Jury Board','{{ route('managerAdmin.jury.edit', $jury['id']) }}')">
                                    <i class="fa fa-edit text-white"></i>
                                </a>

                                <a href="{{ route('managerAdmin.jury.views',$jury['id']) }}"
                                    class="btn btn-sm btn-success">
                                    <i class="fa-solid fa-eye text-white"></i>
                                </a>

                                <button class="btn btn-sm btn-warning" onclick="delete_function(this)"
                                    value="{{ route('managerAdmin.jury.destroy', $jury['id']) }}"><i
                                        class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
                @endforeach
            </div>

        </div>
        @php } @endphp

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
    function openLink(link, type = '_parent') {
        window.open(link, type);
    }

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
