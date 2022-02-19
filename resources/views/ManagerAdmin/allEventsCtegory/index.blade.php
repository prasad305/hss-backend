@extends('ManagerAdmin.layouts.master')

@push('title')
    Manager Admin
@endpush

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/manager-admin/css/totalEvents.css') }}">
@endpush

@section('content')
    <div class="content">
        <div class="container">
            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-header-title">
                        <h4 class="pull-left page-title">All Category</h4>
                        <ol class="breadcrumb pull-right">
                            <li><a href="{{ route('managerAdmin.dashboard') }}">manager Admin Panel</a></li>
                            <li class="active">Events</li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="row">

                @foreach ($allCategory as $val)
                    @php
                        $coutn = 0;
                        foreach ($val->liveEvents as $event) {
                            if ($event->publish_status == null) {
                                $coutn++;
                            }
                        }
                    @endphp

                    <!--card-->
                    <div class="col-sm-6 col-lg-4">
                        <a href="{{ route('managerAdmin.events', $val->id) }}">

                            <div class="card_shadow">

                                @if (count($val->liveEvents) > 0)
                                    <span class="category_round_batch_category">Unpublished
                                        <b style="color:red">{{ $coutn }}</b></span>
                                @endif

                                <div class="panel panel-primary text-center">
                                    <div class="card-image-cat">
                                        <img width="200px" height="200px" class="img-circle"
                                            src="{{ asset($val->image) }}" alt="">
                                    </div>
                                    <div class="panel-body">
                                        <h3 class=""><b>{{ $val->name }}</b></h3>
                                        <a href="{{ route('managerAdmin.events', $val->id) }}" type="button"
                                            class="btn_round">Details <i class="fa fa-angle-double-right"></i></a>
                                    </div>
                                </div>

                                <div class="online-status">

                                    @if ($coutn > 0)
                                        <i class="ion-record text-success"></i>
                                    @endif

                                </div>


                            </div>
                        </a>
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
