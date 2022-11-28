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
                    <h4 class="mx-3 text-white p-2">Withdraw History</h4>
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
                <div class="card-header">
                    <h3 class="card-title">Withdraw List</h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="category-filter mb-3">
                        <select id="categoryFilter" class="form-control">
                            <option value="">Show All</option>
                            <option value="Pending">Pending</option>
                            <option value="Processing">Processing</option>
                            <option value="Success">Success</option>
                            <option value="Failed">Failed</option>
                        </select>
                    </div>
                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>User Type</th>
                                <th>Amount</th>
                                <th>Withdraw Id</th>
                                <th>Bank Txn ID</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($withdrawHistory as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->users ? $data->users->first_name : '' }}</td>
                                    <td>{{ $data->users ? $data->users->user_type : '' }}</td>
                                    <td>{{ $data->withdraw_amount }}</td>
                                    <td>{{ $data->withdraw_id }}</td>
                                    <td>
                                        @if ($data->bank_txn_id !== null)
                                            {{ $data->bank_txn_id }}
                                        @else
                                            <form action="{{ route('superAdmin.bankTxnId.store', $data->id) }}"
                                                method="post">
                                                @csrf
                                                @method('put')
                                                <input type="text" name="bank_txn_id" value="{{ $data->bank_txn_id }}"
                                                    placeholder="Enter Bank Txn Id"> <button type="submit"
                                                    class="btn btn-sm btn-success">
                                                    <i class="fa fa-check" aria-hidden="true"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                    <td>
                                        @switch($data->status)
                                            @case(1)
                                                <span class="badge badge-warning">Processing</span>
                                            @break

                                            @case(2)
                                                <span class="badge badge-success">Success</span>
                                            @break

                                            @case(3)
                                                <span class="badge badge-danger">Failed</span>
                                            @break

                                            @default
                                                <span class="badge badge-primary">Pending</span>
                                        @endswitch

                                    </td>

                                    <td style="width: 150px">
                                        @if ($data->status == 0)
                                            <button class="btn btn-success" onclick="activeNow(this)"
                                                value="{{ route('superAdmin.admin.activeNow', $data->id) }}">
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                            </button>
                                        @elseif($data->status == 1)
                                            <button class="btn btn-danger" onclick="inactiveNow(this)"
                                                value="{{ route('superAdmin.admin.inactiveNow', $data->id) }}">
                                                <i class="fa fa-close"></i>
                                            </button>
                                        @endif
                                        <a class="btn btn btn-info"
                                            onclick="Show('Edit Admin','{{ route('superAdmin.admin.edit', $data->id) }}')"><i
                                                class="fa fa-edit text-white"></i></a>
                                        <button class="btn btn-danger" onclick="delete_function(this)"
                                            value="{{ route('superAdmin.admin.destroy', $data->id) }}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
    </div>

    <script>
        function activeNow(objButton) {
            var url = objButton.value;
            var txnId = $("#bank_txn_id").val(),
                alert(txnId)
            // alert(objButton.value)
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Active !'
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        method: 'POST',
                        url: url,
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        },
                        success: function(data) {
                            if (data.type == 'success') {
                                Swal.fire(
                                    'Activated !',
                                    'This account has been Activated. ' + data.message,
                                    'success'
                                )
                                setTimeout(function() {
                                    location.reload();
                                }, 800);
                            } else {
                                Swal.fire(
                                    'Wrong !',
                                    'Something going wrong. ' + data.message,
                                    'warning'
                                )
                            }
                        },
                    })
                }
            })
        }

        function inactiveNow(objButton) {
            var url = objButton.value;

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Inactive !'
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        method: 'POST',
                        url: url,
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        },
                        success: function(data) {
                            if (data.type == 'success') {
                                Swal.fire(
                                    'Inactivated !',
                                    'This account has been Inactivated. ' + data.message,
                                    'success'
                                )
                                setTimeout(function() {
                                    location.reload();
                                }, 800);
                            } else {
                                Swal.fire(
                                    'Wrong !',
                                    'Something going wrong. ' + data.message,
                                    'warning'
                                )
                            }
                        },
                    })
                }
            })
        }
    </script>

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
