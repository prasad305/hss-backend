@extends('Layouts.SuperAdmin.master')

@push('title')
    Super Admin | Package
@endpush

<style>
    .check {
        border: 1px solid #62ff21;
        padding: 2px 3px;
        border-radius: 50%;
    }

    .xmark {
        border: 1px solid #4b5546;
        padding: 2px 5px;
        border-radius: 50%;
    }
</style>

@section('content')
    <style>
        .head-line {
            border-top: 1px solid #ffad00 !important;
            border-left: 8px solid #ffad00 !important;
            border-bottom: 1px solid #ffad00 !important;
            border-right: 8px solid #ffad00 !important;
        }

        .card-bg {
            background-color: black;
        }
    </style>

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="card card-bg head-line mt-4 mb-2">
                <div class="text-light d-flex p-2">
                    <h4 class="mx-3 text-white p-2">Package Lists</h4>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div>

    <!-- /.content-header -->



    <div class="content">

        <div class="container-fluid">



            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">All Package Lists</h3>
                    <a class="btn btn-success btn-sm" style="float: right;"
                        onclick="Show('New Package','{{ route('superAdmin.package.create') }}')"><i
                            class=" fa fa-plus"></i>&nbsp;New Package</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        @foreach ($package as $key => $data)
                            <div class="col-md-3">
                                <div class="card text-center">
                                    <div class="card-header"
                                        style=" background: {{ $data->color_code }}; height: 50px; margin-bottom: 20px; font-weight: 600; font-size: 20px; ">
                                        {{ $data->title }}

                                        @if ($data->status == 0)
                                            <button class="btn btn-primary btn-sm" style="float: right;"
                                                onclick="activeNow(this)"
                                                value="{{ route('superAdmin.package.activeNow', $data->id) }}">
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                            </button>
                                        @elseif($data->status == 1)
                                            <button class="btn btn-danger btn-sm" style="float: right;"
                                                onclick="inactiveNow(this)"
                                                value="{{ route('superAdmin.package.inactiveNow', $data->id) }}">
                                                <i class="fa fa-close"></i>
                                            </button>
                                        @endif

                                        <a class="btn btn-sm btn-info" style="float: right; margin-right: 8px;"
                                            onclick="Show('Edit Package','{{ route('superAdmin.package.edit', $data->id) }}')"><i
                                                class="fa fa-edit text-white"></i></a>
                                    </div>
                                    <div class="card-body">
                                        <p class=""><i
                                                class="fa {{ $data->club_points ? 'fa-check check' : 'fa-xmark xmark' }}"></i>
                                            Club Points :: {{ $data->club_points }} </p>
                                        <p class=""><i
                                                class="fa {{ $data->club_points ? 'fa-check check' : 'fa-xmark xmark' }}"></i>
                                            Love Points :: {{ $data->love_points }} </p>
                                        <p class=""><i
                                                class="fa {{ $data->auditions ? 'fa-check check' : 'fa-xmark xmark' }}"></i>
                                            Auditions :: {{ $data->auditions }} </p>
                                        <p class=""><i
                                                class="fa {{ $data->learning_session ? 'fa-check check' : 'fa-xmark xmark' }}"></i>
                                            Learning Session :: {{ $data->learning_session }} </p>
                                        <p class=""><i
                                                class="fa {{ $data->live_chats ? 'fa-check check' : 'fa-xmark xmark' }}"></i>
                                            Live Chats :: {{ $data->live_chats }} </p>
                                        <p class=""><i
                                                class="fa {{ $data->meetup ? 'fa-check check' : 'fa-xmark xmark' }}"
                                                style=""></i> Meetup Events :: {{ $data->meetup }} </p>
                                        <p class=""><i
                                                class="fa {{ $data->greetings ? 'fa-check check' : 'fa-xmark xmark' }}"
                                                style=""></i> Greetings :: {{ $data->greetings }} </p>
                                        <p class=""><i
                                                class="fa {{ $data->qna ? 'fa-check check' : 'fa-xmark xmark' }}"
                                                style=""></i> Q & A :: {{ $data->qna }} </p>
                                    </div>
                                    <div class="card-footer text-muted"
                                        style="color: #f0e25e !important; font-size: 30px; font-weight: 600;">
                                        Price :: {{ $data->price }} $
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- /.card-body -->
            </div>




        </div> <!-- container -->
    </div> <!-- content -->


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
                                    'Status has been Activated. ' + data.message,
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
                                    'Status has been Inactivated. ' + data.message,
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
