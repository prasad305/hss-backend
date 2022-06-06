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
                <h1 class="m-0">Auction Product</h1>
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
            <div class="col-md-6">
                @if($product->product_image)
                <img src="{{ asset($product->product_image) }}" style="width: 40%" />
                @endif

            </div>
        </div>


        <div class="row pt-5">

            <div class="col-md-8 ">
                <div class="row card p-5">
                    <h3>{{ $product->title }}</h3>
                    <p>
                        {!! $product->details !!}
                    </p>
                </div>
                <div class="row">
                    <div class="col-md-3 card py-3 mr-1">
                        Date
                        <h4 class="text-warning">{{ \Carbon\Carbon::parse($product->created_at)->format('d F,Y')}}</h4>
                    </div>
                    <div class="col-md-3 card py-3 mr-1">
                        Time
                        <h4 class="text-warning">BID {{ \Carbon\Carbon::parse($product->bid_from)->format('h:i A')}} - End {{ \Carbon\Carbon::parse($product->bid_to)->format('h:i A')}}</h4>
                    </div>
                    <div class="col-md-3 card py-3">
                        Base Price
                        <h4 class="text-warning">$ {{$product->base_price}}</h4>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card px-5 py-3">
                    <div class="row">
                        <div class="col-xs-6 content-center">
                            <img src="{{ asset($product->star->image) }}" style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray" />
                        </div>
                        <div class="col-xs-6">
                            Star
                            <h3>{{ $product->star->first_name }} {{ $product->star->last_name }}</h3>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-xs-6 content-center">
                            <img src="{{ asset($product->admin->image) }}" style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray" />
                        </div>
                        <div class="col-xs-6">
                            Admin
                            <h3>{{ $product->admin->first_name }} {{ $product->admin->last_name }}</h3>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div class="container row">
            @if($product->status == 0 )
            <a type="button" class="btn btn-outline-success mr-2" href="{{ route('managerAdmin.auctionProduct.set_publish', [$product->id]) }}">Publish Now</a>
            @elseif($product->status == 1)
            <a type="button" class="btn btn-outline-danger mr-2" href="{{ route('managerAdmin.auctionProduct.set_publish', [$product->id]) }}">Remove From Publish</a>
            @endif
            <a type="button" class="btn btn-outline-warning px-5" onclick="Show('Edit Post','{{ route('managerAdmin.auctionProduct.edit', $product->id) }}')">Edit</a>
        </div>


        <div class="row mt-5" >
            <div class="col-12">
            <div class="card">
            <div class="card-header">
            <h3 class="card-title">Bidder List - {{$totalBidders}}</h3>
            <div class="card-tools">
            <div class="input-group input-group-sm" style="width: 150px;">
            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
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
                @foreach ($bidders as $key=>$bidder )
                   <tr>
            <td>{{$key+1}}</td>
            <td>{{$bidder->user->first_name}} {{$bidder->user->last_name}}</td>
            <td>{{$bidder->amount}}</td>
            <td>{{ \Carbon\Carbon::parse($bidder->created_at)->format('d F,Y')}}</td>
            <td>@if ($bidder->applied_status === 1)
                <span class="tag tag-success">Applied</span>
                @else
                <span class="tag tag-success">Not Applied</span>

            @endif</td>
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
