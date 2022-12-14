@extends('Layouts.ManagerAdmin.master')

@push('title')
    Manager Admin | Order View
@endpush


@section('content')
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
                                    @if ($order->marketplace->superstar->image)
                                        <img src="{{ asset($order->marketplace->superstar->image) }}"
                                            style="width: 80px; height: 75px; border-radius: 50%; border: 3px solid #6ff30a;"
                                            alt="No Image Found">
                                    @else
                                        <img src="{{ asset('/assets/manager-admin/avatar.jpg') }}"
                                            style="width: 50px; height: 50px; border-radius: 20%; " alt="Image not found">
                                    @endif
                                    <br>
                                    <strong>{{ $order->marketplace->superstar->first_name }}
                                        {{ $order->marketplace->superstar->last_name }}</strong><br>
                                    Phone: {{ $order->marketplace->superstar->phone }}<br>
                                    Email: {{ $order->marketplace->superstar->email }}
                                </address>
                            </div>
                            <div class="col-sm-4 invoice-col">
                                <b>To</b> <br>
                                <address>
                                    @if ($order->marketplace->superstar->image)
                                        <img src="{{ asset($order->marketplace->superstar->image) }}"
                                            style="width: 80px; height: 75px; border-radius: 50%; border: 3px solid #6ff30a;"
                                            alt="No Image Found">
                                    @else
                                        <img src="{{ asset('/assets/manager-admin/avatar.jpg') }}"
                                            style="width: 50px; height: 50px; border-radius: 20%; " alt="Image not found">
                                    @endif
                                    <br>
                                    <strong>{{ $order->user->first_name }} {{ $order->user->last_name }}</strong><br>
                                    {{ $order->area }}<br>
                                    {{ $order->city->name }}, {{ $order->state->name }}, {{ $order->country->name }}<br>
                                    Phone: {{ $order->phone }}<br>
                                    Email: {{ $order->user->email }}
                                </address>
                            </div>
                            <div class="col-sm-4 invoice-col">
                                <b>Invoice #{{ $order->invoice_no }}</b><br>
                                <br>
                                <b>Order ID:</b> #{{ $order->order_no }}<br>
                                @if ($order->status == 1)
                                    <b>Order Status:</b> <span class="badge badge-danger">Ordered </span><br>
                                @elseif($order->status == 2)
                                    <b>Order Status:</b> <span class="badge badge-info">Received</span><br>
                                @elseif($order->status == 3)
                                    <b>Order Status:</b> <span class="badge badge-info">Out for Delivery</span><br>
                                @else
                                    <b>Order Status:</b> <span class="badge badge-success"> Delivered </span><br>
                                @endif
                                <b>Total Price: </b> {{ $order->total_price }} $
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Qty</th>
                                            <th>Product</th>
                                            <th>Image</th>
                                            <th>Items</th>
                                            <th>Unit Price</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>{{ $order->marketplace->title }}</td>
                                            <td>
                                                @if ($order->marketplace->image)
                                                    <img src="{{ asset($order->marketplace->image) }}"
                                                        style="width: 50px; height: 50px; border-radius: 20%; border: 3px solid #6ff30a;"
                                                        alt="Image not found">
                                                @else
                                                    <img src="{{ asset('/assets/manager-admin/avatar.jpg') }}"
                                                        style="width: 50px; height: 50px; border-radius: 20%;"
                                                        alt="Image not found">
                                                @endif
                                            </td>
                                            <td>{{ $order->items }}</td>
                                            <td>{{ $order->unit_price }}</td>
                                            <td>{{ $order->items * $order->unit_price }}</td>
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
                                <p class="lead">Amount Due 2/22/2014</p>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th style="width:50%">Subtotal:</th>
                                            <td>{{ $order->items * $order->unit_price }} $</td>
                                        </tr>
                                        <tr>
                                            <th>Delivery Charge:</th>
                                            <td>{{ $order->delivery_charge }} $</td>
                                        </tr>
                                        <tr>
                                            <th>Total:</th>
                                            <td>{{ $order->items * $order->unit_price + $order->delivery_charge }} $</td>
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
@endsection
