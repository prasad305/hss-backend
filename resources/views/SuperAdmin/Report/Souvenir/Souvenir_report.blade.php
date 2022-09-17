@extends('Layouts.SuperAdmin.master')

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


<form id="souvenirfilter" action="" method="">

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
                            <select name="sub_category_id" id="sub_category_id" class="form-control select2">
                                <option>Select SubCategory</option>
                            </select>
                        </div>

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
                        <h3 id="total_souvenir">{{ $total_souvenir }}</h3>
                        <p>Total Souvenir</p>
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
                        <h3 id="total_amount">{{ $total_amount }}<sup style="font-size: 20px"></sup></h3>
                        <p>Total Amount/p>
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
                        <h3 id="total_sounenir_item">{{ $total_sounenir_item }}</h3>
                        <p>Total Souvenir Item</p>
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
                        <h3 id="total_sounenir_item_price">{{ $total_sounenir_item_price }}</h3>
                        <p>Total Souvenir Item Price </p>
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
        $("#souvenirfilter").on('submit', function(event) {
            // console.log('123');
            event.preventDefault();
            // alert("hello");




            $.ajax({
                url: "{{ route('superAdmin.report.filter.souvenirReport') }}",
                type: "POST",
                data: $("#souvenirfilter").serialize(),
                success: function(respose) {
                    // console.log('Submission was successful.');
                    // console.log(respose);
                    $("#souvenirfilter")[0].reset();
                    $('#total_amount').html(respose.total_amount);
                    $('#total_sounenir_item').html(respose.total_sounenir_item);
                    $('#total_sounenir_item_price').html(respose.total_sounenir_item_price);
                    $('#total_souvenir').html(respose.total_souvenir);
                },
            });
        });




        $("#category_id").click(function() {
            var category_id = $('#category_id').val();
            console.log(category_id);
            if (category_id > 0) {
                $.ajax({
                    url: "{{ url('super-admin/all-report-filter-subCategory') }}/" + category_id,
                    type: 'GET',

                    success: function(res) {
                        console.log(res);

                        var _html = '<option>Select SubCateory</option>';
                        $.each(res, function(index, res) {
                            _html += '<option value="' + res.id + '">' + res.name + '</option>';

                        });
                        $('#sub_category_id').html(_html);
                    }
                })
            }
        });


    });
</script>


@endpush
