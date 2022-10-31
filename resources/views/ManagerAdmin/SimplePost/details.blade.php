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
                    <h1 class="m-0">Post</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Post Details</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-8 mb-3">
                    <div class="card p-2">
                        <div class="center">
                            @if ($post->image)
                                <img src="{{ asset($post->image) }}" class="card-img" />
                            @elseif($post->video)
                                <video class="card-img" controls src="{{ asset($post->video) }}"></video>
                            @else
                                <a href="{{ asset('demo_image/banner.jpg') }}" target="_blank">
                                    <img src="{{ asset('demo_image/banner.jpg') }}" alt="Demo Image" class="card-img"/>
                                </a>
                            @endif
                        </div>
                    </div>

                </div>

                <div class="col-md-4">
                    <div class="card px-3 py-3">
                        <div class="d-flex mb-3 align-content-center  ">
                            <div class="">
                                @if($post->star->image)
                                    <img src="{{ asset($post->star->image) }}" class="star-img" />
                                @else
                                    <a href="{{ asset('demo_image/demo_user.png') }}" target="_blank">
                                        <img src="{{ asset('demo_image/demo_user.png') }}" alt="Demo Image" class="star-img"/>
                                    </a>
                                @endif
                            </div>
                            <div class="px-3">
                                Star
                                <h4>{{ $post->star->first_name }} {{ $post->star->last_name }}</h4>
                            </div>
                        </div>

                        <div class="d-flex mb-3 align-content-center  ">
                            <div class="">
                                @if($post->admin->image)
                                    <img src="{{ asset($post->admin->image) }}"class="star-img" />
                                @else
                                    <a href="{{ asset('demo_image/demo_user.png') }}" target="_blank">
                                        <img src="{{ asset('demo_image/demo_user.png') }}" alt="Demo Image" class="star-img"/>
                                    </a>
                                @endif
                            </div>
                            <div class="px-3">
                                Admin
                                <h4>{{ $post->admin->first_name }} {{ $post->admin->last_name }}</h4>
                            </div>
                        </div>


                    </div>
                </div>


            </div>


            <div class="row pt-5 justify-content-between">

                <div class="col-md-12 ">
                    <div class=" card px-3 py-3">
                        <div>
                            <h4>{{ $post->title }}</h4>
                            <div class="title-text text-warning">Description</div>

                            <div class="description-text">{!! $post->description !!}</div>

                            <div class="col-md-4 card p-3">
                                <label for="Date">Date</label>
                                <h4 class="text-warning">{{ \Carbon\Carbon::parse($post->date)->format('d F,Y') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="container row my-3">
                @if ($post->status != 1)
                    <a type="button" class="btn btnPublish mr-2"
                        href="{{ route('managerAdmin.simplePost.set_publish', [$post->id]) }}">Publish Now</a>
                @elseif($post->status != 0)
                    <a type="button" class="btn btnRemove mr-2"
                        href="{{ route('managerAdmin.simplePost.set_publish', [$post->id]) }}">Remove From Published</a>
                @endif
                @if ($post->status < 1)
                    <a type="button" class="btn btnEdit px-5"
                        onclick="Show('Edit Post','{{ route('managerAdmin.simplePost.edit', $post->id) }}')">Edit</a>
                @endif
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
