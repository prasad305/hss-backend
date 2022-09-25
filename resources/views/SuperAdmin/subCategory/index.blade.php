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
                    <h4 class="mx-3 text-white p-2">Sub Category</h4>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="content">

        <div class="container-fluid">


            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">DataTable with default features</h3>
                    <a class="btn btn-success btn-sm" style="float: right; margin-bottom: 10px;"
                        onclick="Show('New Sub Category','{{ route('superAdmin.subCategory.create') }}')"><i
                            class=" fa fa-plus"></i>&nbsp;New Sub Category</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Parent Category</th>
                                <th>Icon</th>
                                <th>Photo</th>
                                <th style="width: 150px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subCategories as $subCategory)
                                <tr>
                                    <td>{{ $subCategory->name }}</td>
                                    <td>{{ $subCategory->category->name ?? '' }}</td>
                                    <td>
                                        <img src="{{ asset($subCategory->icon) }}" alt="" height="50"
                                            width="50">
                                    </td>
                                    <td>
                                        <img src="{{ asset($subCategory->image) }}" alt="" height="50"
                                            width="50">
                                    </td>
                                    <td style="width: 150px">
                                        <a class="btn btn-sm btn-info"
                                            onclick="Show('Edit Sub Category','{{ route('superAdmin.subCategory.edit', $subCategory->id) }}')"><i
                                                class="fa fa-edit text-white"></i></a>
                                        <button class="btn btn-sm btn-danger" onclick="delete_function(this)"
                                            value="{{ route('superAdmin.subCategory.destroy', $subCategory) }}"><i
                                                class="fa fa-trash"></i> </button>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>



        </div> <!-- container -->
    </div> <!-- content -->
@endsection
