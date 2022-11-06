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
                    <h1 class="m-0">QnA Events</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">QnA Events</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->



    <div class="content">
        <div class="container-fluid">


            <div class="row">
                @foreach ($upcommingEvent as $event)
                    <!--card-->
                    <div class="col-sm-12 col-md-4 col-lg-3">
                        <div class="card">
                            <div class="panel panel-primary p-2 text-center">
                                @if ($event->banner != null)
                                    <img src="{{ asset($event->banner) }}" class="img-fluid card-img" />
                                @else
                                    @if ($event->banner != null)
                                        <img width="100%" src="{{ asset($event->banner) }}" alt="">
                                    @else
                                        <video src={{ asset($event->video) }} class="img-fluid card-img" controls>

                                        </video>
                                    @endif
                                @endif
                                <div class="panel-body pt-1">
                                    <h5 class="text-ellipsis-line-1">{{ $event->title }}</h5>


                                    @if ($event->status == 2)
                                        <button type="button" class="btn btnPublish waves-effect waves-light mb-2"><i
                                                class="icon-checkmark-round"></i> Published</button>
                                    @else
                                        <a type="button" class="btn btnPending waves-effect waves-light mb-2"><i
                                                class="icon-record"></i>
                                            Pending</a>
                                    @endif

                                    <a href="{{ route('managerAdmin.qna.details', [$event->id]) }}" type="button"
                                        class="btn btnDetails waves-effect fw-bold waves-light mb-2">Details <i
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
