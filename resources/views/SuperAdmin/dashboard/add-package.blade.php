@extends('Layouts.SuperAdmin.master')


@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">dashboard</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
<hr>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
     
      <div class="row">
          <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-header" style="font-size: 28px;  font-weight: 600; color: gold;  text-align: center;">
                    Add Package
                </div>
                <div class="card-body">
                  <form action="{{ route('superAdmin.packageStore') }}" method="POST">
                    @csrf
                    <div class="row">
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label for="" class="form-label">Package Name</label>
                          <input type="text" class="form-control" id="name" name="name" placeholder="Package name">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label for="" class="form-label">Club Points</label>
                          <input type="text" class="form-control" id="club_points" name="club_points" placeholder="Club points value">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label for="" class="form-label">Auditions</label>
                          <input type="text" class="form-control" id="auditions" name="auditions" placeholder="Auditions value">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label for="" class="form-label">Learning Session</label>
                          <input type="text" class="form-control" id="learning_session" name="learning_session" placeholder="Learning session value">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label for="" class="form-label">Live Chats</label>
                          <input type="text" class="form-control" id="live_chats" name="live_chats" placeholder="Live chats value">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label for="" class="form-label">Meetup Events</label>
                          <input type="text" class="form-control" id="meetup" name="meetup" placeholder="Meetup Events value">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label for="" class="form-label">Greetings</label>
                          <input type="text" class="form-control" id="greetings" name="greetings" placeholder="Greetings value">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label for="" class="form-label">Price</label>
                          <input type="text" class="form-control" id="price" name="price" placeholder="Price name">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                      </div>
                    </div>
                    
                    
                  </form>
                </div>
              </div>
          </div>
      </div>

    </div><!--/. container-fluid -->
  </section>
  <!-- /.content -->
@endsection

