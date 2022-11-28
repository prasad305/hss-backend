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
                            <th>Title</th>
                            <th>Category</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Star</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($portalData as $key => $data)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $data->title }}</td>
                                <td>{{ $data->category->name }}</td>
                                <td>{!! date('d-m-y', strtotime($data->created_at)) !!}</td>
                                <td>
                                    @if ($data->status == 10)
                                        <span class="badge badge-success">Completed</span>
                                    @elseif ($data->status == 2)
                                        <span class="badge badge-warning">Running</span>
                                    @else
                                        <span class="badge badge-primary">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="sparkbar" data-color="#00a65a" data-height="20">
                                        {{ $data->star ? $data->star->first_name : '' }}
                                        {{ $data->star ? $data->star->last_name : '' }}</div>
                                </td>
                                <td>
                                    <a href="{{ route('managerAdmin.dashboard.meetupEventDetails', $data->id) }} "
                                        class="btn btn-primary"><i class="fas fa-eye"></i> View </a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

        </div>

        <div class="card-footer clearfix">
            <a href="{{ route('managerAdmin.dashboard.meetupEvent') }}" class="btn btn-sm btn-info float-left">Go Back</a>
            <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All</a>
        </div>

    </div>
@endsection
