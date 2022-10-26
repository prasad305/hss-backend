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
                <div class="col-md-6">
                    @if ($audition->banner)
                        <img src="{{ asset($audition->banner) }}" style="width: 40%" />
                    @endif

                </div>
            </div>


            <div class="row pt-5">

                <div class="col-md-8 ">
                    <div class="row card p-5">
                        <h3>{{ $audition->name }}</h3>
                        <h4>Description</h4>
                        <p>
                            {!! $audition->description !!}
                        </p>
                        <h4>Instruction</h4>
                        <p>
                            {!! $audition->instruction !!}
                        </p>
                    </div>
                    <div class="row">
                        <div class="col-md-6 card py-3 mr-1">
                            Audition Start
                            <h4 class="text-warning"> {{ \Carbon\Carbon::parse($audition->start_date)->format('d F,Y') }}
                                <span class="text-success">-</span><span class="text-danger"> End
                                    {{ \Carbon\Carbon::parse($audition->end_date)->format('d F,Y') }}</span>
                            </h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 card py-3 mr-1">
                            Audition Registration Start
                            <h4 class="text-warning">
                                {{ \Carbon\Carbon::parse($audition->user_reg_start_date)->format('d F,Y') }} <span
                                    class="text-success">-</span><span class="text-danger"> End
                                    {{ \Carbon\Carbon::parse($audition->user_reg_end_date)->format('d F,Y') }}</span></h4>
                        </div>
                    </div>

                    <h4 class="px-2 pt-2 mt-3">Instructions</h4>
                    <div class="under-line-x"></div>
                    <div class="px-2 pb-2"> {!! $audition->instruction !!} </div>
                </div>

                <div class="col-md-4">
                    <div class="card px-5 py-3">
                        <h3> Judge Panel</h3>
                        @foreach ($judges as $star)
                            <div class="row">
                                <div class="col-xs-6 content-center">
                                    <img src="{{ asset($star->user->image ?? get_static_option('no_image')) }}"
                                        style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray" />
                                </div>
                                <div class="col-xs-6">
                                    <h3>{{ $star->user ? $star->user->first_name : '' }}
                                        {{ $star->user ? $star->user->last_name : '' }}</h3>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>

            </div>

            @if ($audition->status == 2)
                <div class="card row">
                    <div class="card-header"
                        style="color: gold; letter-spacing: .01rem; font-size: 18px; border-bottom: 1px solid #000;">
                        Publish Post in News Feed
                    </div>
                    <div class="card-body">
                        <form action="{{ route('managerAdmin.audition.set_publish', [$audition->id]) }}" method="post">
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
                            <button type="submit" class="btn btn-outline-success mr-2">Publish Now</button>
                        </form>

                    </div>

                </div>
            @endif

            @if ($audition->status == 3)
                <form action="{{ route('managerAdmin.audition.set_publish', [$audition->id]) }}" method="post">
                    @csrf
                    <button type="submit" class="btn btnRemove mr-2">Remove From Publish</button>
                </form>
            @endif

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
