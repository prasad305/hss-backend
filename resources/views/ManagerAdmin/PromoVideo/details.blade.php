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
                <h1 class="m-0">Promo Video</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Promo Video Details</li>
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
                <video width="800" controls>
                    <source src="{{asset($promoVideo->video_url)}}" />
                </video>
            </div>
        </div>


        <div class="row pt-5">

            <div class="col-md-8 ">
                <div class="row card p-5">
                    <h3>{{ $promoVideo->title }}</h3>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card px-5 py-3">
                    <div class="row">
                        <div class="col-xs-6 content-center">
                            <img src="{{ asset($promoVideo->star->image) }}" style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray" />
                        </div>
                        <div class="col-xs-6">
                            Star
                            <h3>{{ $promoVideo->star->first_name }} {{ $promoVideo->star->last_name }}</h3>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-xs-6 content-center">
                            <img src="{{ asset($promoVideo->admin->image) }}" style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray" />
                        </div>
                        <div class="col-xs-6">
                            Admin
                            <h3>{{ $promoVideo->admin->first_name }} {{ $promoVideo->admin->last_name }}</h3>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        @if ($promoVideo->status != 2)
        <div class="card row">
            <div class="card-header"
                style="color: gold; letter-spacing: .01rem; font-size: 18px; border-bottom: 1px solid #000;">
                Publish in News Feed
            </div>
            <div class="card-body">
                <form action="{{ route('managerAdmin.promoVideo.set_publish', [$promoVideo->id]) }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6 col-6">
                            <label for="start_date" class="form-label">Post Start Date</label>
                            <input type="calender" class="form-control" id="datepicker"
                                style="background: coral; position: relative; padding-left: 33px;"
                                name="publish_start_date" readonly="readonly" value="{{ old('publish_start_date') }}" />
                            <i class="fa fa-calendar"
                                style="position: absolute; top: 41px; left: 18px; font-size: 20px;"
                                aria-hidden="true"></i>
                            @if ($errors->has('publish_start_date'))
                            <span class="text-danger">{{ $errors->first('publish_start_date') }}</span>
                            @endif
                        </div>
                        <div class="mb-3 col-md-6 col-6">
                            <label for="end_date" class="form-label">Post End Date</label>
                            <input type="text" class="form-control" id="datepicker1"
                                style="background: coral; position: relative; padding-left: 33px;"
                                name="publish_end_date" readonly="readonly" value="{{ old('publish_end_date') }}">
                            <i class="fa fa-calendar"
                                style="position: absolute; top: 41px; left: 18px; font-size: 20px;"
                                aria-hidden="true"></i>
                            @if ($errors->has('publish_end_date'))
                            <span class="text-danger">{{ $errors->first('publish_end_date') }}</span>
                            @endif
                        </div>
                    </div>


                    <button type="submit" class="btn btn-outline-success mr-2" href="">Publish Now</button>
                    {{-- <a type="button" class="btn btn-outline-warning px-5"
                        onclick="Show('Edit Live Chat Event','{{ route('managerAdmin.promoVideo.edit', $promoVideo->id) }}')">Edit</a> --}}



                </form>

            </div>

        </div>
        @endif
        @if ($promoVideo->status == 2)
        <form action="{{ route('managerAdmin.promoVideo.set_publish', [$promoVideo->id]) }}" method="post">
            @csrf
            <button type="submit" class="btn btn-outline-danger mr-2">Remove From Publish</button>
        </form>
        @endif
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
                minDate: "{{\Carbon\Carbon::now()->format('m/d/Y')}}",
                maxDate: ""
            });
        });

        $(function() {
            $("#datepicker1").datepicker({
                minDate: "{{\Carbon\Carbon::now()->format('m/d/Y')}}",
                maxDate: "+100000D"
            });
        });
</script>
@endpush

@push('script')
{{-- <script src="{{ asset('assets/manager-admin/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script> --}}
<script src="{{ asset('assets/manager-admin/pages/dashborad.js') }}"></script>
@endpush

@push('jsstyle')
<!-- <script src="https://code.jquery.com/jquery-3.6.0.js"></script> -->
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
@endpush