@extends('Layouts.ManagerAdmin.master')

@push('title')
Manager Admin
@endpush


@section('content')
<style>
    .banner-image {
        height: 300px;
        object-fit: cover;
    }
</style>



<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Audition </h1>
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
            @if ($instruction->image != null)
            <img src="{{ asset($instruction->image) }}" style="width: 100%" class="banner-image" />
            @endif
        </div>

        <div class="row">
         <video controls>
            <source src="{{asset($instruction->video)}}" />
        </video>
        </div>


        <div class="row py-5">
            <div class="col-md-8 ">
                <div class="row card p-5">
                    <u>Instruction</u>
                    <p>
                        {!! $instruction->instruction !!}
                    </p>
                </div>

               
            </div>    
        </div>

        @if ($event->status != 2)
        <div class="card row">
            <div class="card-header"
                style="color: gold; letter-spacing: .01rem; font-size: 18px; border-bottom: 1px solid #000;">
                Publish Post in News Feed
            </div>
            <div class="card-body">
                {{-- <form action="{{ route('managerAdmin.learningSession.set_publish', [$event->id]) }}" method="post"> --}}
                <form action="{{ route('managerAdmin.audition.set_publish', [$event->id]) }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6 col-6">
                            <label for="start_date" class="form-label">Post Start Date</label>
                            <input type="calender" class="form-control" id="datepicker"
                                style="background: coral; position: relative; padding-left: 33px;"
                                name="post_start_date" readonly="readonly" value="{{ old('post_start_date') }}" />
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
                                style="background: coral; position: relative; padding-left: 33px;"
                                name="post_end_date" readonly="readonly" value="{{ old('post_end_date') }}">
                            <i class="fa fa-calendar"
                                style="position: absolute; top: 41px; left: 18px; font-size: 20px;"
                                aria-hidden="true"></i>
                            @if ($errors->has('post_end_date'))
                            <span class="text-danger">{{ $errors->first('post_end_date') }}</span>
                            @endif
                        </div>
                    </div>


                    <button type="submit" class="btn btn-outline-success mr-2" href="">Publish Now</button>
                    {{-- <a type="button" class="btn btn-outline-warning px-5"
                        onclick="Show('Edit Live Chat Event','{{ route('managerAdmin.learningSession.edit', $event->id) }}')">Edit</a> --}}



                </form>

            </div>

        </div>
        @endif

        @if ($event->status == 2)
        <form action="{{ route('managerAdmin.audition.set_publish', [$event->id]) }}" method="post">
            @csrf
            <button type="submit" class="btn btn-outline-danger mr-2">Remove From Publish</button>
        </form>
        @endif



    </div>
</div>



@if (session()->has('success'))
<script type="text/javascript">
    $(document).ready(function() {
                // notify('{{ session()->get('success') }}','success');
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: '{{ Session::get('success') }}',
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
                maxDate: "<?php echo \Carbon\Carbon::parse($event->registration_start_date)->format('m/d/Y'); ?>"
            });
        });

        $(function() {
            $("#datepicker1").datepicker({
                minDate: "<?php echo \Carbon\Carbon::parse($event->info->instruction_prepare_end_date)
                    ->addDays(1)
                    ->format('m/d/Y'); ?>",
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