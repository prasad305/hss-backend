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
                    <h1 class="m-0">Event List</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Event List</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->



    <div class="content">

        <div class="container-fluid">


            @if ($module == 4 || $module == 2 || $module == 3 || $module == 8)
                <div class="card">
                    <div class="card-header">

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Id</th>
                                    <th>Amount</th>
                                    {{-- <th style="width: 150px">Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($learning_seassion_reg as $data)
                                    <tr>
                                        <td>{{ $data->user->first_name }}</td>
                                        <td>{{ $data->user->email }}</td>
                                        <td>{{ $data->user_id }}</td>

                                        <td>{{ $data->amount }}</td>

                                    </tr>
                                @endforeach



                            </tbody>
                        </table>

                    </div>
                    <!-- /.card-body -->
                </div>
            @endif
            @if ($module == 9)
                <div class="card">
                    <div class="card-header">

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Id</th>
                                    <th>Amount</th>
                                    {{-- <th style="width: 150px">Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($learning_seassion_reg as $data)
                                    <tr>
                                        <td>{{ $data->user->first_name }}</td>
                                        <td>{{ $data->user->email }}</td>
                                        <td>{{ $data->user_id }}</td>

                                        <td>{{ $data->unit_price }}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
            @endif

            @if ($module == 10)
                <div class="card">
                    <div class="card-header">

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Id</th>
                                    <th>Amount</th>
                                    {{-- <th style="width: 150px">Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($learning_seassion_reg as $data)
                                    <tr>
                                        <td>{{ $data->user->first_name }}</td>
                                        <td>{{ $data->user->email }}</td>
                                        <td>{{ $data->user_id }}</td>

                                        <td>{{ $data->total_amount }}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
            @endif

            @if ($module == 7)
                <div class="card">
                    <div class="card-header">

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Id</th>
                                    <th>PerMin</th>
                                    <th>Amount</th>
                                    {{-- <th style="width: 150px">Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($learning_seassion_reg as $data)
                                    <tr>
                                        <td>{{ $data->user->first_name }}</td>
                                        <td>{{ $data->user->email }}</td>
                                        <td>{{ $data->user_id }}</td>
                                        <?php
                                        $start_time = strtotime($data->qna_start_time);
                                        $end_time = strtotime($data->qna_end_time);
                                        $diff = $end_time - $start_time;
                                        ?>
                                        <td>{{ $diff / 60 }}</td>
                                        <td>{{ $data->amount }}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
            @endif

            @if ($module == 5)
                <div class="card">
                    <div class="card-header">

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Id</th>
                                    <th>PerMin</th>
                                    <th>Amount</th>
                                    {{-- <th style="width: 150px">Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($learning_seassion_reg as $data)
                                    <tr>
                                        <td>{{ $data->user->first_name }}</td>
                                        <td>{{ $data->user->email }}</td>
                                        <td>{{ $data->user_id }}</td>
                                        <?php
                                        $start_time = strtotime($data->meetupEvent->start_time);
                                        $end_time = strtotime($data->meetupEvent->end_time);
                                        $diff = $end_time - $start_time;
                                        ?>
                                        <td>{{ $diff / 60 }}</td>
                                        <td>{{ $data->amount }}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
            @endif
            <!-- /.card-body -->
        </div>


    </div> <!-- container -->
    </div> <!-- content -->



@endsection
