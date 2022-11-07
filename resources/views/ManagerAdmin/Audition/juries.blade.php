@extends('Layouts.ManagerAdmin.master')

@push('title')
    Admin
@endpush

@section('content')
    <div>

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Jury</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Jury list</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->



        <div class="content">
            <div class="container-fluid">


                <div class="row mb-3">
                    {{-- @foreach ($events as $val) --}}
                    <!--card-->

                    <div class="col-sm-12 col-md-4 col-lg-3">
                        <div class="card">
                            <div class="panel panel-primary p-2 text-center">


                                <img src="{{ asset('assets/manager-admin/events/person-2.png') }}"
                                    class="img-fluid card-img" />

                                <div class="panel-body pt-1">
                                    <h5 class="text-ellipsis-line-1">sdf</h5>


                                    {{-- @if ($val->status == 2) --}}
                                    <button type="button" class="btn btnPublish waves-effect waves-light px-4 mb-2"><i
                                            class="icon-checkmark-round"></i> Free</button>
                                    {{-- @else --}}
                                    <a href="#" type="button"
                                        class="btn btnPending waves-effect fw-bold waves-light mb-2">Assing <i
                                            class="fa fa-angle-double-right"></i></a>
                                    {{-- @endif --}}


                                </div>
                            </div>

                        </div>
                    </div>
                    <!--card end-->
                    {{-- @endforeach --}}
                </div>

            </div> <!-- container -->
        </div>


    </div>
@endsection
