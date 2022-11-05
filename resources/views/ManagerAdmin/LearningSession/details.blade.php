@extends('Layouts.ManagerAdmin.master')

@push('title')
    Manager Admin
@endpush


@section('content')
    <style>
        .img-fluid card-img-details {
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
                        <li class="breadcrumb-item active">Learning Session Details</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <div class="content">
        <div class="container-fluid">


            <div class="row my-3">

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

                    <div class="col-md-12 d-flex mb-2 p-2 bg-dark align-items-center rounded-3">
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

                    <div class="col-md-12 d-flex mb-2 p-2 bg-dark align-items-center">
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

                        <div class="card mb-2 col-md-3 mb-3 py-2 px-2">
                            @if ($event->assignment === 0)
                                <div class="d-flex ">
                                    <span>Type :</span>&nbsp;&nbsp; <span class="text-danger">Withouit Assignment</span>
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
                            {{ \Carbon\Carbon::parse($event->reg_start_date)->format('d F,Y') }} </h4>
                    </div>
                </div>

                <div class="col-md-3  mb-2">
                    <div class="card px-3 p-2">
                        <label for="Date">Registration End Date</label>
                        <h4 class="text-warning">
                            {{ \Carbon\Carbon::parse($event->registration_end_date)->format('d M,Y') }}</h4>
                    </div>
                </div>

                <div class="col-md-3  mb-2">
                    <div class="card px-3 p-2">
                        <label for="Date">Event Date</label>
                        <h4 class="text-warning">
                            {{ \Carbon\Carbon::parse($event->event_date)->format('d F,Y') }}</h4>
                    </div>
                </div>

                <div class="col-md-3  mb-2">
                    <div class="card px-3 p-2">
                        <label for="Date">Event Time</label>
                        <h4 class="text-warning">
                            {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }} -
                            {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}</h4>
                    </div>
                </div>

                <div class="col-md-3  mb-2">
                    <div class="card px-3 p-2">
                        <label for="Date"> Participant</label>
                        <h4 class="text-warning">
                            {{ $event->participant_number }}
                    </div>
                </div>

                <div class="col-md-3  mb-2">
                    <div class="card px-3 p-2">
                        <label for="Date"> Fee</label>
                        <h4 class="text-warning">
                            {{ $event->fee }}
                    </div>
                </div>

            </div>





            <div class="card col-md-12">
                <div class="card-header"
                    style="color: gold; letter-spacing: .01rem; font-size: 18px; border-bottom: 1px solid #000;">
                    Publish Post in News Feed
                </div>
                <div class="card-body">
                    <form action="{{ route('managerAdmin.learningSession.set_publish', [$event->id]) }}" method="post">
                        @csrf

                        @if ($event->status != 2)
                            <div class="row">
                                <div class="mb-3 col-md-3 mb-2">
                                    <label for="start_date" class="form-label">Post Start Date</label>
                                    <input type="calender" class="form-control input-post" id="datepicker"
                                        name="post_start_date" readonly="readonly" value="{{ old('post_start_date') }}" />
                                    <i class="fa fa-calendar"
                                        style="position: absolute; top: 41px; left: 18px; font-size: 20px;"
                                        aria-hidden="true"></i>
                                    @if ($errors->has('post_start_date'))
                                        <span class="text-danger">{{ $errors->first('post_start_date') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3 col-md-3 mb-2">
                                    <label for="end_date" class="form-label">Post End Date</label>
                                    <input type="text" class="form-control input-post" id="datepicker1"
                                        name="post_end_date" readonly="readonly" value="{{ old('post_end_date') }}">
                                    <i class="fa fa-calendar"
                                        style="position: absolute; top: 41px; left: 18px; font-size: 20px;"
                                        aria-hidden="true"></i>
                                    @if ($errors->has('post_end_date'))
                                        <span class="text-danger">{{ $errors->first('post_end_date') }}</span>
                                    @endif
                                </div>
                            </div>


                            <button type="submit" class="btn btnPublish mr-2" href="">Publish
                                Now</button>
                            <a type="button" class="btn btnEdit px-5"
                                onclick="Show('Edit Live Chat Event','{{ route('managerAdmin.learningSession.edit', $event->id) }}')">Edit</a>
                        @endif

                        @if ($event->status == 2)
                            <form action="{{ route('managerAdmin.learningSession.set_publish', [$event->id]) }}"
                                method="post">
                                @csrf
                                <button type="submit" class="btn btnRemove mr-2 mt-3 mb-4">Remove From Publish</button>
                            </form>
                        @endif


                    </form>

                </div>

            </div>





        </div>
    </div>



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

@endsection

@push('js')
    {{-- <script src="{{ asset('assets/manager-admin/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script> --}}
    <script src="{{ asset('assets/manager-admin/pages/dashborad.js') }}"></script>


    <script>
        $(function() {
            $("#datepicker").datepicker({
                minDate: "{{ \Carbon\Carbon::now()->format('m/d/Y') }}",
                maxDate: "<?php echo \Carbon\Carbon::parse($event->registration_start_date)->format('m/d/Y'); ?>"
            });
        });

        $(function() {
            $("#datepicker1").datepicker({
                minDate: "<?php echo \Carbon\Carbon::parse($event->event_date)
                    ->addDays(1)
                    ->format('m/d/Y'); ?>",
                maxDate: "+100000D"
            });
        });
    </script>
@endpush

@push('script')
    {{-- <script src="{{ asset('assets/manager-admin/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script> --}}
    <script src="{{ asset('assets/manager-admin/pages/dashborad.js') }}"></script>
@endpush

@push('jsstyle')
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.js"></script> -->
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
@endpush
