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
                    <h1 class="m-0">Live Chat</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Live Chat Event</li>
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

                    <div class="col-sm-6 col-lg-4 col-xl-3">
                        <div class="card">
                            <div class="panel panel-primary text-center">
                                <div class="">
                                    <img width="100%" src="{{ asset($event->banner) }}" alt="">
                                </div>
                                <div class="panel-body py-3">
                                    <h3 class="text-ellipsis-line-1">{{ $event->title }}</h3>

                                    @if ($event->status == 2)
                                        <button type="button" class="btn btn-success waves-effect waves-light"><i
                                                class="icon-checkmark-round"></i> Published</button>
                                    @elseif($event->status < 2)
                                        <a type="button" class="btn btn-warning waves-effect waves-light"><i
                                                class="icon-record"></i>
                                            Pending</a>
                                    @endif

                                    <a href="{{ route('managerAdmin.liveChat.details', [$event->id]) }}" type="button"
                                        class="btn btn-info waves-effect waves-light">Details <i
                                            class="fa fa-angle-double-right"></i></a>

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

@push('script')
    {{-- <script src="{{ asset('assets/manager-admin/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script> --}}
    <script src="{{ asset('assets/manager-admin/pages/dashborad.js') }}"></script>
@endpush
