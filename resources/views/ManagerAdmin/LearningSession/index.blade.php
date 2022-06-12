@extends('Layouts.ManagerAdmin.master')

@push('title')
    Manager Admin
@endpush

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/manager-admin/css/totalEvents.css') }}">
@endpush

@section('content')

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
            <li class="breadcrumb-item active">Learning Session</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->


    <div class="content">
        <div class="container-fluid">

            <div class="row">
                @foreach ($learningSessions as $event)
                    <!--card-->

                    <div class="col-sm-6 col-lg-4">
                        <div class="card">
                            <div class="panel panel-primary text-center">
                                <div class="">
                                    @if ($event->banner != null)
                                        <img width="100%" src="{{ asset($event->banner) }}" alt=""> 
                                        @else
                                        <video width="312" height="200px" controls>
                                            <source src="{{asset($event->video)}}" />
                                        </video> 
                                    @endif
                                   
                                </div>
                            
                                <div class="panel-body py-3">
                                    <h3 class="text-ellipsis-line-1">{{ $event->title }}</h3>
                                   @if ($event->status == 11)
                                   <a type="button" class="btn btn-danger waves-effect waves-light"><i
                                    class="ion-record"></i>
                                    Rejected</a>
                                       @else
                                       @if ($event->status < 2)
                                       <a type="button" class="btn btn-warning waves-effect waves-light"><i
                                           class="ion-record"></i>
                                           Pending</a>
                                   @else
                                       <button type="button" class="btn btn-success waves-effect waves-light"><i
                                           class="ion-checkmark-round"></i> Published</button>
                                   @endif

                                   <a href="{{ route('managerAdmin.learningSession.details', [$event->id]) }}" type="button"
                                       class="btn btn-info waves-effect waves-light">Details <i
                                           class="fa fa-angle-double-right"></i></a>
                                   @endif
                                </div>
                            </div>

                        </div>
                    </div>
                    <!--card end-->
                @endforeach
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






