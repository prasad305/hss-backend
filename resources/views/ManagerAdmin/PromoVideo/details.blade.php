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
                    <h1 class="m-0">Promo Video</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Promo Video Details</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <div class="content">
        <div class="container-fluid mb-4">

            <div class="row">

                <div class="col-md-8 mb-2">
                    <div class="card p-2">
                        <video class="card-img-details " controls>
                            <source src="{{ asset($promoVideo->video_url) }}" />
                        </video>
                    </div>
                </div>

                <div class="col-md-4 mb-2">

                    <div class="col-md-12 d-flex mb-2 p-2 bg-dark align-items-center card-rounded">
                        <div class="">
                            @if (false)
                                <img src="{{ asset($promoVideo->star->image) }}" class="img-star-x" alt="Demo Image" />
                            @else
                                <a href="{{ asset('demo_image/demo_user.png') }}" target="_blank">
                                    <img src="{{ asset('demo_image/demo_user.png') }}" class="img-star-x"
                                        alt="Demo Image" />
                                </a>
                            @endif
                        </div>
                        <div class="mx-2">
                            <label for="">Star</label>
                            <h5>{{ $promoVideo->star->first_name }} {{ $promoVideo->star->last_name }}</h5>

                        </div>
                    </div>
                    <div class="col-md-12 d-flex mb-2 p-2 bg-dark align-items-center card-rounded">
                        <div class="">
                            @if (false)
                                <img src="{{ asset($promoVideo->star->image) }}" class="img-star-x" alt="Demo Image" />
                            @else
                                <a href="{{ asset('demo_image/demo_user.png') }}" target="_blank">
                                    <img src="{{ asset('demo_image/demo_user.png') }}" class="img-star-x"
                                        alt="Demo Image" />
                                </a>
                            @endif
                        </div>
                        <div class="mx-2">
                            <label for="">Admin</label>
                            <h5>{{ $promoVideo->admin->first_name }} {{ $promoVideo->admin->last_name }}</h5>

                        </div>
                    </div>


                </div>

                <div class="col-md-12 mb-2">
                    <div class=" card px-3 py-3">
                        <div>
                            <h4>{{ $promoVideo->title }}</h4>
                            <div class="title-text text-warning">Description</div>

                            <div class="description-text">{!! $promoVideo->description !!}</div>

                        </div>
                    </div>
                </div>

                <div class="col-md-3  mb-2">
                    <div class="card px-3 p-2">
                        <label for="Date">Date</label>
                        <h4 class="text-warning">
                            {{ \Carbon\Carbon::parse($promoVideo->date)->format('d F,Y') }}</h4>
                    </div>
                </div>

            </div>


            <div class="card row mx-1">

                <div class="card-header"
                    style="color: gold; letter-spacing: .01rem; font-size: 18px; border-bottom: 1px solid #000;">
                    Publish in News Feed
                </div>

                <div class="card-body">

                    <form action="{{ route('managerAdmin.promoVideo.set_publish', [$promoVideo->id]) }}" method="post">

                        @if ($promoVideo->status != 2)
                            @csrf

                            <div class="row">
                                <div class="mb-3 col-md-3">
                                    <label for="start_date" class="form-label">Post Start Date</label>
                                    <input type="calender" class="form-control input-post" id="datepicker"
                                        name="publish_start_date" readonly="readonly"
                                        value="{{ old('publish_start_date') }}" />
                                    <i class="fa fa-calendar"
                                        style="position: absolute; top: 41px; left: 18px; font-size: 20px;"
                                        aria-hidden="true"></i>
                                    @if ($errors->has('publish_start_date'))
                                        <span class="text-danger">{{ $errors->first('publish_start_date') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label for="end_date" class="form-label">Post End Date</label>
                                    <input type="text" class="form-control input-post" id="datepicker1"
                                        name="publish_end_date" readonly="readonly" value="{{ old('publish_end_date') }}">
                                    <i class="fa fa-calendar"
                                        style="position: absolute; top: 41px; left: 18px; font-size: 20px;"
                                        aria-hidden="true"></i>
                                    @if ($errors->has('publish_end_date'))
                                        <span class="text-danger">{{ $errors->first('publish_end_date') }}</span>
                                    @endif
                                </div>
                            </div>

                            <button type="submit" class="btn btnPublish mr-2" href="">Publish Now</button>
                        @endif

                        @if ($promoVideo->status == 2)
                            <form action="{{ route('managerAdmin.promoVideo.set_publish', [$promoVideo->id]) }}"
                                method="post">
                                @csrf
                                <button type="submit" class="btn btnRemove mr-2 mb-2">Remove From Publish</button>
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
                maxDate: ""
            });
        });

        $(function() {
            $("#datepicker1").datepicker({
                minDate: "{{ \Carbon\Carbon::now()->format('m/d/Y') }}",
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
