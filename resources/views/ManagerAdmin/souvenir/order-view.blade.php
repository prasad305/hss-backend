<!-- @extends('Layouts.ManagerAdmin.master')

@push('title')
    Super Admin | Order View
@endpush



@section('content')
    -->

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Order List</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active">All Order List</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="callout callout-info">
                        <h5><i class="fas fa-info"></i> Invoice:</h5>
                    </div>
                    <div class="invoice p-3 mb-3">
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <i class="fas fa-check"></i> Order Details
                                    <small class="float-right">Date: {{ $order->created_at->format('M d Y') }}</small>
                                </h4>
                            </div>
                        </div>
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                <b>From</b> <br>
                                <address>
                                    @if ($order->star->image)
                                        <img src="{{ asset($order->star->image) }}"
                                            style="width: 80px; height: 75px; border-radius: 50%; border: 3px solid #6ff30a;"
                                            alt="">
                                    @else
                                        <a href="{{ asset('demo_image/banner.jpg') }}" target="_blank">
                                            <img src="{{ asset('demo_image/banner.jpg') }}" alt="Demo Image"
                                                style="width: 80px; height: 75px; border-radius: 50%; border: 3px solid #6ff30a;" />
                                        </a>
                                    @endif

                                    <br>
                                    <strong>{{ $order->star->first_name }} {{ $order->star->last_name }}</strong><br>
                                    Phone: {{ $order->star->phone }}<br>
                                    Email: {{ $order->star->email }}
                                </address>
                            </div>
                            <div class="col-sm-4 invoice-col">
                                <b>To</b> <br>
                                <address>
                                    @if ($order->user->image)
                                        <img src="{{ asset($order->user->image) }}"
                                            style="width: 80px; height: 75px; border-radius: 50%; border: 3px solid #6ff30a;"
                                            alt="">
                                    @else
                                        <a href="{{ asset('demo_image/demo_user.png') }}" target="_blank">
                                            <img src="{{ asset('demo_image/demo_user.png') }}" alt="Demo Image"
                                                style="width: 80px; height: 75px; border-radius: 50%; border: 3px solid #6ff30a;" />
                                        </a>
                                    @endif
                                    <br>
                                    <strong>{{ $order->user->first_name }} {{ $order->user->last_name }}</strong><br>
                                    {{ $order->area }}<br>
                                    {{ $order->city->name }}, {{ $order->state->name }}, {{ $order->country->name }}<br>
                                    Phone: {{ $order->mobile_no }}<br>
                                    Email: {{ $order->user->email }}
                                </address>
                            </div>
                            <div class="col-sm-4 invoice-col">
                                <b>Invoice #{{ $order->invoice_no }}</b><br>
                                <br>
                                <b>Order ID:</b> #{{ $order->order_no }}<br>
                                @if ($order->status == 0)
                                    Status : <span class="badge badge-danger" style="width: 140px;">Pending</span>
                                @elseif($order->status == 1)
                                    Status : <span class="badge badge-primary" style="width: 140px;">Approved for
                                        Payment</span>
                                @elseif($order->status == 2)
                                    Status : <span class="badge badge-success" style="width: 140px;">Payment Complete</span>
                                @elseif($order->status == 3)
                                    Status : <span class="badge badge-success" style="width: 140px;">Processing</span>
                                @elseif($order->status == 4)
                                    Status : <span class="badge badge-success" style="width: 140px;">Product Received</span>
                                @elseif($order->status == 5)
                                    Status : <span class="badge badge-success" style="width: 140px;">Processing</span>
                                @elseif($order->status == 6)
                                    Status : <span class="badge badge-success" style="width: 140px;">Out for Delivery</span>
                                @else
                                    Status : <span class="badge badge-success" style="width: 140px;">Delivered</span>
                                @endif
                                <br>
                                <b>Total Price: </b> {{ $order->total_price }} $
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Sl</th>
                                            <th>Product</th>
                                            <th>Image</th>
                                            <th>Price</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>{{ $order->souvenir->title }}</td>
                                            <td>

                                                @if ($order->image)
                                                    <img src="{{ asset($order->image) }}"
                                                        style="width: 50px; height: 50px; border-radius: 20%; border: 3px solid #6ff30a;"
                                                        alt="">
                                                @else
                                                    <a href="{{ asset('demo_image/demo_user.png') }}" target="_blank">
                                                        <img src="{{ asset('demo_image/demo_user.png') }}" alt="Demo Image"
                                                            style="width: 50px; height: 50px; border-radius: 20%; border: 3px solid #6ff30a;" />
                                                    </a>
                                                @endif
                                            </td>
                                            <td>{{ $order->souvenir->price }}</td>
                                            <td>{{ $order->souvenir->price }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <p class="lead"></p>

                                </p>
                            </div>
                            <div class="col-6">
                                <!-- <p class="lead">Amount Due 2/22/2014</p> -->
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th style="width:50%">Subtotal:</th>
                                            <td>{{ $order->souvenir->price }} $</td>
                                        </tr>
                                        <tr>
                                            <th>Delivery Charge:</th>
                                            <td>{{ $order->souvenir->delivery_charge }} $</td>
                                        </tr>
                                        <tr>
                                            <th>Tax:</th>
                                            <td>{{ $order->souvenir->tax }} $</td>
                                        </tr>
                                        <tr>
                                            <th>Total:</th>
                                            <td>{{ $order->total_amount }} $</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row no-print">
                            <div class="col-12">
                                <a href="" onclick="window.print()" rel="noopener" target="_blank"
                                    class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                                {{-- <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                      Payment
                      </button>
                      <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                      <i class="fas fa-download"></i> Generate PDF
                      </button> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--
@endsection -->
