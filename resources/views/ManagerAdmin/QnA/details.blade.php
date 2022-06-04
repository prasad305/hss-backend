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
                    <h1 class="m-0">QnA Event</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">QnA Event Details</li>
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
                    <img src="{{ asset($event->banner) }}" style="width: 100% " />
                </div>
                <div class="col-md-6">
                    <video width="100%" height="360" controls src="{{ asset($event->video) }}">
                    </video>
                </div>
            </div>
            <h3>{{ $event->title }}</h3>

            <div class="row pt-5">

                <div class="col-md-6 ">
                    <div class=" card p-2">
                        <h1 class="text-warning">Descriptions</h1>
                        {!! $event->description !!}
                    </div>
                </div>
                <div class="col-md-6 ">
                    <div class=" card p-2">
                        <h1 class="text-warning">Instructions</h1>
                        {!! $event->instruction !!}
                    </div>
                </div>
            </div>



            <div class="row pt-3">

                <div class="col-md-3">
                    <div class="card py-3 p-2">
                        Fees
                        <h4 class="text-warning">$ {{ $event->fee }}</h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card py-3 p-2">
                        Registration Date
                        <h4 class="text-warning"><h4 class="text-warning">{{ \Carbon\Carbon::parse($event->registration_start_date)->format('d F,Y') }} - {{ \Carbon\Carbon::parse($event->registration_start_date)->format('d F,Y') }}</h4></h4>
                    </div>

                </div>

                <div class="col-md-3">
                    <div class="card py-3 p-2">
                        Event Date
                        <h4 class="text-warning">{{ \Carbon\Carbon::parse($event->date)->format('d F,Y') }}</h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card py-3 p-2">
                        Event Time
                        <h4 class="text-warning">{{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }} -
                            {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}</h4>
                    </div>

                </div>

            </div>
        </div>

    </div>

        <div class="row pt-3">
            <div class="col-md-6">
    
                @if ($event->status != 1)
                    <a type="button" class="btn btn-outline-success mr-2"
                        href="{{ route('managerAdmin.qna.set_publish', [$event->id]) }}">Publish Now</a>
                @elseif($event->status != 0)
                    <a type="button" class="btn btn-outline-danger mr-2"
                        href="{{ route('managerAdmin.qna.set_publish', [$event->id]) }}">Remove From Publish</a>
                @endif
                <a type="button" class="btn btn-outline-warning px-5"
                    onclick="Show('Edit QnA Event','{{ route('managerAdmin.qna.edit', $event->id) }}')">Edit</a>
            </div>
            <div class="col-md-6">
                <div class="card px-5 py-3 mx-2">
                    <div class="row">
                        <div class="col-xs-6 content-center">
                            <img src="{{ asset($event->star->image) }}" style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray" />
                        </div>
                        <div class="col-xs-6">
                            Star
                            <h3>{{ $event->star->first_name }} {{ $event->star->last_name }}</h3>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-xs-6 content-center">
                            <img src="{{ asset($event->admin->image) }}" style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray" />
                        </div>
                        <div class="col-xs-6">
                            Admin
                            <h3>{{ $event->admin->first_name }} {{ $event->admin->last_name }}</h3>
                        </div>
                    </div>
                </div>
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

@push('script')
    {{-- <script src="{{ asset('assets/manager-admin/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script> --}}
    <script src="{{ asset('assets/manager-admin/pages/dashborad.js') }}"></script>
@endpush
