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
          <h1 class="m-0">Learning Session</h1>
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
                        <img src="{{ asset($event->banner) }}" style="width: 100%" class="banner-image"/>
                    </div>

                </div>


                <div class="row py-5">

                    <div class="col-md-8 ">
                        <div class="row card p-5">
                            <h3>{{ $event->title }}</h3>
                            <h5><u>Assignment Instruction</u></h5>
                            <p>
                                {!! $event->assignment_instruction !!}
                            </p>
                        </div>
                        <div class="row">
                            <div class="col-md-6 card py-3">
                                Submission Start Date
                                <h4 class="text-primary">{{ \Carbon\Carbon::parse($event->assignment_reg_start_date)->format('d F,Y')}}</h4>
                            </div>
                            <div class="col-md-6 card py-3">
                                Submission End Date
                                <h4 class="text-primary">{{ \Carbon\Carbon::parse($event->assignment_reg_end_date)->format('d F,Y')}}</h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card px-5">
                            <div class="row py-3">
                                <div class="col-xs-6 content-center">
                                    <img src="{{ asset($event->star->image) }}" style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray"/>
                                </div>
                                <div class="col-xs-6">
                                    Star
                                    <h3>{{ $event->star->first_name }} {{ $event->star->last_name }}</h3>
                                </div>
                            </div>
                            @if($event->admin)
                            <div class="row py-3">
                                <div class="col-xs-6 content-center">
                                    <img src="{{ asset($event->admin->image) }}" style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray"/>
                                </div>

                                <div class="col-xs-6">
                                    Admin
                                    <h3>{{ $event->admin->first_name }} {{ $event->admin->last_name }}</h3>
                                </div>

                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="container row">
                        @if($event->status != 1)
                            <a type="button" class="btn btn-outline-success mr-2" href="{{ route('managerAdmin.learningSession.set_publish', [$event->id]) }}">Publish Now</a>
                        @elseif($event->status != 0)
                            <a type="button" class="btn btn-outline-danger mr-2" href="{{ route('managerAdmin.learningSession.set_publish', [$event->id]) }}">Remove From Publish</a>
                        @endif
                            <a type="button" class="btn btn-outline-warning px-5" onclick="Show('Edit Learning Session','{{ route('managerAdmin.learningSession.edit', $event->id) }}')">Edit</a>
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
