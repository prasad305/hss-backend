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
                    <h1 class="m-0">Live Chat Event</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Live Chat Event Details</li>
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
                            <img src="{{ asset($event->banner) }}" class="card-img-details" />
                        @else
                            <a href="{{ asset('demo_image/banner.jpg') }}" target="_blank">
                                <img src="{{ asset('demo_image/banner.jpg') }}" class="card-img-details" alt="Demo Image" />
                            </a>
                        @endif
                    </div>
                </div>

                <div class="col-md-4 mb-2">

                    <div class="col-md-12 d-flex mb-2 p-2 bg-dark align-items-center card-rounded">
                        <div class="">
                            @if ($event->star->image !== null)
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
                            @if ($event->admin->image !== null)
                                <img src="{{ asset($event->admin->image) }}" class="img-star-x" alt="Demo Image" />
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
                    </div>
                </div>

                <div class="col-md-4 col-lg-3  mb-2">
                    <div class="card px-3 p-2">
                        <label for="Date">Registration Start Date</label>
                        <h4 class="text-warning">
                            {{ \Carbon\Carbon::parse($event->registration_start_date)->format('d F,Y') }}</h4>
                    </div>
                </div>

                <div class="col-md-4 col-lg-3  mb-2">
                    <div class="card px-3 p-2">
                        <label for="Date">Registration End Date</label>
                        <h4 class="text-warning">
                            {{ \Carbon\Carbon::parse($event->registration_end_date)->format('d F,Y') }}</h4>
                    </div>
                </div>

                <div class="col-md-4 col-lg-3  mb-2">
                    <div class="card px-3 p-2">
                        <label for="Date">Minimum Time</label>
                        <h4 class="text-warning">
                            {{ $event->min_time }} Minute(s)</h4>
                    </div>
                </div>

                <div class="col-md-4 col-lg-3  mb-2">
                    <div class="card px-3 p-2">
                        <label for="Date">Maximum Time</label>
                        <h4 class="text-warning">
                            {{ $event->max_time }} Minute(s)</h4>
                    </div>
                </div>

                <div class="col-md-4 col-lg-3  mb-2">
                    <div class="card px-3 p-2">
                        <label for="Date">Interval</label>
                        <h4 class="text-warning">
                            {{ $event->interval }} Minute(s)</h4>
                    </div>
                </div>

                <div class="col-md-4 col-lg-3  mb-2">
                    <div class="card px-3 p-2">
                        <label for="Date">Event Date</label>
                        <h4 class="text-warning">
                            {{ \Carbon\Carbon::parse($event->event_date)->format('d F,Y') }}</h4>
                    </div>
                </div>

                <div class="col-md-4 col-lg-3  mb-2">
                    <div class="card px-3 p-2">
                        <label for="Date">Event Time</label>
                        <h4 class="text-warning">
                            {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }} -
                            {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}</h4>
                    </div>
                </div>

            </div>

            <div class="card col-md-12 ">
                <div class="card-header"
                    style="color: gold; letter-spacing: .01rem; font-size: 18px; border-bottom: 1px solid #000;">
                    Publish Post in News Feed
                </div>
                <div class="card-body">
                    <form action="{{ route('managerAdmin.liveChat.set_publish', [$event->id]) }}" method="post">
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
                                onclick="Show('Edit Live Chat Event','{{ route('managerAdmin.liveChat.edit', $event->id) }}')">Edit</a>
                        @endif
                        @if ($event->status == 2)
                            <form action="{{ route('managerAdmin.liveChat.set_publish', [$event->id]) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btnRemove mr-2 mt- mb-4">Remove From
                                    Publish</button>
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
                minDate: "<?php echo \Carbon\Carbon::now()->format('m/d/Y'); ?>",
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
