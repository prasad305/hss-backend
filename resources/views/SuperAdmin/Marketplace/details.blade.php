@extends('Layouts.SuperAdmin.master')

@push('title')
    Super Admin
@endpush


@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Marketplace</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Marketplace Details</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <div class="content">
        <div class="container-fluid">

            {{-- <div class="row">
            <div class="col-md-6">
                @if ($post->image)
                    <img src="{{ asset($post->image) }}" style="width: 100%" />
                @elseif($post->video)
                    <iframe width="420" height="315" src="{{ $post->video }}"> </iframe>
                @else
                    <a href="{{ asset('demo_image/banner.jpg') }}" target="_blank">
                        <img src="{{ asset('demo_image/banner.jpg') }}" alt="Demo Image" style="width: 100%" />
                    </a>
                @endif

            </div>
        </div> --}}


            <div class="row pt-5">

                <div class="col-md-4">
                    @if($post->image)
                        <img src="{{ asset($post->image) }}" style="width: 100%; border: 2px solid gold;" />
                    @else
                        <a href="{{ asset('demo_image/banner.jpg') }}" target="_blank">
                            <img src="{{ asset('demo_image/banner.jpg') }}" alt="Demo Image" style="width: 100%; border: 2px solid gold;"/>
                        </a>
                    @endif

                </div>

                <div class="col-md-8 ">
                    <div class="row card p-5">
                        <h3>{{ $post->title }}</h3>
                        <p>
                            <b style="color: gold;">Description : </b>{!! $post->description !!}
                        </p>
                        <p>
                            <b style="color: gold;">Terms Conditions : </b>{!! $post->terms_conditions !!}
                        </p>
                    </div>
                    <div class="row">
                        <div class="col-md-6 card py-3">
                            Date
                            <h4 class="text-warning">{{ \Carbon\Carbon::parse($post->created_at)->format('d F,Y') }}</h4>
                        </div>
                        <div class="col-md-6 card py-3">
                            Time
                            <h4 class="text-warning">{{ \Carbon\Carbon::parse($post->created_at)->format('h:i A') }}</h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 card py-3">
                            Unit Price
                            <h4 class="text-warning">{{ $post->unit_price }}</h4>
                        </div>
                        <div class="col-md-3 card py-3">
                            Total Items
                            <h4 class="text-warning">{{ $post->total_items }}</< /h4>
                        </div>
                        <div class="col-md-3 card py-3">
                            Delivery Charge
                            <h4 class="text-warning">{{ $post->delivery_charge }}</h4>
                        </div>
                        <div class="col-md-3 card py-3">
                            Tax
                            <h4 class="text-warning">{{ $post->tax }}</< /h4>
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
                    title: '{{ Session::get('success ') }}',
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
