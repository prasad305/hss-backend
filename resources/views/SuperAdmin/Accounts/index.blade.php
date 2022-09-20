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
                    <h1 class="m-0">Accounts</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Accounts</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->



    {{-- <div class="content">

        <div class="container-fluid">

            <div class="row">
                <div class="col-12 col-sm-6 col-md-12">
                    <div class="info-box text-center">
                        <div class="info-box-content">
                            <span class="info-box-text text-warning">Total Income</span>
                            <span class="info-box-number">
                                10
                            </span>
                            <span class="info-box-number">
                                <small><a class="text-warning" href="{{ route('superAdmin.accounts.totalEvents') }}">See
                                        All</a></small>
                            </span>
                        </div>

                    </div>

                </div>
            </div>

            <div class="row">

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-money"
                                aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Daily Income</span>
                            <span class="info-box-number">41,410</span>
                            <span class="info-box-number">
                                <small><a class="text-warning" href="{{ route('superAdmin.accounts.dailyEvents') }}">See
                                        All</a></small>
                            </span>
                        </div>

                    </div>

                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-money"
                                aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Weekly Income</span>
                            <span class="info-box-number">41,410</span>
                            <span class="info-box-number">
                                <small><a class="text-warning" href="{{ route('superAdmin.accounts.weeklyEvents') }}">See
                                        All</a></small>
                            </span>
                        </div>

                    </div>

                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-money"
                                aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Monthly Income</span>
                            <span class="info-box-number">41,410</span>
                            <span class="info-box-number">
                                <small><a class="text-warning" href="{{ route('superAdmin.accounts.monthlyEvents') }}">See
                                        All</a></small>
                            </span>
                        </div>

                    </div>

                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-money"
                                aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Yearly Income</span>
                            <span class="info-box-number">41,410</span>
                            <span class="info-box-number">
                                <small><a class="text-warning" href="{{ route('superAdmin.accounts.yearlyEvents') }}">See
                                        All</a></small>
                            </span>
                        </div>

                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-12 col-sm-6 col-md-12">
                    <div class="info-box text-center">
                        <div class="info-box-content">
                            <span class="info-box-text text-warning">Admin & Superstar</span>
                        </div>

                    </div>

                </div>
            </div>

            <div class="row">

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-users"
                                aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Manager Admin</span>
                            <span class="info-box-number">41,410</span>
                            <span class="info-box-number">
                                <small><a class="text-warning"
                                        href="{{ route('superAdmin.accounts.managerAdminList') }}">See
                                        All</a></small>
                            </span>
                        </div>

                    </div>

                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-users"
                                aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Admin</span>
                            <span class="info-box-number">41,410</span>
                            <span class="info-box-number">
                                <small><a class="text-warning" href="{{ route('superAdmin.accounts.adminList') }}">See
                                        All</a></small>
                            </span>
                        </div>

                    </div>

                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-users"
                                aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Superstar</span>
                            <span class="info-box-number">41,410</span>
                            <span class="info-box-number">
                                <small><a class="text-warning"
                                        href="{{ route('superAdmin.accounts.superstarList') }}">See
                                        All</a></small>
                            </span>
                        </div>

                    </div>

                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-users"
                                aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Audition Admin</span>
                            <span class="info-box-number">41,410</span>
                            <span class="info-box-number">
                                <small><a class="text-warning"
                                        href="{{ route('superAdmin.accounts.auditionAdminList') }}">See
                                        All</a></small>
                            </span>
                        </div>

                    </div>

                </div>
            </div>


        </div> <!-- container -->
    </div> <!-- content --> --}}





    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <label for="category">Start Date</label>
                    <div class="form-group mb-4">
                        <div class="datepicker date input-group">
                            <input type="text" name="start_date" placeholder="Choose Date" class="form-control"
                                id="s_date">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4">
                    <label for="category">End Date</label>
                    <div class="form-group mb-4">
                        <div class="datepicker date input-group">
                            <input type="text" name="end_date" placeholder="Choose Date" class="form-control"
                                id="e_date">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">

                    <div class="form-group mb-4">

                        <label for="category">Select Module</label>
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
                        </select>

                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-lg-4 col-md-4">


                    <div class="form-group">
                        <label for="name">Categories</label>
                        <select name="category_id"  class="form-control select2 category_id">
                            <option>Select Category</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="col-lg-4 col-md-4">

                    <div class="form-group mb-4">
                        <div class="form-group">
                            <label for="name">SubCategories</label>
                            <select name="sub_category_id"  class="form-control select2 sub_category_id">
                                <option>Select SubCategory</option>
                            </select>
                        </div>

                    </div>
                </div>
                <div class="col-lg-4 col-md-4">

                    <div class="form-group mb-4">
                        <div class="form-group">
                            <label for="name">SuperStar</label>
                            <select name="user_name" id = "user_name" class="custom-select rounded-0" id="user_name" onmousedown="if(this.options.length>5){this.size=5;}" onchange="this.blur()" onblur="this.size=0;">
                                <option>Select SuperStar</option>


                            </select>
                        </div>

                    </div>
                </div>
            </div>
            <div class="mb-5">

                <button type="submit" class="btn btn-lm btn-warning"><b>Get List</b></button>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-users"
                                aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Manager Admin</span>
                            <span class="info-box-number">41,410</span>
                            <span class="info-box-number">
                                <small><a class="text-warning"
                                        href="{{ route('superAdmin.accounts.managerAdminList') }}">See
                                        All</a></small>
                            </span>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>
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
        //  console.log('123');
        // var form=$("#myForm");
        // $("#filter").on('submit', function(event) {
        //     // console.log('123');
        //     event.preventDefault();
        //     // alert("hello");




        //     $.ajax({
        //         url: "{{ route('superAdmin.report.filter.learningSession') }}",
        //         type: "POST",
        //         data: $("#filter").serialize(),
        //         success: function(respose) {
        //             // console.log('Submission was successful.');
        //             console.log(respose);
        //             $("#filter")[0].reset();
        //             $('#tot_certificate').html(respose.certificate);
        //             $('#tot_assFee').html(respose.assignment_fee);
        //             $('#tot_regFee').html(respose.registration_fee);
        //             $('#tot_assFee').html(respose.assignment_fee);
        //             $('#tot_assignment').html(respose.assignment);
        //         },
        //     });
        // });




        $(".category_id").click(function() {
            var category_id = $('.category_id').val();
            console.log(category_id);
            if (category_id > 0) {
                $.ajax({
                    url: "{{ url('super-admin/all-accounts-filter-subCategory') }}/" + category_id,
                    type: 'GET',

                    success: function(res) {
                        console.log(res);

                        var _html = '<option>Select SuperStar</option>';
                        $.each(res, function(index, res) {
                            _html += '<option value="' + res.id + '">' + res.name + '</option>';

                        });
                        $('.sub_category_id').html(_html);
                    }
                })
            }
        });


        $(".sub_category_id").click(function() {
            // alert('123');
            var subCat_id = $('.sub_category_id').val();
            var cat_id = $('.category_id').val();
            console.log(subCat_id,cat_id);
            if (subCat_id > 0) {

                $.ajax({
                    url: "{{ url('super-admin/accounts-index-superstar-filter') }}" +'/'+ subCat_id +'/'+ cat_id,
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
