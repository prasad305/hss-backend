@extends('Layouts.SuperAdmin.master')

@push('title')
    Super Admin
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
                    <h4 class="mx-3 text-white p-2">Raffle Drow 
                        ( Winner User Of
                            @if($country_code == 'BH')
                                Bahrain
                            @elseif($country_code == 'IN')
                                India
                            @elseif($country_code == 'KW')
                                Kuwait
                            @elseif($country_code == 'AE')
                                UAE
                            @elseif($country_code == 'MY')
                                Malaysia
                            @elseif($country_code == 'US')
                                United States of America
                            @elseif($country_code == 'BD')
                                Bangladesh
                            @endif
                        )
                    </h4>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->



    <div class="content">

        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Total Winner User( {{count($users)}} )</h3>
                    <form action="{{route('superAdmin.reseteuser')}}" method="post">
                        @csrf
                        <input type="hidden" value="{{$country_code}}" name="country_code">
                        <button type="submit" class="btn btn-info btn-sm" style="float:right">Resete User</button>
                    </form>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Country</th>
                                <th>Address</th>
                                <th>Register Date</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>
                                        @if($user->country_code == 'BH')
                                        Bahrain
                                        @elseif($user->country_code == 'IN')
                                        India
                                        @elseif($user->country_code == 'KW')
                                        Kuwait
                                        @elseif($user->country_code == 'AE')
                                        UAE
                                        @elseif($user->country_code == 'MY')
                                        Malaysia
                                        @elseif($user->country_code == 'US')
                                        United States of America
                                        @elseif($user->country_code == 'BD')
                                        Bangladesh
                                        @endif
                                    </td>
                                    <td>{{ $user->address }}</td>
                                    <td>{{ $user->created_at }}</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div> <!-- container -->
    </div> <!-- content -->
@endsection
