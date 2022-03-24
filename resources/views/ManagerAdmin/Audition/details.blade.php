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
                <h1 class="m-0">Audition</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Audition Details</li>
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
                @if($audition->banner)
                <img src="{{ asset($audition->banner) }}" style="width: 40%" />
                @endif

            </div>
        </div>


        <div class="row pt-5">

            <div class="col-md-8 ">
                <div class="row card p-5">
                    <h3>{{ $audition->name }}</h3>
                    <p>
                        {!! $audition->details !!}
                    </p>
                </div>
                <div class="row">
                    <div class="col-md-3 card py-3 mr-1">
                        Date
                        <h4 class="text-warning">{{ \Carbon\Carbon::parse($audition->created_at)->format('d F,Y')}}</h4>
                    </div>
                    <div class="col-md-3 card py-3 mr-1">
                        Time
                        <h4 class="text-warning">Reselase {{ \Carbon\Carbon::parse($audition->bid_from)->format('h:i A')}} - End {{ \Carbon\Carbon::parse($audition->bid_to)->format('h:i A')}}</h4>
                    </div>
                    <div class="col-md-3 card py-3">
                        Base Price
                        <h4 class="text-warning">$ {{$audition->base_price}}</h4>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card px-5 py-3">
                    <div class="row">
                        <div class="col-xs-6 content-center">
                            <img src="{{ asset($audition->star->image) }}" style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray" />
                        </div>
                        <div class="col-xs-6">
                            Star
                            <h3>{{ $audition->star->first_name }} {{ $audition->star->last_name }}</h3>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-xs-6 content-center">
                            <img src="{{ asset($audition->admin->image) }}" style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray" />
                        </div>
                        <div class="col-xs-6">
                            Admin
                            <h3>{{ $audition->admin->first_name }} {{ $audition->admin->last_name }}</h3>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div class="container row">
            @if($audition->status != 1)
            <a type="button" class="btn btn-outline-success mr-2" href="{{ route('managerAdmin.audition.set_publish', [$audition->id]) }}">Publish Now</a>
            @elseif($audition->status != 0)
            <a type="button" class="btn btn-outline-danger mr-2" href="{{ route('managerAdmin.audition.set_publish', [$audition->id]) }}">Remove From Publish</a>
            @endif
            <a type="button" class="btn btn-outline-warning px-5" onclick="Show('Edit Post','{{ route('managerAdmin.audition.edit', $audition->id) }}')">Edit</a>
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