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
            <div class="card-header">
                <h3 class="card-title"></h3>
                <a class="btn btn-success btn-sm" style="float: right;"
                    href="{{ route('superAdmin.simplePost.index') }}"><i class=" fa fa-arrow"></i>&nbsp;Go Back</a>
            </div>
            <div class="row">
                <div class="col-md-6">
                    @if ($post->image)
                        <img src="{{ asset($post->image) }}" style="width: 100%" />
                    @elseif($post->video)
                        <video width="420" height="315" controls src="{{ asset($post->video) }}">
                        </video>
                    @else
                        <a href="{{ asset('demo_image/banner.jpg') }}" target="_blank">
                            <img src="{{ asset('demo_image/banner.jpg') }}" alt="Demo Image" style="width: 100%" />
                        </a>
                    @endif

                </div>
            </div>


            <div class="row pt-5">

                <div class="col-md-8 ">
                    <div class="row card p-5">
                        <h3>{{ $post->title }}</h3>
                        <p>
                            {!! $post->description !!}
                        </p>
                    </div>
                    <div class="row">
                        <div class="col-md-6 card py-3">
                            Date
                            <h4 class="text-warning">{{ \Carbon\Carbon::parse($post->date)->format('d F,Y') }}</h4>
                        </div>

                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card px-5 py-3">
                        <div class="row">
                            <div class="col-xs-6 content-center">
                                @if($post->star->image)
                                    <img src="{{ asset($post->star->image) }}"
                                        style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray" />
                                @else
                                    <a href="{{ asset('demo_image/demo_user.png') }}" target="_blank">
                                        <img src="{{ asset('demo_image/demo_user.png') }}" alt="Demo Image" style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray" />
                                    </a>
                                @endif
                            </div>
                            <div class="col-xs-6">
                                Star
                                <h3>{{ $post->star->first_name }} {{ $post->star->last_name }}</h3>
                            </div>
                        </div>
                        <div class="row py-3">
                            <div class="col-xs-6 content-center">
                                @if($post->admin->image)
                                <img src="{{ asset($post->admin->image) }}"
                                    style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray" />
                                @else
                                    <a href="{{ asset('demo_image/banner.jpg') }}" target="_blank">
                                        <img src="{{ asset('demo_image/banner.jpg') }}" alt="Demo Image" style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray" />
                                    </a>
                                @endif
                            </div>
                            <div class="col-xs-6">
                                Admin
                                <h3>{{ $post->admin->first_name }} {{ $post->admin->last_name }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <div class="container row">
                @if ($post->status >= 1)
                    <a type="button" class="btn btn-outline-warning px-5">Published</a>
                @else
                    <a type="button" class="btn btn-outline-success mr-2">Pending</a>
                @endif
            </div>

        </div> <!-- container -->
    </div> <!-- content -->
@endsection
