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
                    <h1 class="m-0">Meetup Events</h1>
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

            <div class="row my-3">

                <div class="col-md-8 mb-2">
                    <div class="card p-2">
                        @if ($meetup->banner)
                            <img src="{{ asset($meetup->banner) }}"class="img-fluid card-img-details" />
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
                            @if ($meetup->star->image)
                                <img src="{{ asset($meetup->star->image) }}" class="img-star-x" alt="Demo Image" />
                            @else
                                <a href="{{ asset('demo_image/demo_user.png') }}" target="_blank">
                                    <img src="{{ asset('demo_image/demo_user.png') }}" class="img-star-x"
                                        alt="Demo Image" />
                                </a>
                            @endif
                        </div>
                        <div class="mx-2">
                            <label for="">Star</label>
                            <h5>{{ $meetup->star->first_name }} {{ $meetup->star->last_name }}</h5>

                        </div>
                    </div>

                    <div class="col-md-12 d-flex mb-2 p-2 bg-dark align-items-center card-rounded">
                        <div class="">
                            @if ($meetup->admin->image)
                                <img src="{{ asset($meetup->admin->image) }}" class="img-star-x" alt="Demo Image" />
                            @else
                                <a href="{{ asset('demo_image/demo_user.png') }}" target="_blank">
                                    <img src="{{ asset('demo_image/demo_user.png') }}" class="img-star-x"
                                        alt="Demo Image" />
                                </a>
                            @endif
                        </div>
                        <div class="mx-2">
                            <label for="">Admin</label>
                            <h5>{{ $meetup->admin->first_name }} {{ $meetup->admin->last_name }}</h5>

                        </div>
                    </div>

                </div>

                <div class="col-md-12 mb-2">
                    <div class=" card px-3 py-3">
                        <h3>{{ $meetup->title }}</h3>
                        <div class="title-text text-warning mt-2">Description</div>
                        <div class="description-text"> {!! $meetup->description !!}</div>
                        <div class="title-text text-warning mt-2">Instruction</div>
                        <div class="description-text"> {!! $meetup->instruction !!}</div>

                        <div class="card mb-2 col-md-3 mb-3 py-2 px-2">
                            <div class="d-flex ">
                                <span>Type :</span>&nbsp;&nbsp; <span
                                    class="text-warning">{{ $meetup->meetup_type }}</span>
                            </div>
                            @if ($meetup->meetup_type == 'Offline')
                                <div class="d-flex ">
                                    <span>Vanue :</span>&nbsp;&nbsp; <span class="text-warning">{{ $meetup->venue }}</span>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-lg-3  mb-2">
                    <div class="card px-3 p-2">
                        <label for="Date">Registration Start Date</label>
                        <h4 class="text-warning">
                            {{ \Carbon\Carbon::parse($meetup->reg_start_date)->format('d F,Y') }} </h4>
                    </div>
                </div>

                <div class="col-md-4 col-lg-3  mb-2">
                    <div class="card px-3 p-2">
                        <label for="Date">Registration End Date</label>
                        <h4 class="text-warning">
                            {{ \Carbon\Carbon::parse($meetup->reg_end_date)->format('d F,Y') }}</h4>
                    </div>
                </div>

                <div class="col-md-4 col-lg-3  mb-2">
                    <div class="card px-3 p-2">
                        <label for="Date">Event Date</label>
                        <h4 class="text-warning">
                            {{ \Carbon\Carbon::parse($meetup->event_date)->format('d F,Y') }}</h4>
                    </div>
                </div>

                <div class="col-md-4 col-lg-3  mb-2">
                    <div class="card px-3 p-2">
                        <label for="Date">Event Time</label>
                        <h4 class="text-warning">
                            {{ \Carbon\Carbon::parse($meetup->start_time)->format('h:i A') }} -
                            {{ \Carbon\Carbon::parse($meetup->end_time)->format('h:i A') }}</h4>
                    </div>
                </div>

            </div>

            <div class="card col-md-12">
                <div class="card-header"
                    style="color: gold; letter-spacing: .01rem; font-size: 18px; border-bottom: 1px solid #000;">
                    Publish Post in News Feed
                </div>
                <div class="card-body">

                    <form action="{{ route('managerAdmin.meetupEvent.set_publish', [$meetup->id]) }}" method="post">
                        @csrf

                        @if ($meetup->status != 2)
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


                            <button type="submit" class="btn btnPublish  mr-2" href="">Publish
                                Now</button>
                            <a type="button" class="btn btnEdit px-5"
                                onclick="Show('Edit Live Chat Event','{{ route('managerAdmin.meetupEvent.edit', $meetup->id) }}')">Edit</a>
                        @endif

                        @if ($meetup->status == 2)
                            <form action="{{ route('managerAdmin.meetupEvent.set_publish', [$meetup->id]) }}"
                                method="post">
                                @csrf
                                <button type="submit" class="btn btnRemove mr-2 ">Remove From
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
@endsection

@push('js')
    {{-- <script src="{{ asset('assets/manager-admin/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script> --}}
    <script src="{{ asset('assets/manager-admin/pages/dashborad.js') }}"></script>


    <script>
        $(function() {
            $("#datepicker").datepicker({
                minDate: "<?php echo \Carbon\Carbon::now()->format('m/d/Y'); ?>",
                maxDate: "<?php echo \Carbon\Carbon::parse($meetup->reg_start_date)->format('m/d/Y'); ?>"
            });
        });

        $(function() {
            $("#datepicker1").datepicker({
                minDate: "<?php echo \Carbon\Carbon::parse($meetup->event_date)
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
