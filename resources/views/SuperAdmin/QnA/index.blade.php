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
                    <h1 class="m-0">Categories</h1>
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
                @foreach ($categories as $category)
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-list-alt"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">{{ $category->name }}</span>
                                <span class="info-box-number">
                                    <small><a class="text-warning"
                                            href="{{ route('superAdmin.qna.list', $category->id) }}">see
                                            QnA</a></small>
                                </span>
                            </div>

                        </div>

                    </div>
                @endforeach
            </div>


        </div> <!-- container -->
    </div> <!-- content -->
@endsection
