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
                <h1 class="m-0">FanGroup</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">FanGroup Details</li>
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
                @if($post->image)
                <img src="{{ asset($post->image) }}" style="width: 100%" />
        @else
        <iframe width="420" height="315" src="{{ $post->video }}">
        </iframe>
        @endif

    </div>
</div> --}}


<div class="row pt-5">

    <div class="col-md-4">

        <img src="{{ asset($post->banner) }}" style="width: 100%; border: 3px solid #fff; border-radius: 10px;" />

        <br>
        <br>
        <br>

        <div class="row">
            <div class="col-md-6 col-12">
                <div class="card">
                    {{-- <img class="card-img-top" src="..." alt="Card image cap"> --}}
                    <img src="{{ asset($star_one->image) }}"
                        style=" height: 210px; border-radius: 50%; text-align: center; border: 3px solid #59df06; "
                        alt="">
                    <div class="card-body">
                        <h2 class="card-title" style="font-weight: 600; font-size: 20px; color: #55e51b; ">
                            {{ $star_one->first_name }} {{ $star_one->last_name }} </h2>&nbsp;&nbsp
                        @if($post->my_star_status == 1)
                        <span class="badge badge-info">Accepted</span>
                        @else
                        <span class="badge badge-danger">Pending</span>
                        @endif
                        <br>
                        <hr>
                        <p class="">{{ $star_one->phone }}</p>

                        <p class="">{{ $star_one->email }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="card">
                    {{-- <img class="card-img-top" src="..." alt="Card image cap"> --}}
                    <img src="{{ asset($another_star->image) }}"
                        style=" height: 210px; border-radius: 50%; text-align: center; border: 3px solid #59df06; "
                        alt="">
                    <div class="card-body">
                        <h2 class="card-title" style="font-weight: 600; font-size: 20px; color: #55e51b; ">
                            {{ $another_star->first_name }} {{ $another_star->last_name }} </h2>&nbsp;&nbsp
                        @if($post->another_star_status == 1)
                        <span class="badge badge-info">Accepted</span>
                        @else
                        <span class="badge badge-danger">Pending</span>
                        @endif
                        <br>
                        <hr>
                        <p class="">{{ $another_star->phone }}</p>

                        <p class="">{{ $another_star->email }}</p>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="col-md-8 ">
        <div class="row card p-5">
            <h3 style="border-bottom: 1px solid #000; padding-bottom: 19px;">{{ $post->group_name }}</h3>
            <p>
                {!! $post->description !!}
            </p>
        </div>
        <div class="row">
            <div class="col-md-6 card py-3">
                Start Date
                <h4 class="text-warning">{{ \Carbon\Carbon::parse($post->start_date)->format('d F,Y')}}</h4>
                Min Member
                <h4 class="text-warning">{{ $post->min_member }}</h4>
            </div>
            <div class="col-md-6 card py-3">
                End Date
                <h4 class="text-warning">{{ \Carbon\Carbon::parse($post->end_date)->format('d F,Y')}}</h4>
                Max Member
                <h4 class="text-warning">{{ $post->max_member }}</h4>
            </div>
        </div>

        <div class="card">
            <div class="card-header"
                style="color: gold; letter-spacing: .01rem; font-size: 18px; border-bottom: 1px solid #000;">
                Publish Post in News Feed
            </div>
            <div class="card-body">
                <form action="{{ route('managerAdmin.fangroup.set_publish') }}" method="post">
                    @csrf
                    <input type="hidden" name="postId" value="{{ $post->id }}" />
                    <div class="row">
                        <div class="mb-3 col-md-6 col-6">
                            <label for="start_date" class="form-label">Post Start Date</label>
                            <input type="calender" class="form-control" id="datepicker"
                                style="background: coral; position: relative; padding-left: 33px;"
                                name="post_start_date" readonly="readonly" />
                            <i class="fa fa-calendar"
                                style="position: absolute; top: 41px; left: 18px; font-size: 20px;"
                                aria-hidden="true"></i>
                                @if ($errors->has('post_start_date'))
                                    <span class="text-danger">{{ $errors->first('post_start_date') }}</span>
                                @endif
                        </div>
                        <div class="mb-3 col-md-6 col-6">
                            <label for="end_date" class="form-label">Post End Date</label>
                            <input type="text" class="form-control" id="datepicker1"
                                style="background: coral; position: relative; padding-left: 33px;" name="post_end_date"
                                readonly="readonly">
                            <i class="fa fa-calendar"
                                style="position: absolute; top: 41px; left: 18px; font-size: 20px;"
                                aria-hidden="true"></i>
                            @if ($errors->has('post_end_date'))
                                <span class="text-danger">{{ $errors->first('post_end_date') }}</span>
                            @endif
                        </div>
                    </div>


                    @if($post->status != 1)
                    <button type="submit" class="btn btn-outline-success mr-2" href="">Publish Now</button>
                    @elseif($post->status != 0)
                    <button type="submit" class="btn btn-outline-danger mr-2">Remove From Publish</button>
                    @endif
                    @if($post->status != 1)
                    <a type="button" class="btn btn-outline-warning px-5"
                        onclick="Show('Edit FanGroup','{{ route('managerAdmin.fangroup.edit', $post->id) }}')">Edit</a>
                    @endif
                </form>
                <br>
                <br>

            </div>

        </div>
    </div>







</div>

{{-- <div class="col-md-4">
                <div class="card px-5 py-3">
                    <div class="row">
                        <div class="col-xs-6 content-center">
                            <img src="{{ asset($post->image) }}" style="height: 80px; width: 80px; border-radius: 50%;
border: 2px solid gray" />
</div>
<div class="col-xs-6">
    Star
    <h3>{{ $post->star->first_name }} {{ $post->star->last_name }}</h3>
</div>
</div>
<div class="row py-3">
    <div class="col-xs-6 content-center">
        <img src="{{ asset($post->admin->image) }}"
            style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray" />
    </div>
    <div class="col-xs-6">
        Admin
        <h3>{{ $post->admin->first_name }} {{ $post->admin->last_name }}</h3>
    </div>
</div>
</div>
</div> --}}

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
        minDate: 0,
        maxDate: "<?php echo \Carbon\Carbon::parse($post->start_date)->format('m/d/Y') ?>"
    });
});

$(function() {
    $("#datepicker1").datepicker({
        minDate: "<?php echo \Carbon\Carbon::parse($post->end_date)->format('m/d/Y') ?>",
        maxDate: "+100000D"
    });
});
</script>
@endpush


@push('jsstyle')

<!-- <script src="https://code.jquery.com/jquery-3.6.0.js"></script> -->
  <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
  
@endpush