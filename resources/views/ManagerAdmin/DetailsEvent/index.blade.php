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
                        <h4 class="pull-left page-title">Cricket Events</h4>
                        <ol class="breadcrumb pull-right">
                            <li><a href="{{ route('managerAdmin.dashboard') }}">manager Admin Panel</a></li>
                            <li class="active">Events</li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-lg-8">
                    <div class="panel panel-color panel-success">
                        <div class="panel-heading">
                            <h3 class="panel-title">Event Details</h3>
                            {{-- <div class="col-sm-12">
                                <a class="btn btn-warning btn-sm" href=""
                                    style="float: right; margin-bottom: 10px; margin-top:-29px;"><i
                                        class="ion-chevron-left"></i>&nbsp; Back</a>
                            </div> --}}
                        </div>
                        @if($eventsDetails->banner)
                            <img src="{{ asset($eventsDetails->banner) }}" height="200px" width="100%" alt="sdad">
                        @else
                            <a href="{{ asset('demo_image/banner.jpg') }}" target="_blank">
                                <img  src="{{ asset('demo_image/banner.jpg') }}" alt="Demo Image" height="200px" width="100%"/>
                            </a>
                        @endif
                        <div class="panel-body">
                            <h2>{{ $eventsDetails->title }}</h2>

                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                                labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                                laboris nisi ut aliquip ex ea commodo
                                consequat.
                            </p>
                            <ul>
                                <li style="padding-top:10px ;">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                    exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                    consequat.
                                </li>
                                <li style="padding-top:10px ;">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                    exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                    consequat.
                                </li>
                                <li style="padding-top:10px ;">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                    exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                    consequat.
                                </li>
                                <li style="padding-top:10px ;">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                    exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                    consequat.
                                </li>
                            </ul>
                        </div>
                        <div style="padding: 10px;">

                            @if ($eventsDetails->publish_status == null)

                                <a href="{{ route('managerAdmin.approvedEvent', [$eventsDetails->id, $categoryId]) }}"
                                    type="button" class="btn btn-warning waves-effect waves-light"><i
                                        class="ion-record"></i>
                                    Pending</a>
                            @else

                                <button type="button" class="btn btn-success waves-effect waves-light"><i
                                        class="ion-checkmark-round"></i> Published</button>
                            @endif
                        </div>
                    </div>
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
