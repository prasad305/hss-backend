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
          <h1 class="m-0">Live Chat Event</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Live Chat Event Details</li>
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
                        <img src="{{ asset($event->banner) }}" style="width: 100%"/>
                    </div>
                </div>


                <div class="row pt-5">

                    <div class="col-md-8 ">
                        <div class="row card p-5">
                            <h3>{{ $event->title }}</h3>
                            <p>
                                {!! $event->description !!}
                            </p>
                        </div>
                        <div class="row">
                            <div class="col-md-6 card py-3">
                                Date
                                <h4 class="text-warning">{{ \Carbon\Carbon::parse($event->date)->format('d F,Y')}}</h4>
                            </div>
                            <div class="col-md-6 card py-3">
                                Time
                                <h4 class="text-warning">{{ \Carbon\Carbon::parse($event->start_time)->format('h:i A')}} - {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A')}}</h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card px-5">
                            <div class="row">
                                <div class="col-xs-6 content-center">
                                    <img src="{{ asset($event->star->image) }}" style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray"/>
                                </div>
                                <div class="col-xs-6">
                                    Star
                                    <h3>{{ $event->star->first_name }} {{ $event->star->last_name }}</h3>
                                </div>
                            </div>
                            <div class="row py-3">
                                <div class="col-xs-6 content-center">
                                    <img src="{{ asset($event->admin->image) }}" style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray"/>
                                </div>
                                <div class="col-xs-6">
                                    Admin
                                    <h3>{{ $event->admin->first_name }} {{ $event->admin->last_name }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


            <div class="container row">
                @if($event->status != 2)
                    <a type="button" class="btn btn-outline-success mr-2" href="{{ route('managerAdmin.liveChat.set_publish', [$event->id]) }}">Publish Now</a>
                @else
                    <a type="button" class="btn btn-outline-danger mr-2" href="{{ route('managerAdmin.liveChat.set_publish', [$event->id]) }}">Remove From Publish</a>
                @endif
                    <a type="button" class="btn btn-outline-warning px-5" onclick="Show('Edit Live Chat Event','{{ route('managerAdmin.liveChat.edit', $event->id) }}')">Edit</a>
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
