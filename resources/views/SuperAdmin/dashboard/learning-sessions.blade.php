@extends('Layouts.SuperAdmin.master')


@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Learning Session</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Learning Session</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">

       <!-- /.row -->
       <div class="row">
        <div class="col-md-12">

          <div class="card">
            <div class="card-footer">
              <div class="row">
                <div class="col-sm-4 col-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-success"><i class="fas fa-eye"></i> view </span>
                    <h5 class="description-header">$35,210.43</h5>
                    <span class="description-text">Total Learning Session</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 col-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-warning"><i class="fas fa-eye"></i> view</span>
                    <h5 class="description-header">$10,390.90</h5>
                    <span class="description-text">Completed Learning Session</span>
                  </div>
                  <!-- /.description-block -->
                </div>
   
                <!-- /.col -->
                <div class="col-sm-4 col-6">
                  <div class="description-block">
                    <span class="description-percentage text-success"><i class="fas fa-eye"></i> view</span>
                    <h5 class="description-header">1200</h5>
                    <span class="description-text">Upcoming Learning Session</span>
                  </div>
                  <!-- /.description-block -->
                </div>
              </div>
              <!-- /.row -->
            </div>
          </div>

          <div class="card">
            <div class="card-footer">
              <div class="row">
                <div class="col-sm-6 col-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-success"><i class="fas fa-eye"></i> view </span>
                    <h5 class="description-header">$35,210.43</h5>
                    <span class="description-text">Total Registered User in Learning Session</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-6 col-6">
                  <div class="description-block">
                    <span class="description-percentage text-warning"><i class="fas fa-eye"></i> view</span>
                    <h5 class="description-header">$10,390.90</h5>
                    <span class="description-text">Total Payment in Learning Session</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                {{-- <div class="col-sm-3 col-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-success"><i class="fas fa-eye"></i> view</span>
                    <h5 class="description-header">$24,813.53</h5>
                    <span class="description-text">User Posts</span>
                  </div>
                  <!-- /.description-block -->
                </div> --}}
                <!-- /.col -->
                {{-- <div class="col-sm-3 col-6">
                  <div class="description-block">
                    <span class="description-percentage text-success"><i class="fas fa-eye"></i> view</span>
                    <h5 class="description-header">1200</h5>
                    <span class="description-text">Wallet</span>
                  </div>
                  <!-- /.description-block -->
                </div> --}}
              </div>
              <!-- /.row -->
            </div>
          </div>

          <div class="card">
            <div class="card-header">
              <h5 class="card-title">Monthly Visitors</h5>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <div class="btn-group">
                  <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                    <i class="fas fa-wrench"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right" role="menu">
                    <a href="#" class="dropdown-item">Action</a>
                    <a href="#" class="dropdown-item">Another action</a>
                    <a href="#" class="dropdown-item">Something else here</a>
                    <a class="dropdown-divider"></a>
                    <a href="#" class="dropdown-item">Separated link</a>
                  </div>
                </div>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <p class="text-center">
                    <strong>Visitors</strong>
                  </p>

                  <div class="chart">
                    <!-- Sales Chart Canvas -->
                    <canvas id="salesChart" height="180" style="height: 180px;"></canvas>
                  </div>
                  <!-- /.chart-responsive -->
                </div>
               
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- ./card-body -->
            
            <!-- /.card-footer -->
          </div>

         
          
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>


     
      <!-- /.row -->
    </div><!--/. container-fluid -->
  </section>
  <!-- /.content -->
@endsection

