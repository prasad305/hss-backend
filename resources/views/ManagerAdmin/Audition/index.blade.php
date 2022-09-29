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
                <h1 class="m-0">Audition</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Audition</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->

<hr>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->



<div class="content">
    <div class="container-fluid">
        <div class="row">
            @foreach ($audition as $val)
            <div class="col-sm-6 col-md-4  col-lg-3">
                <div class=" bg-dark shadow-none pb-4 m-3 BGaB">
                    <img src="{{ asset($val->banner) }}" class="img-fluid w-100"style="max-height:200px borderRadius: 50% " alt="Admin Image"
                        class="img-fluid ImgBlue mr-3 mb-2 w-100">

                    <div className="">
                        <div>
                            <h5 class="text-center text-bold mt-4">{{ $val->name }}</h5>

                            <center>

                                {{-- @if ($val->star_approval == 1)

                            <a type="button" class="btn btn-warning waves-effect  waves-light"><i class="icon-record"></i>
                                Pending</a>
                            @else

                            <button type="button" class="btn btn-success waves-effect  waves-light"><i class="icon-checkmark-round"></i> Published</button>
                            @endif --}}

                                <a href="{{ route('managerAdmin.audition.details', [$val->id]) }}" type="button" class="btn waves-effect  waves-light detail-btn-use text-light">Details <i class="fa fa-angle-double-right"></i></a>

                            @if ($val->status >= 3)
                                <a href="{{route('managerAdmin.audition.registerUser',$val->id)}}" class="btn  reg-btn-user  mx-1">Register User</a>
                            @endif
                            </center>

                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div> <!-- container -->
</div> <!-- content -->

@if (session()->has('success'))
<script type="text/javascript">
    $(document).ready(function() {
        // notify('{{ session()->get('success') }}','success');
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: '{{ Session::get("success") }}',
            showConfirmButton: false,
            timer: 1500
        })
    });
</script>
@endif
@endsection



@push('script')
{{-- <script src="{{ asset('assets/manager-admin/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script> --}}
<script src="{{ asset('assets/manager-admin/pages/dashborad.js') }}"></script>
@endpush
