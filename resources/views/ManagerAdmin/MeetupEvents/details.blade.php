@extends('Layouts.ManagerAdmin.master')

@push('title')
    Manager Admin
@endpush


@section('content')
<style>
    .banner-image{
        height: 300px;
        object-fit:cover;
    }
</style>



<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Meetup Events</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Meetup Event Details</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->


    <div class="content">
        <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">
                        <img src="{{ asset($meetup->banner) }}" style="width: 100%" class="banner-image"/>
                    </div>

                </div>


                <div class="row py-5">

                    <div class="col-md-8 ">
                        <div class="row card p-5">
                            <h3>{{ $meetup->title }}</h3>
                            <p>
                                {!! $meetup->description !!}
                            </p>
                        </div>
                        <div class="row">
                            <div class="col-md-6 card py-3">
                                Date
                                <h4 class="text-primary">{{ \Carbon\Carbon::parse($meetup->date)->format('d F,Y')}}</h4>
                            </div>
                            <div class="col-md-6 card py-3">
                                Time
                                <h4 class="text-primary">{{ \Carbon\Carbon::parse($meetup->start_time)->format('h:i A')}} - {{ \Carbon\Carbon::parse($meetup->end_time)->format('h:i A')}}</h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card px-5">
                            <div class="row py-3">
                                <div class="col-xs-6 content-center">
                                    <img src="{{ asset($meetup->star->image) }}" style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray"/>
                                </div>
                                <div class="col-xs-6">
                                    Star
                                    <h3>{{ $meetup->star->first_name }} {{ $meetup->star->last_name }}</h3>
                                </div>
                            </div>
                            <div class="row py-3">
                                <div class="col-xs-6 content-center">
                                    <img src="{{ asset($meetup->admin->image) }}" style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray"/>
                                </div>
                                <div class="col-xs-6">
                                    Admin
                                    <h3>{{ $meetup->admin->first_name }} {{ $meetup->admin->last_name }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container row">
                        @if($meetup->status != 1)
                            <a type="button" class="btn btn-outline-success mr-2" href="{{ route('managerAdmin.meetupEvent.set_publish', [$meetup->id]) }}">Publish Now</a>
                        @elseif($meetup->status != 0)
                            <a type="button" class="btn btn-outline-danger mr-2" href="{{ route('managerAdmin.meetupEvent.set_publish', [$meetup->id]) }}">Remove From Publish</a>
                        @endif
                            <a type="button" class="btn btn-outline-warning px-5" onclick="Show('Edit Meetup Event','{{ route('managerAdmin.meetupEvent.edit', $meetup->id) }}')">Edit</a>
                    </div>

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
