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
                    <h1 class="m-0">Q&A Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Q&A</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="content">

        <div class="container-fluid">

            <div class="row">
                <div class="col-12 col-sm-6 col-md-12">
                    <div class="info-box text-center">
                        <div class="info-box-content">
                            <span class="info-box-text text-warning">Q&A</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($qna as $post)
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3 text-center border border-warning">
                            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-blog"></i></span>
                            <div class="info-box-content">
                                <span>{!! Str::words($post->title, 5, ' ...') !!}</span>
                                <span>{{ date('d M Y', strtotime($post->created_at)) }}</span>

                                <span class="info-box-number">
                                    <small><a class="text-warning"
                                            href="{{ route('managerAdmin.dashboard.qnaDetails', $post->id) }}">See
                                            All</a></small>
                                </span>
                                @if ($post->status < 2)
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($post->status == 2)
                                    <span class="badge badge-success">Published</span>
                                @else
                                    <span class="badge badge-primary">Completed</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
