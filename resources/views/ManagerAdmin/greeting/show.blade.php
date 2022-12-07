@extends('Layouts.ManagerAdmin.master')

@push('title')
    Greeting Details
@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Greeting </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Greeting Details</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-8 mb-2">
                    <div class="card p-2">
                        <div class="center">
                            @if ($greeting->banner)
                                <img src="{{ asset($greeting->banner) }}" class="card-img-details" />
                            @else
                                <a href="{{ asset('demo_image/banner.jpg') }}" target="_blank">
                                    <img src="{{ asset('demo_image/banner.jpg') }}" alt="Demo Image"
                                        class="card-img-details" />
                                </a>
                            @endif
                        </div>
                    </div>

                </div>

                <div class="col-md-4 mb-2">

                    <div class="card p-2 mb-2">
                        <video width="100%" src="{{ asset($greeting->video) }}" type="video/mp4" controls
                            class="img-fluid">

                        </video>
                    </div>

                    <div class="col-md-12 d-flex mb-2 p-2 bg-dark align-items-center card-rounded">
                        <div class="">
                            @if ($greeting->star->image)
                                <img src="{{ asset($greeting->star->image) }}" class="img-star-x" alt="Demo Image" />
                            @else
                                <a href="{{ asset('demo_image/demo_user.png') }}" target="_blank">
                                    <img src="{{ asset('demo_image/demo_user.png') }}" class="img-star-x"
                                        alt="Demo Image" />
                                </a>
                            @endif
                        </div>
                        <div class="mx-2">
                            <label for="">Star</label>
                            <h5>{{ $greeting->star->first_name }} {{ $greeting->star->last_name }}</h5>

                        </div>
                    </div>

                    <div class="col-md-12 d-flex mb-2 p-2 bg-dark align-items-center card-rounded">
                        <div class="">
                            @if ($greeting->admin->image)
                                <img src="{{ asset($greeting->admin->image) }}" class="img-star-x" alt="Demo Image" />
                            @else
                                <a href="{{ asset('demo_image/demo_user.png') }}" target="_blank">
                                    <img src="{{ asset('demo_image/demo_user.png') }}" class="img-star-x"
                                        alt="Demo Image" />
                                </a>
                            @endif
                        </div>
                        <div class="mx-2">
                            <label for="">Admin</label>
                            <h5>{{ $greeting->admin->first_name }} {{ $greeting->admin->last_name }}</h5>

                        </div>
                    </div>

                </div>

                <div class="col-md-12 mb-2 ">
                    <div class=" card px-3 py-3">
                        <div>
                            <h4>{{ $greeting->title }}</h4>
                            <div class="title-text text-warning">Instruction</div>

                            <div class="description-text">{!! $greeting->instruction !!}</div>
                        </div>
                    </div>
                </div>



                <div class="col-md-4 col-lg-3  mb-2">
                    <div class="card px-3 p-2">
                        <label for="Date"> <span>
                                <img src="{{ asset('assets/manager-admin/tagPrice.PNG') }}" alt=""
                                    width="20px" />
                            </span>Cost</label>
                        <h4 class="text-warning">
                            ${{ $greeting->cost }}</h4>
                    </div>
                </div>

                <div class="col-md-4 col-lg-3  mb-2">
                    <div class="card px-3 p-2">
                        <label for="Date"> <span>
                                <img src="{{ asset('assets/manager-admin/tagPrice.PNG') }}" alt=""
                                    width="20px" />
                            </span>Minimum apply before</label>
                        <h4 class="text-warning">
                            {{ $greeting->user_required_day }} Day</h4>
                    </div>
                </div>

            </div>

            <div class="card col-md-12 ">
                <div class="card-header"
                    style="color: gold; letter-spacing: .01rem; font-size: 18px; border-bottom: 1px solid #000;">
                    Publish Post in News Feed
                </div>
                <div class="card-body">
                    @if ($greeting->status == 1)
                        <button value="{{ route('managerAdmin.greeting.publish', $greeting->id) }}" onclick="publish(this)"
                            class="btn btnPublish mr-2">Publish
                            Now </button>
                        <a type="button" class="btn btnEdit px-5"
                            onclick="Show('Edit Post','{{ route('managerAdmin.greeting.edit', $greeting->id) }}')">Edit</a>
                    @else
                        <button value="{{ route('managerAdmin.greeting.publish', $greeting->id) }}"
                            onclick="unPublish(this)" class="btn btnRemove mr-2">Remove Form Publish </button>
                    @endif
                </div>
            </div>



        </div> <!-- container -->
    </div> <!-- content -->


    <script>
        function publish(objButton) {
            var url = objButton.value;
            // alert(objButton.value)
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Publish !'
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
                                    'Published !',
                                    'This greeting has been published. ' + data.message,
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

        function unPublish(objButton) {
            var url = objButton.value;
            // alert(objButton.value)
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, UnPublish !'
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
                                    'UnPublished !',
                                    'This greeting has been unpublished. ' + data.message,
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
@endsection
