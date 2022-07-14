@extends('Layouts.ManagerAdmin.master')


@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="invoice p-3 mb-3">

                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <i class="fas fa-globe"></i> {{ $data->title }}
                                    <small class="float-right">{{ date('d-M-y', strtotime($data->created_at)) }}</small>
                                </h4>
                            </div>

                        </div>

                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                Category
                                <address>
                                    <strong>{{ $data->category->name }}</strong><br>
                                </address>
                            </div>

                            <div class="col-sm-4 invoice-col">
                                Star
                                <address>
                                    <strong>{{ $data->star ? $data->star->first_name : '' }}{{ $data->star ? $data->star->last_name : '' }}
                                    </strong><br>
                                </address>
                            </div>

                            <div class="col-sm-4 invoice-col">
                                <b>Total Participant</b><br>
                                <b>{{ $data->participant_number }}</b><br>
                            </div>

                        </div>




                        <div class="row">

                            <div class="col-8">
                                <p class="lead">Banner</p>

                                <img src=" {{ asset('http://localhost:8000/' . $data->banner) }}" alt="No-Image">
                                <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                    {!! $data->description !!}
                                </p>
                            </div>

                            <div class="col-4">
                                <p class="lead">Summary</p>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th style="width:50%">Total User:</th>
                                                <td>{{ $totalParticipant }}</td>
                                            </tr>
                                            <tr>
                                                <th>Total Fee:</th>
                                                <td>{{ $totalFee }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>


                        <div class="row no-print">
                            <div class="col-12">
                                <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i
                                        class="fas fa-print"></i> Print</a>
                                <a href="{{ route('managerAdmin.dashboard.simplePost') }}"
                                    class=" btn btn-success float-right"><i class="far fa-credit-card"></i> Go Back
                                </a>
                                <a href="{{ route('managerAdmin.dashboard.simplePost') }}"
                                    class="btn btn-primary float-right" style="margin-right: 5px;">
                                    <i class="fas fa-download"></i> Generate PDF
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
