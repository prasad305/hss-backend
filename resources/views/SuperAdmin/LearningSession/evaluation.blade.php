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
                @foreach ($events as $event)
                    <!--card-->

                    <div class="col-sm-6 col-lg-4">
                        <div class="card">
                            <div class="panel panel-primary text-center">
                                <div class="">
                                    @if ($event->video != null)
                                        <video width="
                                    " height="200" controls>
                                            <source src="{{ asset($event->video) }}" />
                                        </video>
                                    @else
                                        <img width="100%" src="{{ asset($event->banner) }}" alt="">
                                    @endif

                                </div>

                                <div class="panel-body pt-1">
                                    <h3 class="text-ellipsis-line-1">{{ $event->title }}</h3>
                                    <a href="{{ route('managerAdmin.learningSession.evaluationDetails', [$event->id]) }}"
                                        type="button" class="btn btn-info waves-effect waves-light mb-2">Details <i
                                            class="fa fa-angle-double-right"></i></a>
                                    <a href="{{ route('managerAdmin.learningSession.evaluationResult', [$event->id]) }}"
                                        type="button" class="btn btn-info waves-effect waves-light mb-2">Show Result <i
                                            class="fa fa-eye"></i></a>

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
