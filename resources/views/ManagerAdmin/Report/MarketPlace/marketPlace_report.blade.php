@extends('Layouts.ManagerAdmin.master')

@push('title')
Super Admin
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


<form id="marketfilter" action="" method="">

    @csrf
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <label for="category">Start Date</label>
                    <div class="form-group mb-4">
                        <div class="datepicker date input-group">
                            <input type="text" name="start_date" placeholder="Choose Date" class="form-control" id="s_date">
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
                            <input type="text" name="end_date" placeholder="Choose Date" class="form-control" id="e_date">
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
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="col-lg-3 col-md-3">

                    <div class="form-group mb-4">

                        <!-- <label for="category">Select Module</label>
                        <select name="category" class="custom-select rounded-0" id="category">
                            <option selected="" disabled="">Select Module</option>
                            <option value="13">Simple Post</option>
                            <option value="12">Live Chat</option>
                            <option value="11">Greeting</option>
                            <option value="10">Learning Session</option>
                            <option value="9">Meetup Event</option>
                            <option value="8">Audition</option>
                            <option value="7">Q&A</option>
                            <option value="6">Auction</option>
                            <option value="5">Marketplace</option>
                            <option value="4">Souvenir</option>
                            <option value="3">Fan Group</option>
                        </select> -->

                        <div class="form-group">
                            <label for="name">SubCategories</label>
                            <select name="subcategory_id" id="subcategory_id" class="form-control select2">
                                <option>Select SubCategory</option>
                            </select>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-lg-3 col-md-3">

                    <div class="form-group mb-4">
                        <div class="form-group">
                            <label for="name">User Type</label>
                            <select name="user_type" id="user_type" class="form-control select2">
                                <option>Select Type</option>

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
        </div>
    </section>
</form>
<section class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3 id="unit_Product_price">{{ $unit_Product_price }}</h3>
                        <p>Total Product Price</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3 id="tax">{{ $tax }}<sup style="font-size: 20px"></sup></h3>
                        <p>Total Tax</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            {{-- <div class="col-lg-3 col-6">

                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3>44</h3>
                            <p>Total Certificate Fee</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div> --}}

            <div class="col-lg-3 col-6">

                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3 id="total_order">{{ $total_order }}</h3>
                        <p>Total Order</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3 id="total_items">{{ $total_items }}</h3>
                        <p>Total Item</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
{{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script> --}}

<script>
    $(document).ready(function() {
        //  console.log('123');
        // var form=$("#myForm");
        $("#marketfilter").on('submit', function(event) {
            // console.log('123');
            event.preventDefault();
            // alert("hello");




            $.ajax({
                url: "{{ route('managerAdmin.report.filter.marketPlace') }}",
                type: "POST",
                data: $("#marketfilter").serialize(),
                success: function(respose) {
                    // console.log('Submission was successful.');
                    console.log(respose);
                    $("#marketfilter")[0].reset();
                    $('#unit_Product_price').html(respose.unit_Product_price);
                    $('#tax').html(respose.tax);
                    $('#total_items').html(respose.total_items);
                    $('#total_order').html(respose.total_order);
                },
            });
        });




        $("#category_id").click(function() {
            var category_id = $('#category_id').val();
            console.log(category_id);
            if (category_id > 0) {
                $.ajax({
                    url: "{{ url('manager-admin/all-report-filter-subCategory') }}/" + category_id,
                    type: 'GET',

                    success: function(res) {
                        console.log(res);

                        var _html = '<option>Select SubCateory</option>';
                        $.each(res, function(index, res) {
                            _html += '<option value="' + res.id + '">' + res.name + '</option>';

                        });
                        $('#subcategory_id').html(_html);
                    }
                })
            }
        });

        $("#user_type").click(function() {
            var user_type = $('#user_type').val();
            // console.log(user_type);
            if (user_type) {
                $.ajax({
                    url: "{{ url('manager-admin/simplePost-report-filter-userType') }}/" + user_type,
                    // url: "{{url('super-admin/learningSession-report-filter-subCategory')}}" + '/' + category_id,
                    type: 'GET',

                    success: function(res) {
                        console.log(res);

                        var _html = '<option>Select Name</option>';
                        $.each(res, function(index, res) {
                            _html += '<option value="' + res.id + '">' + res.first_name + ' ' + res.last_name + '</option>';

                        });
                        $('#user_name').html(_html);
                    }
                })
            }
        });



    });
</script>


@endpush
