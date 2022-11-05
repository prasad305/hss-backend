@extends('Layouts.ManagerAdmin.master')

@push('title')
    Manager Admin
@endpush


@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">FanGroup</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">FanGroup Details</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <div class="content">
        <div class="container-fluid">


            <div class="row">
                <div class="col-md-6 mb-2">
                    <div class="card p-2">

                        @if ($post->banner)
                            <img src="{{ asset($post->banner) }}" class="card-img-details" />
                        @else
                            <a href="{{ asset('demo_image/banner.jpg') }}" target="_blank">
                                <img src="{{ asset('demo_image/banner.jpg') }}" alt="Demo Image" />
                            </a>
                        @endif
                    </div>
                </div>

                <div class="row col-md-6 mb-2">
                    <div class="col-md-6 mb-2">
                        <div class="card p-2">

                            <center>
                                @if ($star_one->image)
                                    <img src="{{ asset($star_one->image) }}" class="img-fluid star-img-card" alt="">
                                @else
                                    <a href="{{ asset('demo_image/demo_user.png') }}" target="_blank">
                                        <img src="{{ asset('demo_image/demo_user.png') }}" alt="Demo Image"
                                            class="star-img-card" />
                                    </a>
                                @endif
                            </center>

                            <div class="text-center mt-2">
                                <h5 class="star-text-name">{{ $star_one->first_name }} {{ $star_one->last_name }} </h5>
                                <small-x> Phone : {{ $star_one->phone }}</small-x> <br />
                                <small-x> Email : {{ $star_one->email }}</small-x><br />
                                <small> Status :

                                    @if ($post->my_star_status == 1)
                                        <span class="badge badge-success">Accepted</span>
                                    @else
                                        <span class="badge badge-danger">Pending</span>
                                    @endif
                                </small>

                            </div>

                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="card p-2">

                            <center>
                                @if ($another_star->image)
                                    <img src="{{ asset($another_star->image) }}" class="img-fluid star-img-card"
                                        alt="">
                                @else
                                    <a href="{{ asset('demo_image/demo_user.png') }}" target="_blank">
                                        <img src="{{ asset('demo_image/demo_user.png') }}" alt="Demo Image"
                                            class="star-img-card" />
                                    </a>
                                @endif
                            </center>

                            <div class="text-center mt-2">
                                <h5 class="star-text-name">{{ $another_star->first_name }} {{ $another_star->last_name }}
                                </h5>
                                <small-x> Phone : {{ $another_star->phone }}</small-x> <br />
                                <small-x> Email : {{ $another_star->email }}</small-x><br />
                                <small> Status :

                                    @if ($post->another_star_status == 1)
                                        <span class="badge badge-success">Accepted</span>
                                    @else
                                        <span class="badge badge-danger">Pending</span>
                                    @endif
                                </small>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row pt-5 justify-content-between">
                <div class="col-md-12 ">
                    <div class=" card px-3 py-3">
                        <div>
                            <h3>{{ $post->group_name }}</h3>

                            <div class="title-text text-warning mt-2">Description</div>

                            <div class="description-text">{!! $post->description !!}</div>


                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-3  mb-2">
                    <div class="card px-3 p-2">
                        <label for="Date">Start Date</label>
                        <h4 class="text-warning">
                            {{ \Carbon\Carbon::parse($post->start_date)->format('d F,Y') }} </h4>
                    </div>
                </div>

                <div class="col-md-3  mb-2">
                    <div class="card px-3 p-2">
                        <label for="Date">End Date</label>
                        <h4 class="text-warning">
                            {{ \Carbon\Carbon::parse($post->end_date)->format('d F,Y') }} </h4>
                    </div>
                </div>



                <div class="col-md-3  mb-2">
                    <div class="card px-3 p-2">
                        <label for="Date">Minimum Member</label>
                        <h4 class="text-warning">
                            {{ $post->min_member }} </h4>
                    </div>
                </div>

                <div class="col-md-3  mb-2">
                    <div class="card px-3 p-2">
                        <label for="Date">Maximum Member</label>
                        <h4 class="text-warning">
                            {{ $post->max_member }} </h4>
                    </div>
                </div>


            </div>

            <div class="card  col-md-12">
                <div class="card-header"
                    style="color: gold; letter-spacing: .01rem; font-size: 18px; border-bottom: 1px solid #000;">
                    Publish Post in News Feed
                </div>
                <div class="card-body">

                    <form action="{{ route('managerAdmin.fangroup.set_publish') }}" method="post">
                        @csrf
                        <input type="hidden" name="postId" value="{{ $post->id }}" />
                        @if ($post->status != 1)
                            <div class="row mb-3">
                                <div class="mb-3 col-md-3 mb-2">
                                    <label for="start_date" class="form-label">Post Start Date</label>
                                    <input type="calender" class="form-control input-post" id="datepicker"
                                        name="post_start_date" readonly="readonly" />
                                    <i class="fa fa-calendar"
                                        style="position: absolute; top: 41px; left: 18px; font-size: 20px;"
                                        aria-hidden="true"></i>
                                    @if ($errors->has('post_start_date'))
                                        <span class="text-danger">{{ $errors->first('post_start_date') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3 col-md-3 mb-2">
                                    <label for="end_date" class="form-label">Post End Date</label>
                                    <input type="text" class="form-control input-post" id="datepicker1"
                                        name="post_end_date" readonly="readonly">
                                    <i class="fa fa-calendar"
                                        style="position: absolute; top: 41px; left: 18px; font-size: 20px;"
                                        aria-hidden="true"></i>
                                    @if ($errors->has('post_end_date'))
                                        <span class="text-danger">{{ $errors->first('post_end_date') }}</span>
                                    @endif
                                </div>
                            </div>

                            <button type="submit" class="btn btnPublish mr-2" href="">Publish
                                Now</button>
                        @elseif($post->status != 0)
                            <button type="submit" class="btn btnRemove mr-2 mb-4">Remove From Publish</button>
                        @endif
                        @if ($post->status != 1)
                            <a type="button" class="btn btnEdit px-5"
                                onclick="Show('Edit FanGroup','{{ route('managerAdmin.fangroup.edit', $post->id) }}')">Edit</a>
                        @endif
                    </form>

                </div>
            </div>

        </div>
    </div> <!-- content -->



    @if (session()->has('success'))
        <script type="text/javascript">
            $(document).ready(function() {
                // notify('{{ session()->get('success') }}','success');
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: '{{ Session::get('
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        success ') }}',
                    showConfirmButton: false,
                    timer: 1500
                })
            });
        </script>
    @endif
@endsection

@push('js')
    {{-- <script src="{{ asset('assets/manager-admin/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script> --}}
    <script src="{{ asset('assets/manager-admin/pages/dashborad.js') }}"></script>


    <script>
        $(function() {
            $("#datepicker").datepicker({
                minDate: 0,
                maxDate: "<?php echo \Carbon\Carbon::parse($post->start_date)->format('m/d/Y'); ?>"
            });
        });

        $(function() {
            $("#datepicker1").datepicker({
                minDate: "<?php echo \Carbon\Carbon::parse($post->end_date)->format('m/d/Y'); ?>",
                maxDate: "+100000D"
            });
        });
    </script>
@endpush


@push('jsstyle')
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.js"></script> -->
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
@endpush
