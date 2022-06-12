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
            <div class="col-md-6">
                @if($post->image)
                <img src="{{ asset($post->image) }}" style="width: 100%" />
                @else
                <video width="420" height="315" controls src="{{ asset($post->video) }}">
                </video>
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
                        <h4 class="text-warning">{{ \Carbon\Carbon::parse($post->date)->format('d F,Y')}}</h4>
                    </div>

                </div>
            </div>

            <div class="col-md-4">
                <div class="card px-5 py-3">
                    <div class="row">
                        <div class="col-xs-6 content-center">
                            <img src="{{ asset($post->star->image) }}" style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray" />
                        </div>
                        <div class="col-xs-6">
                            Star
                            <h3>{{ $post->star->first_name }} {{ $post->star->last_name }}</h3>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-xs-6 content-center">
                            <img src="{{ asset($post->admin->image) }}" style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray" />
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
            @if($post->status != 1)
            <a type="button" class="btn btn-outline-success mr-2" href="{{ route('managerAdmin.simplePost.set_publish', [$post->id]) }}">Publish Now</a>
            @elseif($post->status != 0)
            <a type="button" class="btn btn-outline-danger mr-2" href="{{ route('managerAdmin.simplePost.set_publish', [$post->id]) }}">Remove From Published</a>
            @endif
            @if ($post->status <1 )              
            <a type="button" class="btn btn-outline-warning px-5" onclick="Show('Edit Post','{{ route('managerAdmin.simplePost.edit', $post->id) }}')">Edit</a>
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
