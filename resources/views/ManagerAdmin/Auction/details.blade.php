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
                    <h1 class="m-0">Auction</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Product Details</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->






    <div class="content">
        <div class="container-fluid">

            <div class="row">

                <div class="col-md-8 mb-2">
                    <div class="card p-2">
                        <div class="center">
                            @if ($product->banner)
                                <img src="{{ asset($product->banner) }}" class="card-img-details" />
                            @else
                                <a href="{{ asset('demo_image/banner.jpg') }}" target="_blank">
                                    <img src="{{ asset('demo_image/banner.jpg') }}" alt="Demo Image"
                                        class="img-fluid card-img" />
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-2">
                    <div class="card p-2">
                        <div class="center">
                            @if ($product->product_image)
                                <img src="{{ asset($product->product_image) }}" class="card-img-details" />
                            @else
                                <a href="{{ asset('demo_image/banner.jpg') }}" target="_blank">
                                    <img src="{{ asset('demo_image/banner.jpg') }}" alt="Demo Image"
                                        class="img-fluid card-img" />
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mb-2">
                    <div class=" card px-3 py-3">
                        <div>
                            <h4>{{ $product->title }}</h4>
                            <div class="title-text text-warning">Description</div>

                            <div class="description-text">{!! $product->details !!}</div>
                        </div>
                    </div>
                </div>

                <div class="row col-md-8 mb-2">
                    <div class="col-sm-12 col-md-6 col-lg-4 mb-2">
                        <div class="card p-3">
                            <h5>Date</h5>
                            <h6 class="text-warning">{{ \Carbon\Carbon::parse($product->bid_from)->format('d F,Y') }} -
                                {{ \Carbon\Carbon::parse($product->bid_to)->format('d F,Y') }}
                            </h6>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-4 mb-2">
                        <div class="card p-3">
                            <h5>Time</h5>
                            <h6 class="text-warning">
                                {{ \Carbon\Carbon::parse($product->bid_from)->format('h:i A') }} -
                                End {{ \Carbon\Carbon::parse($product->bid_to)->format('h:i A') }}
                            </h6>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-4 mb-2">
                        <div class="card p-3">
                            <h5>Base Price</h5>
                            <h6 class="text-warning">$ {{ $product->base_price }}
                            </h6>
                        </div>
                    </div>

                </div>

                <div class="col-md-4 mb-2">
                    <div class="col-md-12 d-flex mb-2 p-2 bg-dark align-items-center card-rounded">
                        <div class="">
                            @if ($product->star->image)
                                <img src="{{ asset($product->star->image) }}" class="img-star-x" alt="Demo Image" />
                            @else
                                <a href="{{ asset('demo_image/demo_user.png') }}" target="_blank">
                                    <img src="{{ asset('demo_image/demo_user.png') }}" class="img-star-x"
                                        alt="Demo Image" />
                                </a>
                            @endif
                        </div>
                        <div class="mx-2">
                            <label for="">Star</label>
                            <h5>{{ $product->star->first_name }} {{ $product->star->last_name }}</h5>

                        </div>
                    </div>
                    <div class="col-md-12 d-flex mb-2 p-2 bg-dark align-items-center card-rounded">
                        <div class="">
                            @if ($product->admin->image)
                                <img src="{{ asset($product->admin->image) }}" class="img-star-x" alt="Demo Image" />
                            @else
                                <a href="{{ asset('demo_image/demo_user.png') }}" target="_blank">
                                    <img src="{{ asset('demo_image/demo_user.png') }}" class="img-star-x"
                                        alt="Demo Image" />
                                </a>
                            @endif
                        </div>
                        <div class="mx-2">
                            <label for="">Admin</label>
                            <h5>{{ $product->admin->first_name }} {{ $product->admin->last_name }}</h5>

                        </div>
                    </div>

                </div>

                <div class="card col-md-12">
                    <div class="card-header"
                        style="color: gold; letter-spacing: .01rem; font-size: 18px; border-bottom: 1px solid #000;">
                        Publish Post in News Feed
                    </div>

                    <div class="card-body">

                        @if ($product->status == 0)
                            <a type="button" class="btn btnPublish mr-2"
                                href="{{ route('managerAdmin.auctionProduct.set_publish', [$product->id]) }}">Publish
                                Now</a>
                        @elseif($product->status == 1)
                            <a type="button" class="btn btnRemove mr-2"
                                href="{{ route('managerAdmin.auctionProduct.set_publish', [$product->id]) }}">Remove From
                                Publish</a>
                        @endif
                        @if ($product->status == 0)
                            <a type="button" class="btn btnEdit px-5"
                                onclick="Show('Edit product','{{ route('managerAdmin.auctionProduct.edit', $product->id) }}')">Edit</a>
                        @endif

                    </div>
                </div>



                <div class="col-12 mt-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Bidder List - {{ $totalBidders }}</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control float-right"
                                        placeholder="Search">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>#SL</th>
                                        <th>Name</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bidders as $key => $bidder)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $bidder->user->first_name }} {{ $bidder->user->last_name }}</td>
                                            <td>{{ $bidder->amount }}</td>
                                            <td>{{ \Carbon\Carbon::parse($bidder->created_at)->format('d F,Y') }}</td>
                                            <td>
                                                @if ($bidder->applied_status === 1)
                                                    <span class="tag tag-success">Applied</span>
                                                @else
                                                    <span class="tag tag-success">Not Applied</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
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
                    title: '{{ Session::get('
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    success ') }}',
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
