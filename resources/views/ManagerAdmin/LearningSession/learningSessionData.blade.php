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
                        <th>Title</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Star</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><a href="pages/examples/invoice.html"></a>This is Title</td>
                        <td>02-02-02</td>
                        <td><span class="badge badge-success">Pending</span></td>
                        <td>
                            <div class="sparkbar" data-color="#00a65a" data-height="20">Shakib All Hasan</div>
                        </td>
                        <td>
                            <a href="{{route('managerAdmin.dashboard.learninSessionDetails')}} " class="btn btn-primary"><i class="fas fa-eye"></i> View </a>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

    </div>

    <div class="card-footer clearfix">
        <a href="{{route('managerAdmin.dashboard.learningSession')}}" class="btn btn-sm btn-info float-left">Go Back</a>
        <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All</a>
    </div>

</div>
@endsection