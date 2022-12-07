@extends('Layouts.SuperAdmin.master')

@push('title')
    Super Admin
@endpush

@section('content')
    <!-- Content Header (Page header) -->

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

    <div class="content-header">
        <div class="container-fluid">
            <div class="card card-bg head-line mt-4 mb-2">
                <div class="text-light d-flex p-2">
                    <h4 class="mx-3 text-white p-2">Currency List</h4>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div>


    <!-- /.content-header -->

    <style>
        td,
        th {
            text-align: center;
        }
    </style>

    <div class="content">

        <div class="container-fluid">


            <div class="card">

                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Date</th>
                                <th>Country</th>
                                <th>Size</th>
                                <th>Question</th>
                                <th>Answer</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($quizs as $item)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $item->userEmail }}</td>
                                    <td>{{ $item->userPhone }}</td>
                                    <td>{{ $item->created_at->diffForHumans() }}</td>
                                    <td>{{ $item->country }}</td>
                                    <td>{{ $item->size }}</td>
                                    <td>{{ $item->question }}</td>
                                    <td>{{ $item->answer }}</td>


                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>SL</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Date</th>
                                <th>Country</th>
                                <th>Size</th>
                                <th>Question</th>
                                <th>Answer</th>

                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>


        </div>
    </div>

    <script></script>
@endsection
