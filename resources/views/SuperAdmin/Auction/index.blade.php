@extends('Layouts.SuperAdmin.master')

@push('title')
    Manager Admin
@endpush




@section('content')
    <style>
        .head-line {
            border-top: 1px solid #ffad00 !important;
            border-left: 8px solid #ffad00 !important;
            border-bottom: 1px solid #ffad00 !important;
            border-right: 8px solid #ffad00 !important;
        }

        .card-bg {
            background-color: black;
        }
    </style>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="card card-bg head-line mt-4 mb-2">
                <div class="text-light d-flex p-2">
                    <h4 class="mx-3 text-white p-2">Auction</h4>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->



    <div class="content">
        <div class="container-fluid">


            <div class="row">
                @foreach ($product as $val)
                    <!--card-->

                    <div class="col-sm-6 col-lg-4">
                        <div class="card">
                            <div class="panel panel-primary text-center">
                                <div class="">
                                    <img width="50%" src="{{ asset($val->product_image) }}" alt="">
                                </div>
                                <div class="panel-body py-3">
                                    <h3 class="text-ellipsis-line-1">{{ $val->name }}</h3>

                                    @if ($val->status == 0)
                                        <a type="button" class="btn btn-warning waves-effect waves-light mb-2"><i
                                                class="icon-record"></i>
                                            Pending</a>
                                    @else
                                        <button type="button" class="btn btn-success waves-effect waves-light mb-2"><i
                                                class="icon-checkmark-round"></i> Published</button>
                                    @endif

                                    <a href="{{ route('managerAdmin.auctionProduct.details', [$val->id]) }}" type="button"
                                        class="btn btn-info waves-effect waves-light mb-2">Details <i
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
