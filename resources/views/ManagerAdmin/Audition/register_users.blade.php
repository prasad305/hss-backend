@extends('Layouts.ManagerAdmin.master')

@push('title')
 Audition Register User List
@endpush


@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"> User</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active"> User List</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="card-header">
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>SL.</th>             
                        <th>Audition Name</th>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Image</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $audition->title }}</td>
                            <td>{{ $user->participant->first_name . ' ' . $user->participant->last_name }}</td>
                            <td>{{ $user->participant->email }}</td>
                            <td>{{ $user->participant->phone }}</td>
                            <td>
                                <img src="{{ asset($user->participant->image) }}" alt="" height="50px" width="50px">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
    </div> <!-- container -->
</div> <!-- content -->

<style>
    .AdminImg {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;

    }

    .AdminName {
        color: black;
        font-size: 1rem;
    }

    .AdminMusic {
        color: #638BC9 !important:
    }

    .AtifAdmin {
        color: #FF602E;
    }
    

    @media only screen and (min-width: 1100px) and (max-width: 1400px) {

        .AdminName {
            white-space: nowrap;
            width: 8vw;
            overflow: hidden;
        }
    }
</style>

@endsection


