@extends('Layouts.ManagerAdmin.master')

@push('title')
    Manager Admin
@endpush

<style>
    .password-container{
        position: relative;
    }
    .password-container input[type="password"],
    .password-container input[type="text"]{
        width: 100%;
        padding: 12px 36px 12px 12px;
        box-sizing: border-box;
    }
    .fa-eye{
        position: absolute;
        top: 60%;
        right: 2%;
        cursor: pointer;
        color: lightgray;
    }
</style>

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Settings</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Settings</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->



    <div class="content">
        <div class="container-fluid">


            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6" style=" border: 1px solid gold; padding: 10px; border-radius: 5px;">
                    <form action="{{ route('managerAdmin.change.updateprofile') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="panel panel-primary">
                            <div class="panel-heading text-center">
                            <h2 style="color:#FFD700;border-bottom:1px solid #FFD700;">UPDATE YOUR PROFILE</h2>
                            @if($user->image)
                                    <img src="{{asset($user->image)}}" class="img-circle" style="width:150px; height:150px; border:3px solid #FFD700" alt="Image not found">
                                    <br>
                                    <input type="file" name="profile" style="width:93px;" onChange="PreviewImage(this)">

                            @else
                                <img src="{{asset('uploads/images/users/manager-admin-avatar.png')}}" class="img-circle" style="width:150px; height:150px; border:3px solid #FFD700" alt="Image not found">
                            @endif
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="container">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="first_name">First Name</label>
                                                <input type="text" name="first_name" class="form-control" id="first_name"
                                                    value="{{ $user->first_name }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="last_name">Last Name</label>
                                                <input type="text" name="last_name" class="form-control" id="last_name"
                                                    value="{{ $user->last_name }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email Address</label>
                                                <input type="text" name="email" class="form-control" id="email"
                                                    value="{{ $user->email }}" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="phone">Phone No</label>
                                                <input type="text" name="phone" class="form-control" id="phone"
                                                    value="{{ $user->phone }}" disabled>
                                            </div>
                                            <div class="panel-footer">
                                                <div class=" text-center">
                                                    <button type="submit" class="btn btn-dark waves-effect waves-ligh">Update Profile</button>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form action="{{ route('managerAdmin.change.password') }}" method="POST">
                        @csrf
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="container">
                                        <div class="col">
                                            <hr>
                                            <h4 class="panel-title  text-white">Change Password</h4>

                                            @include('Others.message')
                                            <hr>
                                            <div class="row form-group">
                                                <div class="col-md-6">
                                                    <div class="password-container">
                                                        <label for="oldPassword">Current Password</label>
                                                        <input type="password" name="oldPassword" class="form-control passwordold" id="oldPassword">
                                                        <i class="fa-solid fa-eye" id="eyeold"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="password-container">
                                                        <label for="password">New Password</label>
                                                        <input type="password" name="password" class="form-control passwordnew" id="password">
                                                        <i class="fa-solid fa-eye" id="eyenew"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-6">
                                                    <div class="password-container">
                                                        <label for="confirmPassword">Confirm Password</label>
                                                        <input type="password" name="confirmPassword" class="form-control passwordconf" id="confirmPassword">
                                                        <i class="fa-solid fa-eye" id="eyeconf"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <div class=" text-center">
                                    <button type="submit" class="btn btn-dark waves-effect waves-ligh">Update Passowrd</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <br><br>
                </div>
            </div>
            
 <script>
    const passwordold = document.querySelector(".passwordold");
    const passwordnew = document.querySelector(".passwordnew");
    const passwordconf = document.querySelector(".passwordconf");
    const eyeold = document.querySelector("#eyeold");
    const eyenew = document.querySelector("#eyenew");
    const eyeconf = document.querySelector("#eyeconf");

    eyeold.addEventListener("click", function(e){
        e.preventDefault();
        eyeold.classList.toggle("fa-eye-slash");
        const type = passwordold.getAttribute("type") === "password" ? "text" : "password";
        passwordold.setAttribute("type", type);
    })
    eyenew.addEventListener("click", function(e){
        e.preventDefault();
        eyenew.classList.toggle("fa-eye-slash");
        const type = passwordnew.getAttribute("type") === "password" ? "text" : "password";
        passwordnew.setAttribute("type", type);
    })
    eyeconf.addEventListener("click", function(e){
        e.preventDefault();
        eyeconf.classList.toggle("fa-eye-slash");
        const type = passwordconf.getAttribute("type") === "password" ? "text" : "password";
        passwordconf.setAttribute("type", type);
    })
 
    
</script>


        </div> <!-- container -->
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
    @else{
        <script>
            console.log('error')
        </script>
    }@endif
@endsection

@push('script')
    {{-- <script src="{{ asset('assets/manager-admin/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script> --}}
    <script src="{{ asset('assets/manager-admin/pages/dashborad.js') }}"></script>
@endpush


