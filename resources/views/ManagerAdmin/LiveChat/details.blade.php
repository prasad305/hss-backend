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
                <div class="col-md-6">
                    @if($event->banner)
                        <img src="{{ asset($event->banner) }}" style="width: 100%" />
                    @else
                        <a href="{{ asset('demo_image/banner.jpg') }}" target="_blank">
                            <img src="{{ asset('demo_image/banner.jpg') }}" alt="Demo Image" style="width: 100%"/>
                        </a>
                    @endif
                </div>
            </div>


            <div class="row pt-5">

                <div class="col-md-8 ">
                    <div class="row card p-5">
                        <h3>{{ $event->title }}</h3>

                        <h4><u>Description</u></h4>
                        {!! $event->description !!}

                        <h4><u>Instruction</u></h4>
                        {!! $event->instruction !!}
                    </div>
                    <div class="row">
                        <div class="col-md-6 card py-3">
                            Event Date
                            <h4 class="text-warning">{{ \Carbon\Carbon::parse($event->event_date)->format('d F,Y') }}
                            </h4>
                        </div>
                        <div class="col-md-6 card py-3">
                            Event Time
                            <h4 class="text-warning">{{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }} -
                                {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card px-5 py-4">
                        <div class="row">
                            <div class="col-xs-6 content-center mr-2">
                                @if($event->star->image)
                                    <img src="{{ asset($event->star->image) }}"
                                        style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray" />
                                @else
                                    <a href="{{ asset('demo_image/demo_user.png') }}" target="_blank">
                                        <img src="{{ asset('demo_image/demo_user.png') }}" alt="Demo Image" style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray"/>
                                    </a>
                                @endif
                            </div>
                            <div class="col-xs-6">
                                Star
                                <h3>{{ $event->star->first_name }} {{ $event->star->last_name }}</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 content-center mr-2">
                                @if($event->admin->image)
                                    <img src="{{ asset($event->admin->image) }}" class="user_image"
                                        style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray"
                                        alt="Image not found" />
                                @else
                                    <a href="{{ asset('demo_image/demo_user.png') }}" target="_blank">
                                        <img src="{{ asset('demo_image/demo_user.png') }}" alt="Demo Image" class="user_image"
                                        style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray"/>
                                    </a>
                                @endif
                            </div>
                            <div class="col-xs-6">
                                Admin
                                <h3>{{ $event->admin->first_name }} {{ $event->admin->last_name }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="card px-5 py-3">
                        <h5>Registration: </h5>
                        <hr>
                        <div class="row">
                            <div class="col-4">Registration Start:</div>
                            <div class="col-8 text-warning">
                                {{ \Carbon\Carbon::parse($event->registration_start_date)->format('d F,Y') }}</div>
                        </div>
                        <div class="row">
                            <div class="col-4">Registration End:</div>
                            <div class="col-8 text-warning">
                                {{ \Carbon\Carbon::parse($event->registration_end_date)->format('d F,Y') }}</div>
                        </div>
                        <div class="row">
                            <div class="col-4">Maximum Time:</div>
                            <div class="col-8 text-warning">{{ $event->max_time }} Minute(s)</div>
                        </div>
                        <div class="row">
                            <div class="col-4">Minimum Time:</div>
                            <div class="col-8 text-warning">{{ $event->min_time }} Minute(s)</div>
                        </div>
                        <div class="row">
                            <div class="col-4">Interval:</div>
                            <div class="col-8 text-warning">{{ $event->interval }} Minute(s)</div>
                        </div>

                    </div>
                </div>

            </div>



            @if ($event->status != 2)
                <div class="card row">
                    <div class="card-header"
                        style="color: gold; letter-spacing: .01rem; font-size: 18px; border-bottom: 1px solid #000;">
                        Publish Post in News Feed
                    </div>
                    <div class="card-body">
                        <form action="{{ route('managerAdmin.liveChat.set_publish', [$event->id]) }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="mb-3 col-md-6 col-6">
                                    <label for="start_date" class="form-label">Post Start Date</label>
                                    <input type="calender" class="form-control" id="datepicker"
                                        style="background: coral; position: relative; padding-left: 33px;"
                                        name="post_start_date" readonly="readonly" value="{{ old('post_start_date') }}" />
                                    <i class="fa fa-calendar"
                                        style="position: absolute; top: 41px; left: 18px; font-size: 20px;"
                                        aria-hidden="true"></i>
                                    @if ($errors->has('post_start_date'))
                                        <span class="text-danger">{{ $errors->first('post_start_date') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3 col-md-6 col-6">
                                    <label for="end_date" class="form-label">Post End Date</label>
                                    <input type="text" class="form-control" id="datepicker1"
                                        style="background: coral; position: relative; padding-left: 33px;"
                                        name="post_end_date" readonly="readonly" value="{{ old('post_end_date') }}">
                                    <i class="fa fa-calendar"
                                        style="position: absolute; top: 41px; left: 18px; font-size: 20px;"
                                        aria-hidden="true"></i>
                                    @if ($errors->has('post_end_date'))
                                        <span class="text-danger">{{ $errors->first('post_end_date') }}</span>
                                    @endif
                                </div>
                            </div>


                            <button type="submit" class="btn btn-outline-success mr-2" href="">Publish Now</button>
                            <a type="button" class="btn btn-outline-warning px-5"
                                onclick="Show('Edit Live Chat Event','{{ route('managerAdmin.liveChat.edit', $event->id) }}')">Edit</a>



                        </form>

                    </div>

                </div>
            @endif

            @if ($event->status == 2)
                <form action="{{ route('managerAdmin.liveChat.set_publish', [$event->id]) }}" method="post">
                    @csrf
                    <button type="submit" class="btn btnRemove mr-2">Remove From Publish</button>
                </form>
            @endif


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
