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
                    <h1 class="m-0">Post List</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Post List</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->



    <div class="content">

        <div class="container-fluid">



            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Post List</h3>
                    <a class="btn btn-success btn-sm" style="float: right;"
                        href="{{ route('superAdmin.simplePost.index') }}"><i class=" fa fa-arrow"></i>&nbsp;Go Back</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Photo or Video</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th style="width: 150px">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($postList as $key => $post)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        @if ($post->image)
                                            <img src="{{ asset($post->image) }}" style="width: 100%" />
                                        @else
                                            <video width="100" height="100" src="{{ asset($post->video) }}">
                                            </video>
                                        @endif
                                    </td>
                                    <td>{{ $post->title }}</td>
                                    <td>{!! Str::words("$post->description", 10, '...') !!}</td>
                                    <td>
                                        @if ($post->status >= 1)
                                            <span class="badge badge-success">Published<span>
                                                @else
                                                    <span class="badge badge-warning">Pending<span>
                                        @endif
                                    </td>
                                    <td style="width: 150px">
                                        <a href="{{ route('superAdmin.simplePost.details', [$post->id]) }}"
                                            class="btn btn-sm btn-success"> <i class="fa fa-eye"></i></a>
                                        <a class="btn btn-sm btn-info"
                                            onclick="Show('Edit Post','{{ route('superAdmin.simplePost.edit', $post->id) }}')"><i
                                                class="fa fa-edit text-white"></i></a>
                                        <button class="btn btn-sm btn-danger" onclick="delete_function(this)"
                                            value="{{ route('superAdmin.simplePost.destroy', $post->id) }}"><i
                                                class="fa fa-trash"></i> </button>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>




        </div> <!-- container -->
    </div> <!-- content -->
@endsection
