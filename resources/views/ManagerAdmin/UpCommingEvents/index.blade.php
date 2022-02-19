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
                        <h4 class="pull-left page-title">Up Comming Events</h4>
                        <ol class="breadcrumb pull-right">
                            <li><a href="{{ route('managerAdmin.dashboard') }}">manager Admin Panel</a></li>
                            <li class="active">Events</li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($upcommingEvent as $val)
                    <!--card-->

                    <div class="col-sm-6 col-lg-4">
                        <div class="card_shadow">
                            <div class="panel panel-primary text-center">
                                <div class="">
                                    <a href="{{ route('managerAdmin.events', $val->Category->id) }}"
                                        class="category_round_batch">{{ $val->Category->name }}</a>
                                    <img width="100%" src="{{ asset($val->banner) }}" alt="">
                                </div>
                                <div class="panel-body">
                                    <h3 class=""><b>{{ $val->title }}</b></h3>

                                    @if ($val->publish_status == null)

                                        <a href="{{ route('managerAdmin.approvedEvent', [$val->id, 'null']) }}"
                                            type="button" class="btn btn-warning waves-effect waves-light"><i
                                                class="ion-record"></i>
                                            Pending</a>
                                    @else

                                        <button type="button" class="btn btn-success waves-effect waves-light"><i
                                                class="ion-checkmark-round"></i> Published</button>
                                    @endif

                                    <a href="{{ route('managerAdmin.detailsEvent', [$val->id, 'null']) }}" type="button"
                                        class="btn btn-info waves-effect waves-light">Details <i
                                            class="fa fa-angle-double-right"></i></a>

                                </div>
                            </div>
                            <div class="online-status">
                                @if ($val->publish_status == null)
                                    <i class="ion-record text-success"></i>
                                @endif
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
