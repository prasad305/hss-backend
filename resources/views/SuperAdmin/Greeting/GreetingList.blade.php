@extends('Layouts.SuperAdmin.master')

@push('title')
    Super Admin
@endpush



@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Greeting</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Greeting</li>
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
                    <h3 class="card-title">Greeting</h3>
                    <a class="btn btn-success btn-sm" style="float: right;"
                        href="{{ route('superAdmin.greeting.index') }}"><i class=" fa fa-arrow"></i>&nbsp;Go Back</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="category-filter mb-3">
                        <select id="categoryFilter" class="form-control">
                            <option value="">Show All</option>
                            <option value="Pending">Pending</option>
                            <option value="Published">Published</option>
                        </select>
                    </div>
                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Photo</th>
                                <th>Title</th>
                                <th>Admin</th>
                                <th>Super Star</th>
                                <th>Status</th>
                                <th style="width: 150px">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($postList as $key => $post)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <img src="{{ asset($post->banner) }}" style="width: 200px; height:100px" />
                                    </td>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ $post->admin->first_name }} {{ $post->admin->last_name }}</td>
                                    <td>{{ $post->star->first_name }} {{ $post->star->last_name }}</td>
                                    <td>
                                        @if ($post->status >= 2)
                                            <span class="badge badge-success">Published<span>
                                                @else
                                                    <span class="badge badge-warning">Pending<span>
                                        @endif
                                    </td>
                                    <td style="width: 150px">
                                        <a href="{{ route('superAdmin.greeting.details', [$post->id]) }}"
                                            class="btn btn-sm btn-success"> <i class="fa fa-eye"></i></a>
                                        <a class="btn btn-sm btn-info"
                                            onclick="Show('Edit Event','{{ route('superAdmin.greeting.edit', $post->id) }}')"><i
                                                class="fa fa-edit text-white"></i></a>
                                        <button class="btn btn-sm btn-danger" onclick="delete_function(this)"
                                            value="{{ route('superAdmin.greeting.destroy', $post->id) }}"><i
                                                class="fa fa-trash"></i> </button>
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


    {{-- Datatable --}}
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script>
        $("document").ready(function() {

            $("#myTable").dataTable({
                "searching": true,
                dom: 'Bfrtip',
                buttons: true,
                responsive: true,
                autoWidth: false

            });

            var table = $('#myTable').DataTable();

            $("#filterTable_filter.dataTables_filter").append($("#categoryFilter"));

            var categoryIndex = 0;
            $("#myTable th").each(function(i) {
                if ($($(this)).html() == "Status") {
                    categoryIndex = i;
                    return false;
                }
            });

            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var selectedItem = $('#categoryFilter').val()
                    var status = data[categoryIndex];
                    if (selectedItem === "" || status.includes(selectedItem)) {
                        return true;
                    }
                    return false;
                }
            );

            $("#categoryFilter").change(function(e) {
                table.draw();
            });

            table.draw();
        });
    </script>
@endsection
