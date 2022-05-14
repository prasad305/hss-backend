@extends('Layouts.SuperAdmin.master')


@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0" style="font-size: 25px; color: #fff3b4; font-weight: 600;">User Posts</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">User Posts</li>
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
                <div class="col-sm-3 col-6">
                  <div class="description-block border-right">
                    <a href="{{ route('superAdmin.allPost') }}">
                      <span class="description-percentage text-success"><i class="fas fa-eye"></i> view </span>
                    </a>
                    <h5 class="description-header">{{ $allPostCount }}</h5>
                    <span class="description-text">Total User Posts</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-6">
                  <div class="description-block border-right">
                    <a href="{{ route('superAdmin.weeklyPost') }}">
                      <span class="description-percentage text-warning"><i class="fas fa-eye"></i> view</span>
                    </a>
                    <h5 class="description-header">{{ $weeklyPostCount }}</h5>
                    <span class="description-text">Weekly User Posts</span>
                  </div>
                  <!-- /.description-block -->
                </div>
   
                <!-- /.col -->
                <div class="col-sm-3 col-6">
                  <div class="description-block border-right">
                    <a href="{{ route('superAdmin.monthlyPost') }}">
                      <span class="description-percentage text-success"><i class="fas fa-eye"></i> view</span>
                    </a>
                    <h5 class="description-header">{{ $monthlyPostCount }}</h5>
                    <span class="description-text">Monthly User Posts</span>
                  </div>
                  <!-- /.description-block -->
                </div>
   
                <!-- /.col -->
                <div class="col-sm-3 col-6">
                  <div class="description-block">
                    <a href="{{ route('superAdmin.dailyPost') }}">
                      <span class="description-percentage text-success"><i class="fas fa-eye"></i> view</span>
                    </a>
                    <h5 class="description-header">{{ $dailyPostCount }}</h5>
                    <span class="description-text">Daily User Posts</span>
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
                <div class="col-sm-4 col-6">
                  <div class="description-block border-right">
                    {{-- <span class="description-percentage text-success"><i class="fas fa-eye"></i> view </span> --}}
                    <h5 class="description-header">{{ $likesPost }}</h5>
                    <span class="description-text">Total Likes in Posts</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 col-6">
                  <div class="description-block border-right">
                    {{-- <span class="description-percentage text-warning"><i class="fas fa-eye"></i> view</span> --}}
                    <h5 class="description-header">{{ $commentPost }}</h5>
                    <span class="description-text">Total Comments in Posts</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 col-6">
                  <div class="description-block">
                    {{-- <span class="description-percentage text-warning"><i class="fas fa-eye"></i> view</span> --}}
                    <h5 class="description-header">{{ $sharePost }}</h5>
                    <span class="description-text">Total Share in Posts</span>
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
          
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>



      <div class="row">
        <div class="col-md-12 ">
            <div class="card">
                <h5 class="card-header" style="font-size: 20px; color: gold; font-weight: 600;">User Visitor Count</h5>
                <div class="panel-body">
                    <canvas id="canvas" height="280" width="600"></canvas>
                </div>
            </div>
        </div>
      </div>
      <div class="row">
          <div class="col-md-12 ">
              <div class="card">
                  <h5 class="card-header" style="font-size: 20px; color: gold; font-weight: 600;">Payment History</h5>
                  <div class="panel-body">
                      {{-- <canvas id="canvas" height="280" width="600"></canvas> --}}
                      <canvas id="myChart"></canvas>
                  </div>
              </div>
          </div>
      </div>


     
      <!-- /.row -->
    </div><!--/. container-fluid -->
  </section>
  <!-- /.content -->

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
    const labels = ['Jan','Feb','Mar','Apr','May','Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
  
    const data = {
      labels: labels,
      datasets: [{
        label: 'Payment',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: ['2017','1158','2019','20','586','2022', '2417','1158','2019','20','586','222'],
      }]
    };
  
    const config = {
      type: 'bar',
      data: data,
      options: {}
    };
  </script>
  
  <script>
    const myChart = new Chart(
      document.getElementById('myChart'),
      config
    );
  </script>
  
  <script>
    var year = <?php echo $year; ?>;
    var user = <?php echo $user; ?>;
    var barChartData = {
        labels: year,
        datasets: [{
            label: 'User',
            backgroundColor: "#faebd736",
            data: user
        }]
    };
  
    window.onload = function() {
        var ctx = document.getElementById("canvas").getContext("2d");
        window.myBar = new Chart(ctx, {
            type: 'line',
            data: barChartData,
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 2,
                        borderColor: '#gold',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true,
                title: {
                    display: true,
                    text: 'Yearly Visitor Count'
                }
            }
        });
    };
  </script>
  
@endsection

