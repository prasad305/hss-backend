@extends('Layouts.ManagerAdmin.master')

@push('title')
    Manager Admin
@endpush


@section('content')
    <style>
        .banner-image {
            height: 300px;
            object-fit: cover;
        }
    </style>



    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Learning Session</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Meetup Event Details</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <div class="content">

        <div class="container-fluid">


            <div class="row">

                <div class="col-md-8 mb-2">
                    <div class="card p-2">
                        @if ($event->banner)
                            <img src="{{ asset($event->banner) }}" class="img-fluid card-img-details" />
                        @elseif($event->video)
                            <video controls class="img-fluid card-img-details">
                                <source src="{{ asset($event->video) }}" />
                            </video>
                        @else
                            <a href="{{ asset('demo_image/banner.jpg') }}" target="_blank">
                                <img src="{{ asset('demo_image/banner.jpg') }}" alt="Demo Image" style="width: 100%"
                                    class="img-fluid card-img-details" />
                            </a>
                        @endif
                    </div>
                </div>

                <div class="col-md-4 mb-2">

                    <div class="col-md-12 d-flex mb-2 p-2 bg-dark align-items-center card-rounded">
                        <div class="">
                            @if (false)
                                <img src="{{ asset($event->star->image) }}" class="img-star-x" alt="Demo Image" />
                            @else
                                <a href="{{ asset('demo_image/demo_user.png') }}" target="_blank">
                                    <img src="{{ asset('demo_image/demo_user.png') }}" class="img-star-x"
                                        alt="Demo Image" />
                                </a>
                            @endif
                        </div>
                        <div class="mx-2">
                            <label for="">Star</label>
                            <h5>{{ $event->star->first_name }} {{ $event->star->last_name }}</h5>

                        </div>
                    </div>

                    <div class="col-md-12 d-flex mb-2 p-2 bg-dark align-items-center card-rounded">
                        <div class="">
                            @if (false)
                                <img src="{{ asset($event->star->image) }}" class="img-star-x" alt="Demo Image" />
                            @else
                                <a href="{{ asset('demo_image/demo_user.png') }}" target="_blank">
                                    <img src="{{ asset('demo_image/demo_user.png') }}" class="img-star-x"
                                        alt="Demo Image" />
                                </a>
                            @endif
                        </div>
                        <div class="mx-2">
                            <label for="">Admin</label>
                            <h5>{{ $event->admin->first_name }} {{ $event->admin->last_name }}</h5>

                        </div>
                    </div>

                </div>

                <div class="col-md-12 mb-2">
                    <div class=" card px-3 py-3">
                        <h3>{{ $event->title }}</h3>
                        <div class="title-text text-warning mt-2">Description</div>
                        <div class="description-text"> {!! $event->description !!}</div>
                        <div class="title-text text-warning mt-2">Instruction</div>
                        <div class="description-text"> {!! $event->instruction !!}</div>

                        <div class="title-text text-warning mt-2">Assignment Instruction</div>
                        <div class="description-text"> {!! $event->assignment_instruction !!}</div>

                        <div class="card mb-2 col-md-3 mb-3 py-2 px-2">
                            @if ($event->assignment === 0)
                                <div class="d-flex ">
                                    <span>Type :</span>&nbsp;&nbsp; <span class="text-danger">Without Assignment</span>
                                </div>
                            @else
                                <div class="d-flex ">
                                    <span>Type :</span>&nbsp;&nbsp; <span class="text-success">Assignment</span>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

                <div class="col-md-3  mb-2">
                    <div class="card px-3 p-2">
                        <label for="Date">Registration Start Date</label>
                        <h4 class="text-warning">
                            {{ \Carbon\Carbon::parse($event->assignment_reg_start_date)->format('d F,Y') }} </h4>
                    </div>
                </div>

                <div class="col-md-3  mb-2">
                    <div class="card px-3 p-2">
                        <label for="Date">Registration End Date</label>
                        <h4 class="text-warning">
                            {{ \Carbon\Carbon::parse($event->assignment_reg_end_date)->format('d F,Y') }}</h4>
                    </div>
                </div>


            </div>


            <div class="container row mb-4">

                {{-- <a type="button" class="btn btn-outline-success px-5 mr-2" onclick="Show('Edit Learning Session','{{ route('managerAdmin.learningSession.accept', $event->id) }}')">Accept</a> --}}
                @if ($event->status < 5)
                    <button class="btn btn-outline-success px-5 mr-2" onclick="Accept(this)"
                        value="{{ route('managerAdmin.learningSession.evaluationAccept', $event->id) }}">
                        Accept
                    </button>
                    <button class="btn btnRemove px-5 mr-2" onclick="Reject(this)"
                        value="{{ route('managerAdmin.learningSession.evaluationReject', $event->id) }}">
                        Reject
                    </button>
                @endif

                @if ($event->status == 5)
                    <span class="btn btn-outline-success">Accepted</span>
                @endif
                @if ($event->status == 55)
                    <span class="btn btnRemove">Rejected</span>
                @endif

            </div>










        </div> <!-- container -->
    </div> <!-- content -->



    @if (session()->has('success'))
        <script type="text/javascript">
            $(document).ready(function() {
                // notify('{{ session()->get('success') }}','success');
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: '{{ Session::get('success') }}',
                    showConfirmButton: false,
                    timer: 1500
                })
            });
        </script>
    @endif

    <script>
        function Accept(objButton) {
            var url = objButton.value;
            // alert(objButton.value)
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Accept !'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: 'POST',
                        url: url,
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        },
                        success: function(data) {
                            if (data.status == 'success') {
                                Swal.fire(
                                    'Accepted !',
                                    data.message,
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

        function Reject(objButton) {
            var url = objButton.value;
            // alert(objButton.value)
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Reject !'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: 'POST',
                        url: url,
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        },
                        success: function(data) {
                            if (data.status == 'success') {
                                Swal.fire(
                                    'Rejected !',
                                    data.message,
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

@push('script')
    {{-- <script src="{{ asset('assets/manager-admin/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script> --}}
    <script src="{{ asset('assets/manager-admin/pages/dashborad.js') }}"></script>
@endpush
