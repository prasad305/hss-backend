@extends('Layouts.ManagerAdmin.master')

@push('title')
Manager Admin
@endpush

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Report</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Report</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <form id="simplePostFilter">
            @csrf
            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <label for="category">Start Date</label>
                    <div class="form-group mb-4">
                        <div class="datepicker date input-group">
                            <input type="text" name="start_date" placeholder="Choose Date" class="form-control" id="fecha1">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3">
                    <label for="category">End Date</label>
                    <div class="form-group mb-4">
                        <div class="datepicker date input-group">
                            <input type="text" name="end_date" placeholder="Choose Date" class="form-control" id="fecha1">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3">


                    <div class="form-group">
                        <label for="name">Categories</label>
                        <select name="category_id" id="category_id" class="form-control select2">
                            <option>Select Category</option>
                            @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach

                        </select>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3">
                    <div class="form-group">
                        <label for="name">SubCategories</label>
                        <select name="subcategory_id" id="sub_category_id" class="form-control select2">
                            <option>Select SubCategory</option>
                        </select>
                    </div>

                </div>
            </div>
            <div class="row">

                <div class="col-lg-3 col-md-3">

                    <div class="form-group mb-4">
                        <div class="form-group">
                            <label for="name">User Type</label>
                            <select name="user_type" id="user_type" class="form-control select2">
                                <option>Select Category</option>

                                <option value="star">Star</option>
                                <option value="admin">Admin</option>

                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3">

                    <div class="form-group mb-4">

                        <label for="category">Select Name</label>
                        <select name="user_name" class="custom-select rounded-0" id="user_name" onmousedown="if(this.options.length>5){this.size=5;}" onchange="this.blur()" onblur="this.size=0;">
                            <option>Select Name</option>


                        </select>

                    </div>
                </div>
            </div>
            <div class="mb-5">

                <button type="submit" class="btn btn-lm btn-success">Get Report</button>
            </div>
        </form>
    </div>
</section>
<section class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3 id="total_published_post">{{$total_published_post}}</h3>
                        <p>Published Post</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer"><i class="fa-solid fa-clipboard"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3 id="total_pending_post">{{$total_pending_post}}</h3>
                        <p>Pending Post</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer"><i class="fa-solid fa-clipboard"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3 id="total_free_post">{{$total_free_post}}</h3>
                        <p> Total Free Post</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer"><i class="fa-solid fa-clipboard"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3 id="total_paid_post">{{$total_paid_post}}</h3>
                        <p> Total Paid Post</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer"><i class="fa-solid fa-clipboard"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-secondary">
                    <div class="inner">
                        <div class="row">
                            <div class="col-sm">
                                <h3 id="total_paid_post_fees">{{$total_paid_post_fees}}</h3>
                                <p> Total Paid Post Fees</p>
                            </div>

                        </div>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer"><i class="fa-duotone fa-dollar-sign"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>150</h3>
                            <p>New Orders</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>53<sup style="font-size: 20px">%</sup></h3>
                            <p>Bounce Rate</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>44</h3>
                            <p>User Registrations</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>65</h3>
                            <p>Unique Visitors</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
@endsection
@push('css')
<!-- datepicker styles -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css">
@endpush

@push('js')
<script>
    $(function() {
        $('.datepicker').datepicker({
            language: "es",
            autoclose: true,
            format: "yyyy/mm/dd"
        });
    });
</script>
<!-- Datepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<script>
    $(document).ready(function() {
        $("#category_id").click(function() {
            var category_id = $('#category_id').val();
            if (category_id > 0) {
                $.ajax({
                    url: "{{ url('manager-admin/all-report-filter-subCategory') }}/" + category_id,
                    type: 'GET',
                    success: function(res) {


                        var _html = '<option>Select SubCateory</option>';
                        $.each(res, function(index, res) {
                            _html += '<option value="' + res.id + '">' + res.name + '</option>';

                        });
                        $('#sub_category_id').html(_html);
                    }
                })
            }
        });



        $("#user_type").click(function() {
            var user_type = $('#user_type').val();
            if (user_type) {
                $.ajax({
                    url: "{{ url('manager-admin/simplePost-report-filter-userType') }}/" + user_type,
                    type: 'GET',

                    success: function(res) {

                        var _html = '<option>Select Name</option>';
                        $.each(res, function(index, res) {
                            _html += '<option value="' + res.id + '">' + res.first_name + ' ' + res.last_name + '</option>';

                        });
                        $('#user_name').html(_html);
                    }
                })
            }
        });

        $("#simplePostFilter").on('submit', function(event) {
            event.preventDefault();
            // alert("hello");




            $.ajax({
                url: "{{ route('managerAdmin.report.filter.simplePost') }}",
                type: "POST",
                data: $("#simplePostFilter").serialize(),
                success: function(response) {
                    $("#simplePostFilter")[0].reset();
                    $('#total_free_post').html(response.total_free_post);
                    $('#total_paid_post').html(response.total_paid_post);
                    $('#total_published_post').html(response.total_published_post);
                    $('#total_pending_post').html(response.total_pending_post);
                    $('#total_paid_post_fees').html(response.total_paid_post_fees);
                },
            });
        });




    });
</script>

@endpush
