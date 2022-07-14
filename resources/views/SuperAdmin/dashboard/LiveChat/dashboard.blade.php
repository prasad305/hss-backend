@extends('Layouts.SuperAdmin.master')
@push('title')
    Super Admin
@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Live Chat Events Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Live Chat Events</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="content">

        <div class="container-fluid">

            <div class="row">
                <div class="col-12 col-sm-6 col-md-12">
                    <div class="info-box text-center">
                        <div class="info-box-content">
                            <span class="info-box-text text-warning">Categories</span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3 text-center border border-warning">
                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-list-alt"
                                aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Sports</span>
                            <span class="info-box-number">410</span>
                            <span class="info-box-number">
                                <small><a class="text-warning" href="#">See
                                        All</a></small>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3 text-center border border-warning">
                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-list-alt"
                                aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Music</span>
                            <span class="info-box-number">410</span>
                            <span class="info-box-number">
                                <small><a class="text-warning" href="#">See
                                        All</a></small>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3 text-center border border-warning">
                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-list-alt"
                                aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Tech</span>
                            <span class="info-box-number">410</span>
                            <span class="info-box-number">
                                <small><a class="text-warning" href="#">See
                                        All</a></small>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3 text-center border border-warning">
                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-list-alt"
                                aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Drama</span>
                            <span class="info-box-number">410</span>
                            <span class="info-box-number">
                                <small><a class="text-warning" href="#">See
                                        All</a></small>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content">

        <div class="container-fluid">

            <div class="row">
                <div class="col-12 col-sm-6 col-md-12">
                    <div class="info-box text-center">
                        <div class="info-box-content">
                            <span class="info-box-text text-warning">Events</span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3 text-center border border-warning">
                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-list-alt"
                                aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total</span>
                            <span class="info-box-number">410</span>
                            <span class="info-box-number">
                                <small><a class="text-warning" href="#">See
                                        All</a></small>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3 text-center border border-warning">
                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-list-alt"
                                aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Pending</span>
                            <span class="info-box-number">410</span>
                            <span class="info-box-number">
                                <small><a class="text-warning" href="#">See
                                        All</a></small>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3 text-center border border-warning">
                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-list-alt"
                                aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Runing</span>
                            <span class="info-box-number">410</span>
                            <span class="info-box-number">
                                <small><a class="text-warning" href="#">See
                                        All</a></small>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3 text-center border border-warning">
                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-list-alt"
                                aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Completed</span>
                            <span class="info-box-number">410</span>
                            <span class="info-box-number">
                                <small><a class="text-warning" href="#">See
                                        All</a></small>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content">

        <div class="container-fluid">

            <div class="row">
                <div class="col-12 col-sm-6 col-md-12">
                    <div class="info-box text-center">
                        <div class="info-box-content">
                            <span class="info-box-text text-warning">Admin & Superstars</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3 text-center border border-warning">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fa fa-users"
                                aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Manager Admin</span>
                            <span class="info-box-number">410</span>
                            <span class="info-box-number">
                                <small><a class="text-warning"
                                        href="{{ route('superAdmin.liveChatEvents.managerAdminList') }}">See
                                        All</a></small>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3 text-center border border-warning">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fa fa-users"
                                aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Superstar Admin</span>
                            <span class="info-box-number">410</span>
                            <span class="info-box-number">
                                <small><a class="text-warning"
                                        href="{{ route('superAdmin.liveChatEvents.adminList') }}">See
                                        All</a></small>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3 text-center border border-warning">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fa fa-users"
                                aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Superstars</span>
                            <span class="info-box-number">410</span>
                            <span class="info-box-number">
                                <small><a class="text-warning"
                                        href="{{ route('superAdmin.liveChatEvents.superstarList') }}">See
                                        All</a></small>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content">

        <div class="container-fluid">

            <div class="row">
                <div class="col-12 col-sm-6 col-md-12">
                    <div class="info-box text-center">
                        <div class="info-box-content">
                            <span class="info-box-text text-warning"> Revenue </span>
                        </div>
                    </div>
                </div>
            </div>





            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-title">Chart</h3>
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
                                        <div class="chartjs-size-monitor">
                                            <div class="chartjs-size-monitor-expand">
                                                <div class=""></div>
                                            </div>
                                            <div class="chartjs-size-monitor-shrink">
                                                <div class=""></div>
                                            </div>
                                        </div>
                                        <canvas id="stackedBarChart"
                                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 402px;"
                                            width="402" height="250" class="chartjs-render-monitor"></canvas>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-title">Chart</h3>
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
                                        <div class="chartjs-size-monitor">
                                            <div class="chartjs-size-monitor-expand">
                                                <div class=""></div>
                                            </div>
                                            <div class="chartjs-size-monitor-shrink">
                                                <div class=""></div>
                                            </div>
                                        </div>
                                        <canvas id="barChart"
                                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 380px;"
                                            width="380" height="250" class="chartjs-render-monitor"></canvas>
                                    </div>
                                </div>

                            </div>


                        </div>

                    </div>

                </div>
            </section>
        </div>
    </div>
@endsection


@push('js')
    <script>
        $(function() {
            /* ChartJS
             * -------
             * Here we will create a few charts using ChartJS
             */

            //--------------
            //- AREA CHART -
            //--------------

            var areaChartData = {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                datasets: [{
                        label: 'Digital Goods',
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: [28, 48, 40, 19, 86, 27, 90]
                    },
                    {
                        label: 'Electronics',
                        backgroundColor: 'rgba(210, 214, 222, 1)',
                        borderColor: 'rgba(210, 214, 222, 1)',
                        pointRadius: false,
                        pointColor: 'rgba(210, 214, 222, 1)',
                        pointStrokeColor: '#c1c7d1',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data: [65, 59, 80, 81, 56, 55, 40]
                    },
                ]
            }


            //-------------
            //- BAR CHART -
            //-------------
            var barChartCanvas = $('#barChart').get(0).getContext('2d')
            var barChartData = $.extend(true, {}, areaChartData)
            var temp0 = areaChartData.datasets[0]
            var temp1 = areaChartData.datasets[1]
            barChartData.datasets[0] = temp1
            barChartData.datasets[1] = temp0

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

            //---------------------
            //- STACKED BAR CHART -
            //---------------------
            var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
            var stackedBarChartData = $.extend(true, {}, barChartData)

            var stackedBarChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        stacked: true,
                    }],
                    yAxes: [{
                        stacked: true
                    }]
                }
            }

            new Chart(stackedBarChartCanvas, {
                type: 'bar',
                data: stackedBarChartData,
                options: stackedBarChartOptions
            })
        })
    </script>
    <script src="{{ asset('assets/super-admin/plugins/flot/jquery.flot.js') }}"></script>
    <!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
    <script src="{{ asset('assets/super-admin/plugins/flot/plugins/jquery.flot.resize.js ') }}"></script>
    <script src="{{ asset('assets/super-admin/plugins/flot/plugins/jquery.flot.hover.js ') }}"></script>
    <script src="{{ asset('assets/super-admin/plugins/chart.js/Chart.min.js') }}"></script>
@endpush
