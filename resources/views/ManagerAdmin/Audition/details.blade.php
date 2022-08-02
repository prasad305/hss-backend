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
                <div class="card p-2">
                    @if($audition->banner)
                <img src="{{ asset($audition->banner) }}" class="img-fulid" style="height: 41vh" />
                @endif
                </div>
            </div>
            <div class="col-md-6">
                    <div class="mb-3">
                        <div class="row mb-1">
                            <div class="col-md-12 ">
                                <div class="bg-dark p-2">
                                    Judge Panel
                                </div>
                            </div>
                        </div>

                        <div class="row mt-1 mx-1">
                            @foreach($judges as $star)
                            <div class="col-md-6">
                                <div class="row bg-dark px-2 pt-2">
                                    <div class="col-md-12 mb-2">
                                        <div class="bg-black  p-2">
                                           <div class="d-flex">
                                            <div class="col-md-4 d-flex justify-content-center align-items-center">
                                                <img src="{{ asset( $star->user->image ?? get_static_option('no_image')) }}" style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray"  />
                                            </div>
                                            <div class="col-md-8 justify-conent-cenet align-items-center pt-2 px-3">
                                                <small>Jury Name</small>
                                                <div>{{ $star->user ? $star->user->first_name : ''}} {{ $star->user ? $star->user->last_name : ''}}</div>
                                            </div>
                                           </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                    </div>

                    <div class="mb-3">
                        <div class="row mb-1">
                            <div class="col-md-12 ">
                                <div class="bg-dark p-2">
                                    Date
                                </div>
                            </div>
                        </div>

                        <div class="row mt-1 mx-1">
                            <div class="col-md-6">
                                <div class="row bg-dark px-2 pt-2">
                                    <div class="col-md-12 mb-2">
                                        <div class="bg-black  p-2">
                                           <div class="d-flex">
                                            <div class="col-md-4 d-flex justify-content-center align-items-center">
                                                <img src="{{ asset('/assets/manager-admin/calendar.jpg')}}" style="height: 50px; width: 50px; border-radius: 50%; border: 2px solid gray"  />
                                            </div>
                                            <div class="col-md-8 justify-conent-cenet align-items-center pt-2 px-3">
                                                <small>Audition Start Date</small>
                                                <div>{{ \Carbon\Carbon::parse($audition->start_date)->format('d F,Y')}} <span class="text-success"></div>
                                            </div>
                                           </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row bg-dark px-2 pt-2">
                                    <div class="col-md-12 mb-2">
                                        <div class="bg-black  p-2">
                                           <div class="d-flex">
                                            <div class="col-md-4 d-flex justify-content-center align-items-center">
                                                <img src="{{ asset('/assets/manager-admin/calendar.jpg')}}" style="height: 50px; width: 50px; border-radius: 50%; border: 2px solid gray"  />
                                            </div>
                                            <div class="col-md-8 justify-conent-cenet align-items-center pt-2 px-3">
                                                <small>Audition Start Date</small>
                                                <div>{{ \Carbon\Carbon::parse($audition->start_date)->format('d F,Y')}} <span class="text-success"></div>
                                            </div>
                                           </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row bg-dark px-2 pt-2">
                                    <div class="col-md-12 mb-2">
                                        <div class="bg-black  p-2">
                                           <div class="d-flex">
                                            <div class="col-md-4 d-flex justify-content-center align-items-center">
                                                <img src="{{ asset('/assets/manager-admin/calendar.jpg')}}" style="height: 50px; width: 50px; border-radius: 50%; border: 2px solid gray"  />
                                            </div>
                                            <div class="col-md-8 justify-conent-cenet align-items-center pt-2 px-3">
                                                <small>Audition Start Registration Date</small>
                                                <div>{{ \Carbon\Carbon::parse($audition->user_reg_start_date)->format('d F,Y')}} <span class="text-success"></div>
                                            </div>
                                           </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row bg-dark px-2 pt-2">
                                    <div class="col-md-12 mb-2">
                                        <div class="bg-black  p-2">
                                           <div class="d-flex">
                                            <div class="col-md-4 d-flex justify-content-center align-items-center">
                                                <img src="{{ asset('/assets/manager-admin/calendar.jpg')}}" style="height: 50px; width: 50px; border-radius: 50%; border: 2px solid gray"  />
                                            </div>
                                            <div class="col-md-8 justify-conent-cenet align-items-center pt-2 px-3">
                                                <small>Audition End Registration Date</small>
                                                <div>{{ \Carbon\Carbon::parse($audition->user_reg_end_date)->format('d F,Y')}} <span class="text-success"></div>
                                            </div>
                                           </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="bg-dark  mb-1">
                    <h4 class="px-2 pb-2">{{ $audition->name }}</h4>
                </div>
                <div class="bg-dark  mb-1">

                    <h4 class="px-2 pt-2">Description</h4>
                    <div class="under-line-x"></div>
                    <div class="p-2"> {!! $audition->description !!} </div>

                    <h4 class="px-2 pt-2 mt-3">Instructions</h4>
                    <div class="under-line-x"></div>
                    <div class="px-2 pb-2"> {!! $audition->instruction !!} </div>
                </div>
            </div>
        </div>

        @if ($audition->status == 2)
        <div class="card row mt-3 mx-1">
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
                            <input type="calendar" class="form-control" id="datepicker"
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

        <center class="my-4">
            @if ($audition->status == 3)
                <form action="{{ route('managerAdmin.audition.set_publish', [$audition->id]) }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger mr-2">Remove From Publish</button>
                </form>
            @endif
        </center>

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
                minDate: "{{\Carbon\Carbon::now()->format('m/d/Y')}}",
                maxDate: "<?php echo \Carbon\Carbon::parse($audition->end_date)->format('m/d/Y'); ?>"
            });
        });

        $(function() {
            $("#datepicker1").datepicker({
                minDate: "<?php echo \Carbon\Carbon::parse($audition->end_date)
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
