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
                    <h1 class="m-0">QnA Event</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">QnA Event Details</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <div class="content">
        <div class="container-fluid">


            <div class="row my-3">

                <div class="col-md-7 mb-2">
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

                <div class="col-md-5 mb-2">
                    <div class="card p-2">
                        <video controls class="img-fluid card-img-details ">
                            <source src="{{ asset($event->video) }}" />
                        </video>
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

                <div class="col-md-3  mb-2">
                    <div class="card px-3 p-2">
                        <label for="Date">Fees</label>
                        <h4 class="text-warning">
                            $ {{ $event->fee }}</h4>
                    </div>
                </div>

                <div class="col-md-3  mb-2">
                    <div class="card px-3 p-2">
                        <label for="Date">Registration Start Date</label>
                        <h4 class="text-warning">
                            {{ \Carbon\Carbon::parse($event->registration_start_date)->format('d F,Y') }}</h4>
                    </div>
                </div>

                <div class="col-md-3  mb-2">
                    <div class="card px-3 p-2">
                        <label for="Date">Registration End Date</label>
                        <h4 class="text-warning">
                            {{ \Carbon\Carbon::parse($event->end)->format('d F,Y') }}</h4>
                    </div>
                </div>

                <div class="col-md-3  mb-2">
                    <div class="card px-3 p-2">
                        <label for="Date"> Event Date</label>
                        <h4 class="text-warning">
                            {{ \Carbon\Carbon::parse($event->event_date)->format('d F,Y') }}</h4>
                    </div>
                </div>

                <div class="col-md-3  mb-2">
                    <div class="card px-3 p-2">
                        <label for="Date"> Event Start Time</label>
                        <h4 class="text-warning">
                            {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}</h4>
                    </div>
                </div>

                <div class="col-md-3  mb-2">
                    <div class="card px-3 p-2">
                        <label for="Date"> Event End Time</label>
                        <h4 class="text-warning">
                            {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}</h4>
                    </div>
                </div>

                <div class="col-md-3  mb-2">
                    <div class="card px-3 p-2">
                        <label for="Date"> Minimum Time</label>
                        <h4 class="text-warning">
                            {{ $event->min_time }}</h4>
                    </div>
                </div>

                <div class="col-md-3  mb-2">
                    <div class="card px-3 p-2">
                        <label for="Date"> Maximum Time</label>
                        <h4 class="text-warning">
                            {{ $event->max_time }}</h4>
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



                <div class="col-md-12 card mb-3">
                    <div class="card-header"
                        style="color: gold; letter-spacing: .01rem; font-size: 18px; border-bottom: 1px solid #000;">
                        Publish Post in News Feed
                    </div>
                    <div class="card-body">
                        <form action="{{ route('managerAdmin.qna.set_publish', [$event->id]) }}" method="post">
                            @csrf
                            @if ($event->status != 2)
                                <div class="row">
                                    <div class="mb-3 col-md-3 mb-2">
                                        <label for="start_date" class="form-label">Post Start Date</label>
                                        <input type="calender" class="form-control input-post" id="datepicker"
                                            name="post_start_date" readonly="readonly"
                                            value="{{ old('post_start_date') }}" />
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
                                    onclick="Show('Edit Live Chat Event','{{ route('managerAdmin.qna.edit', $event->id) }}')">Edit</a>
                            @endif


                            @if ($event->status == 2)
                                <form action="{{ route('managerAdmin.qna.set_publish', [$event->id]) }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btnRemove mr-2 mt-3 mb-4">Remove From
                                        Publish</button>
                                </form>
                            @endif

                        </form>
                    </div>
                </div>

                @if ($event->status >= 1)
                    <div class="col-12 my-5 card">
                        <div class="card-header">
                            <h3 class="card-title">User List - {{ $totalRegistered }}</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control input-post float-right"
                                        placeholder="Search">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>#SL</th>
                                        <th>Name</th>
                                        <th>Amount</th>
                                        <th>Created Date</th>
                                        <th>Q&A Start Date</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($registered as $key => $register)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $register->user->first_name }} {{ $register->user->last_name }}
                                            </td>
                                            <td>{{ $register->amount }}</td>
                                            <td>{{ \Carbon\Carbon::parse($register->created_at)->format('d F,Y') }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($register->qna_date)->format('d F,Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($register->start_time)->format('h:m a') }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($register->end_time)->format('h:m a') }}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>

                    </div>
                @endif


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
