@extends('Layouts.ManagerAdmin.master')


@section('content')
    <div class="card">
        <div class="card-header border-transparent">
            <h3 class="card-title">All Data</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table m-0">
                    <thead>
                        <tr>
                            <th>#SL</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Audition Title</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($juryList as $key => $jury)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $jury->user->first_name }} {{ $jury->user->last_name }}</td>
                                <td><span class="badge badge-success">{{ $jury->user->category->name }}</span></td>
                                <td>
                                    <div class="sparkbar" data-color="#00a65a" data-height="20">
                                        {{ $jury->auditions->title }}</div>
                                </td>
                                <td>
                                    <a href="{{ route('managerAdmin.dashboard.auditionDetails') }} "
                                        class="btn btn-primary"><i class="fas fa-eye"></i> View </a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

        </div>

        <div class="card-footer clearfix">
            <a href="{{ route('managerAdmin.dashboard.audition') }}" class="btn btn-sm btn-info float-left">Go Back</a>
            <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All</a>
        </div>

    </div>
@endsection
