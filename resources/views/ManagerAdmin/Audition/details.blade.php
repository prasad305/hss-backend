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
                    <h1 class="m-0">Audition</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Audition Details</li>
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
                        @if ($audition->banner)
                            <img src="{{ asset($audition->banner) }}" class="card-img-details" />
                        @else
                            <a href="{{ asset('demo_image/banner.jpg') }}" target="_blank">
                                <img src="{{ asset('demo_image/banner.jpg') }}" class="card-img-details" alt="Demo Image" />
                            </a>
                        @endif
                    </div>
                </div>

                <div class="col-md-4 mb-2 ">
                    <div class=" px-2  pb-2 card-rounded" style="border: .2px solid rgb(235, 153, 0);">
                        <h3 class="text-warning py-2"> Judge Panel</h3>
                        @foreach ($judges as $star)
                            <div class="col-md-12 d-flex mt-2 p-2 bg-dark align-items-center card-rounded">
                                <div class="">
                                    @if ($star->user->image)
                                        <img src="{{ asset($star->user->image) }}" class="img-star-x" alt="Demo Image" />
                                    @else
                                        <a href="{{ asset('demo_image/demo_user.png') }}" target="_blank">
                                            <img src="{{ asset('demo_image/demo_user.png') }}" class="img-star-x"
                                                alt="Demo Image" />
                                        </a>
                                    @endif
                                </div>
                                <div class="mx-2">
                                    <label for="">Star</label>
                                    <h5>{{ $star->user ? $star->user->first_name : '' }}
                                        {{ $star->user ? $star->user->last_name : '' }}</h5>

                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>

                <div class="col-md-12 mb-2">
                    <div class=" card px-3 py-3">
                        <h3>{{ $audition->title }}</h3>
                        <div class="title-text text-warning mt-2">Description</div>
                        <div class="description-text"> {!! $audition->description !!}</div>
                        <div class="title-text text-warning mt-2">Instruction</div>
                        <div class="description-text"> {!! $audition->instruction !!}</div>
                    </div>
                </div>

                <div class="col-md-4 col-lg-3  mb-2">
                    <div class="card px-3 p-2">
                        <label for="Date">Registration Start Date</label>
                        <h4 class="text-warning">
                            {{ \Carbon\Carbon::parse($audition->user_reg_start_date)->format('d F,Y') }} </h4>
                    </div>
                </div>

                <div class="col-md-4 col-lg-3  mb-2">
                    <div class="card px-3 p-2">
                        <label for="Date">Registration End Date</label>
                        <h4 class="text-warning">
                            {{ \Carbon\Carbon::parse($audition->user_reg_end_date)->format('d F,Y') }}</h4>
                    </div>
                </div>

                <div class="col-md-4 col-lg-3  mb-2">
                    <div class="card px-3 p-2">
                        <label for="Date"> Audition Start Date</label>
                        <h4 class="text-warning">
                            {{ \Carbon\Carbon::parse($audition->start_date)->format('d F,Y') }}</h4>
                    </div>
                </div>

                <div class="col-md-4 col-lg-3  mb-2">
                    <div class="card px-3 p-2">
                        <label for="Date"> Audition End Date</label>
                        <h4 class="text-warning">
                            {{ \Carbon\Carbon::parse($audition->end_date)->format('d F,Y') }}</h4>
                    </div>
                </div>

            </div>



            <div class="card row">
                <div class="card-header"
                    style="color: gold; letter-spacing: .01rem; font-size: 18px; border-bottom: 1px solid #000;">
                    Publish Post in News Feed
                </div>
                <div class="card-body">
                    <form action="{{ route('managerAdmin.audition.set_publish', [$audition->id]) }}" method="post">
                        @csrf
                        @if ($audition->status == 2)
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
                            <button type="submit" class="btn btnPublish mr-2">Publish Now</button>
                        @endif

                        @if ($audition->status == 3)
                            <form action="{{ route('managerAdmin.audition.set_publish', [$audition->id]) }}"
                                method="post">
                                @csrf
                                <button type="submit" class="btn btnRemove mr-2">Remove From Publish</button>
                            </form>
                        @endif
                    </form>

                </div>

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
                    title: '{{ Session::get('
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            success ') }}',
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
                maxDate: "<?php echo \Carbon\Carbon::parse($audition->info->registration_start_date)->format('m/d/Y'); ?>"
            });
        });

        $(function() {
            $("#datepicker1").datepicker({
                minDate: "<?php echo \Carbon\Carbon::parse($audition->info->registration_end_date)
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
