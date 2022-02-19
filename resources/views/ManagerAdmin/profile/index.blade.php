@extends('ManagerAdmin.layouts.master')

@push('title')
Manager Admin
@endpush

@push('css')

@endpush

@section('content')
<div class="content">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-header-title">
                    <h4 class="pull-left page-title">Profile</h4>
                    <ol class="breadcrumb pull-right">
                        <li><a href="{{ route('managerAdmin.dashboard') }}">manager Admin Panel</a></li>
                        <li class="active">Profile</li>
                    </ol>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div> 
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title  text-white">{{ $user->name }}'s information</h3>
                    </div>
                    <div class="panel-body">
                        <div class="text-center">
                            <img height="200px;" width="200px;" class="card-img profile-card-image"
                                src="{{ asset($user->image ?? get_static_option('no_image')) }}" alt="Card image cap">
                            <h1 class="profile-name">{{ $user->name }}</h1>
                        </div>
                        <div class="row">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <span class="badge badge-primary">{{ $user->email }}</span>
                                    Email
                                </li>
                                <li class="list-group-item">
                                    <span class="badge badge-info">{{ $user->phone }}</span>
                                   Phone
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel-footer">
                    
                    </div>
                </div>          
            </div>
            <div class="col-md-6">
                {{-- <form action="{{ route('changePassword') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('Others.message')
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title  text-white">Change Password</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                               <div class="container">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="oldPassword">Current Password</label>
                                        <input type="password" name="oldPassword" class="form-control" id="oldPassword">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">New Password</label>
                                        <input type="password" name="password" class="form-control" id="password">
                                    </div>                                               
                                    <div class="form-group">
                                        <label for="confirmPassword">Confirm Password</label>
                                        <input type="password" name="confirmPassword" class="form-control" id="confirmPassword">
                                    </div>                                               
                                </div>
                               </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class=" text-right">
                                <button type="submit" class="btn btn-dark waves-effect waves-ligh">Submit</button>
                            </div>
                        </div>
                    </div>
                </form> --}}
            </div>
        </div> <!-- End Row -->

        
    </div> <!-- container -->
</div> <!-- content -->
@endsection

@push('script')
{{-- <script src="{{ asset('assets/manager-admin/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script> --}}
<script src="{{ asset('assets/manager-admin/pages/dashborad.js') }}"></script>
@endpush
