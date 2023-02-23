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

            <div class="row">
                <div class="col-md-8 mb-2">
                    <div class="card p-2">
                        <video class="card-img-details" controls src="{{ asset($post->video) }}"></video>
                    </div>
                </div>
                <div class="col-md-4 mb-2">
                    <div class="card p-2">
                        <div class="center">
                            @if ($post->banner)
                                <img src="{{ asset($post->banner) }}" class="card-img-details" />
                            @else
                                <a href="{{ asset('demo_image/banner.jpg') }}" target="_blank">
                                    <img src="{{ asset('demo_image/banner.jpg') }}" alt="Demo Image"
                                        class="card-img-details" />
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mb-2">
                    <div class=" card px-3 py-3">
                        <div>
                            <h4>{{ $post->title }}</h4>
                            <div class="title-text text-warning">Description</div>

                            <div class="description-text">{!! $post->description !!}</div>

                            <div class="title-text text-warning">Instruction</div>

                            <div class="description-text">{!! $post->instruction !!}</div>
                        </div>
                    </div>
                </div>


                <div class="col-sm-12 col-md-4 col-lg-3 mb-2">
                    <div class="card p-3">
                        <h5>Date</h5>
                        <h6 class="text-warning">{{ \Carbon\Carbon::parse($post->created_at)->format('d F,Y') }},
                            {{ \Carbon\Carbon::parse($post->created_at)->format('h:i A') }}
                        </h6>
                    </div>
                </div>


                <div class="col-sm-12 col-md-4 col-lg-3 mb-2">
                    <div class="card p-3">
                        <h5> Price</h5>
                        <h6 class="text-warning"> $ {{ $post->price }}
                        </h6>
                    </div>
                </div>

                <div class="col-sm-12 col-md-4 col-lg-3 mb-2">
                    <div class="card p-3">
                        <h5> Tax</h5>
                        <h6 class="text-warning"> $ {{ $post->tax }} %</h6>
                    </div>
                </div>

                <div class="card col-md-12">
                    <div class="card-header"
                        style="color: gold; letter-spacing: .01rem; font-size: 18px; border-bottom: 1px solid #000;">
                        Publish Post in News Feed
                    </div>
                    <div class="card-body">
                        @if ($post->status != 1)
                            <a type="button" class="btn btnPublish mr-2"
                                href="{{ route('managerAdmin.souvenir.set_publish', [$post->id]) }}">Publish Now</a>
                        @elseif($post->status != 0)
                            <a type="button" class="btn btnRemove mr-2"
                                href="{{ route('managerAdmin.souvenir.set_publish', [$post->id]) }}">Remove From
                                Publish</a>
                        @endif
                        @if ($post->status == 0)
                            <a type="button" class="btn btnEdit px-5"
                                onclick="Show('Edit Souvenir','{{ route('managerAdmin.souvenir.edit', $post->id) }}')">Edit</a>
                        @endif
                    </div>

                </div>

            </div>

        </div>
    </div> <!-- container -->



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
