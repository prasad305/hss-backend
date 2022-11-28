@extends('Layouts.SuperAdmin.master')


@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Marketplace Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Marketplace Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="card-footer clearfix">
        <a href="{{ route('superAdmin.dashboard') }}" class="btn btn-sm btn-warning float-right">Go Back</a>
    </div>
    <!-- Main content -->
    <div class="content">

        <div class="container-fluid">

            <div class="row">
                <div class="col-12 col-sm-6 col-md-12">
                    <div class="info-box text-center">
                        <div class="info-box-content">
                            <span class="info-box-text text-warning">
                                {{ auth()->user()->category->name }}</span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                @foreach ($categories as $category)
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3 text-center border border-warning">
                            <span class="info-box-icon bg-success elevation-1"><i class="fa fa-list-alt"
                                    aria-hidden="true"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">{{ $category->name }}</span>
                                <span class="info-box-number">{{ $category->marketplace->count() }}</span>
                                <span class="info-box-number">
                                    <small><a class="text-warning"
                                            href="{{ route('superAdmin.submarketplace.list', $category->id) }}">See
                                            All</a></small>
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total</span>
                            <span class="info-box-number">
                                {{ $total }}
                            </span>
                            <a href="{{ route('superAdmin.dashboard.marketplaceData', 'total') }}">
                                <span class="my-link"><i class="fas fa-eye"> View All </i> </span>
                            </a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Sold</span>
                            <span class="info-box-number">{{ $soldItem }}</span>
                            <a href="{{ route('superAdmin.dashboard.marketplaceData', 'sold') }}">
                                <span class="my-link"><i class="fas fa-eye"> View All </i> </span>
                            </a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-4">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">InStock</span>
                            <span class="info-box-number">{{ $total - $soldItem }}</span>
                            <a href="{{ route('superAdmin.dashboard.marketplaceData', 'instock') }}">
                                <span class="my-link"><i class="fas fa-eye"> View All </i> </span>
                            </a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!--/. container-fluid -->
    </section>
    <!-- /.content -->
    <div class="row">
        <div class="col-12 col-sm-6 col-md-12">
            <div class="info-box text-center">
                <div class="info-box-content">
                    <span class="info-box-text text-warning">Admin and Stars</span>
                </div>
            </div>

        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-6">
                    <div class="info-box border border-warning">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content text-center">
                            <span class="info-box-text">Admin</span>
                            <span class="info-box-number">
                                {{ $admin }}
                            </span>
                            <a href="{{ route('superAdmin.marketplaceEvents.adminList') }}">
                                <span class="my-link"><i class="fas fa-eye"> View All </i> </span>
                            </a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-6">
                    <div class="info-box mb-3 border border-warning">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content text-center">
                            <span class="info-box-text">Superstar</span>
                            <span class="info-box-number">{{ $superstar }}</span>
                            <a href="{{ route('superAdmin.marketplaceEvents.superstarList') }}">
                                <span class="my-link"><i class="fas fa-eye"> View All </i> </span>
                            </a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!--/. container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <!-- BAR CHART -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Monthly Income</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="barChart"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col (RIGHT) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection


@push('js')
    <script>
        $(function() {

            var labels = <?php echo $months; ?>;
            var data = <?php echo $amountCount; ?>;

            var areaChartData = {
                labels: labels,
                datasets: [{
                    label: 'Revenue',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: data
                }, ]
            }


            //-------------
            //- BAR CHART -
            //-------------
            var barChartCanvas = $('#barChart').get(0).getContext('2d')
            var barChartData = $.extend(true, {}, areaChartData)
            var temp0 = areaChartData.datasets[0]
            barChartData.datasets[0] = temp0

            var barChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                datasetFill: false
            }

            new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: barChartOptions
            })


        })
    </script>
    <script src="{{ asset('assets/manager-admin/plugins/flot/jquery.flot.js') }}"></script>
    <!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
    <script src="{{ asset('assets/manager-admin/plugins/flot/plugins/jquery.flot.resize.js ') }}"></script>
    <script src="{{ asset('assets/manager-admin/plugins/flot/plugins/jquery.flot.hover.js ') }}"></script>
@endpush
