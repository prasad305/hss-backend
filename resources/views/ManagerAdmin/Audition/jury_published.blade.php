extends('Layouts.ManagerAdmin.master')

@push('title')
    Manager Admin
@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Jury Published</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Audition</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="content">

        <div class="container-fluid">
            <div class="bgAs bg-dark mb-4 ">
                <div class="row justify-content-between border-shadow">
                    <h4 class="px-5 mt-3">Round 1 </h4>
                    <h4 class="px-5 mt-3">{{ $filter_videos->count() }} Videos</h4>
                </div>
                <div class="row  mx-1 px-3 pt-3 border-around">

                    <head>

                        <!-- Stylesheets -->
                        <link href='https://fonts.googleapis.com/css?family=Lato:300,400,700,400italic,300italic'
                            rel='stylesheet' type='text/css'>
                        <link rel="stylesheet" href="assets/css/docs.theme.min.css') }}">

                        <!-- Owl Stylesheets -->

                        <link rel="stylesheet" href="{{ asset('assets/manager-admin/carousel/owl.carousel.css') }}">

                        <!-- javascript -->
                        <script src="{{ asset('assets/manager-admin/carousel/jquery.js') }}"></script>
                        <script src="{{ asset('assets/manager-admin/carousel/owl.carousel.js') }}"></script>
                    </head>

                    <body>

                        <div class="parent-box owl-carousel">

                            @foreach ($filter_videos as $video)
                                <div class="box mx-3">
                                    <video width="380" controls>
                                        <source src="{{ url($video->video_url) }}" type="video/mp4">
                                    </video>
                                </div>
                            @endforeach


                        </div>

                        <script src="jquery.js"></script>
                        <script src="owl.carousel.js"></script>
                        <script>
                            $('.owl-carousel').owlCarousel({
                                loop: true,
                                margin: 10,
                                padding: 10,
                                nav: false,
                                items: 4,
                                autoplay: false,
                                autoplayTimeout: 6000,
                                responsive: {
                                    0: {
                                        items: 1
                                    },
                                    480: {
                                        items: 2
                                    },
                                    768: {
                                        items: 3
                                    },
                                    992: {
                                        items: 4
                                    }
                                }
                            });
                        </script>
                    </body>

                </div>
            </div>

            <div class="bgAs bg-dark mb-4 ">
                <div class="row justify-content-between border-shadow">
                    <h4 class="px-5 mt-3">Available Jury</h4>
                    <h4 class="px-5 mt-3"> {{ $avaiable_juries->count() }} Jury</h4>
                </div>
                <div class="row  mx-1 px-3 pt-3 border-around">
                    @if (isset($avaiable_juries[0]))
                        @foreach ($avaiable_juries as $key => $jury)
                            <div class="col-md-4 justify-content-center">
                                <div class="card bg-light text-center  m-4 p-4">
                                    <center> 
                                        @if($jury->image)
                                            <img src="{{ asset($jury->image) }}" alt="" class="ImGCard">
                                        @else
                                            <a href="{{ asset('demo_image/demo_user.png') }}" target="_blank">
                                                <img  src="{{ asset('demo_image/demo_user.png') }}" alt="Demo Image" class="ImGCard" />
                                            </a>
                                        @endif
                                    </center>
                                    <b class=" mt-2">{{ $jury->first_name . ' ' . $jury->last_name }}</b>
                                    {{-- <small>Music Specialist</small> --}}

                                    <center>
                                        <form action="{{ route('managerAdmin.jury.AssingVideos') }}"
                                            method="post">
                                            @csrf
                                            <input type="number" name="number_of_videos" class="form-control w-50"
                                                placeholder="Number Of Video" value="{{ $video_pack[$key] }}">
                                            <input type="hidden" value="{{ $jury->id }}" name="jury_id">
                                            <input type="hidden" value="{{ $audition_id }}" name="audition_id">
                                            <button class="btn bg-info mt-3 w-75"> Apply</button>
                                        </form>
                                    </center>
                                </div>
                            </div>
                        @endforeach
                    @endif


                </div>
            </div>

            {{-- <div class="bgAs bg-dark ">
                <div class="row justify-content-between border-shadow">
                    <h4 class="px-5 mt-3">Distribution</h4>
                </div>
                <div class="row px-5">
                    <input type="text" class="from-control mx-2" placeholder="Number of jury">
                    <button class="btn btn-info px-4 Bntsx">Apply</button>
                </div>
                <div class="row  mx-1 px-3 pt-3 border-around">

                    <div class="col-md-4 justify-content-center">
                        <div class="card bg-light text-center  m-4 p-4">
                            <h5 class=" mt-5">Video pack</h5>
                            <small class="mb-4">80 Videos</small>
                            <center><button class="btn bg-info mt-3 w-75"> Coppy</button></center>
                        </div>
                    </div>
                    <div class="col-md-4 justify-content-center">
                        <div class="card bg-light text-center  m-4 p-4">
                            <h5 class=" mt-5">Video pack</h5>
                            <small class="mb-4">80 Videos</small>
                            <center><button class="btn bg-info mt-3 w-75"> Coppy</button></center>
                        </div>
                    </div>
                    <div class="col-md-4 justify-content-center">
                        <div class="card bg-light text-center  m-4 p-4">
                            <h5 class=" mt-5">Video pack</h5>
                            <small class="mb-4">80 Videos</small>
                            <center><button class="btn bg-info mt-3 w-75"> Coppy</button></center>
                        </div>
                    </div>
                    <div class="col-md-4 justify-content-center">
                        <div class="card bg-light text-center  m-4 p-4">
                            <h5 class=" mt-5">Video pack</h5>
                            <small class="mb-4">80 Videos</small>
                            <center><button class="btn bg-info mt-3 w-75"> Coppy</button></center>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div> <!-- container -->
    </div>

    <style>
        .ImGCard {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
        }

        .bgAs {
            border-radius: 10px;
        }

        @media only screen and (max-width: 600px) {
            .Bntsx {
                margin-top: 10px;
                margin-left: 8px;
            }
        }

    </style><!-- content -->
@endsection

@push('script')
    {{-- <script src="{{ asset('assets/manager-admin/assets/manager-admin/plugins/jquery-sparkline/jquery.sparkline.min.js') }}">
</script> --}}
    <script src="{{ asset('assets/manager-admin/assets/manager-admin/pages/dashborad.js') }}"></script>
@endpush

