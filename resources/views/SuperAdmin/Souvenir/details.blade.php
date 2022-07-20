@extends('Layouts.SuperAdmin.master')

@push('title')
    Super Admin
@endpush


@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Souvenir</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Souvenir Details</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <div class="content">
        <div class="container-fluid">

            {{-- <div class="row">
            <div class="col-md-6">
                @if ($post->banner)
                <img src="{{ asset($post->banner) }}" style="width: 100%" />
                @endif
                @if ($post->video)
                <iframe width="420" height="315" src="{{ asset($post->video) }}">
                </iframe>
                @endif

            </div>
        </div> --}}


            <div class="row pt-5">

                <div class="col-md-4">

                    <img src="{{ asset($post->banner) }}" style="width: 100%; border: 2px solid gold;" />


                    <!-- <div class="mt-4">
                               <iframe width="530" height="315" src="{{ asset($post->video) }}" title="Souvenir Video" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                               </div> -->

                    <div class="mt-4">
                        <iframe width="530" height="315" src="{{ asset($post->video) }}" title="Souvenir Video"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                    </div>


                </div>

                <div class="col-md-8 ">
                    <div class="row card p-5">
                        <h3>{{ $post->title }}</h3>
                        <p>
                            <b style="color: gold;">Description : </b>{!! $post->description !!}
                        </p>
                        <p>
                            <b style="color: gold;">Instruction : </b>{!! $post->instruction !!}
                        </p>
                    </div>
                    <div class="row">
                        <div class="col-md-6 card py-3">
                            Date
                            <h4 class="text-warning">{{ \Carbon\Carbon::parse($post->created_at)->format('d F,Y') }},
                                {{ \Carbon\Carbon::parse($post->created_at)->format('h:i A') }}</h4>
                        </div>
                        <div class="col-md-6 card py-3">
                            Price
                            <h4 class="text-warning">{{ $post->price }}</h4>
                        </div>
                    </div>
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

@push('script')
    {{-- <script src="{{ asset('assets/manager-admin/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script> --}}
    <script src="{{ asset('assets/manager-admin/pages/dashborad.js') }}"></script>
@endpush
