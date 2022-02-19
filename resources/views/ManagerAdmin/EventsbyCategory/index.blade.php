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
                        <h4 class="pull-left page-title">{{ $category->name }} All Events</h4>
                        <ol class="breadcrumb pull-right">
                            <li><a href="{{ route('managerAdmin.allEvent') }}">All Events Category</a></li>
                            <li class="active">Events</li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="row">

                @foreach ($events as $val)

                    <!--card-->
                    <div class="col-sm-6 col-lg-4">
                        <a href="{{ route('managerAdmin.detailsEvent', [$val->id, $categoryId]) }}">
                            <div class="panel panel-primary card_round card_shadow">
                                <div class="card-evnets">
                                    <div class=" card-image">
                                        <img width="100px" height="100px" src="{{ asset($val->banner) }}" alt=""
                                            class="img-circle">
                                    </div>
                                    <div class="card-border"></div>
                                    <div class="card-info">
                                        <h3>{{ $val->title }}</h3>
                                        <p class="text-primary">{{ $category->name }}</p>
                                        @if ($val->publish_status == null)

                                            <span class="label label-warning badge-pill">Pending</span><span
                                                class="badge badge-danger"><i class="ion-star"></i></span>
                                        @else
                                            <span class="label label-success badge-pill">Publish</span><span
                                                class="badge badge-danger"><i class="ion-star"></i></span>
                                        @endif


                                        <p class="text-warning card-name">Sarwar Jahan</p>
                                    </div>
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
