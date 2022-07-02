@extends('Layouts.ManagerAdmin.master');


@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">


                            <div class="title">
                                <div class="text-light p-2 my-3">
                                    <h4>Round Status</h4>
                                </div>
                            </div>

                            <div>
                                <h5 class="text-muted">Submitted Account</h5>
                            </div>

                            <div class="underLineWhite"></div>


                            <div class="divClass my-3">
                                <img class='w-100 img-fluid' src="{{ asset('/assets/manager-admin/auditionBanner.png') }}"
                                    alt="">

                                <div class='banner__overlay'>
                                    <h4 class='boldOverlay'>1st round time duration JUNE 25 - july 30</h4>
                                </div>
                            </div>
                            <div class="title">
                                <div class="text-light p-2 my-3">
                                    <h4>Round Status</h4>
                                </div>
                            </div>

                            <div>
                                <h5 class="text-muted">Submitted Wildcard Content</h5>
                            </div>

                            <div class="underLineWhite"></div>


                            <div class="divClass my-3">
                                <img class='w-100 img-fluid' src="{{ asset('/assets/manager-admin/auditionBanner.png') }}"
                                    alt="">

                                <div class='banner__overlay'>
                                    <h4 class='boldOverlay'>1st round time duration JUNE 25 - july 30</h4>
                                </div>
                            </div>

                            <!-- Content Header (Page header) -->
                            <section class="content-header">
                                <div class="container-fluid">
                                    <div class="row mb-2">
                                        <div class="col-sm-6">
                                            <h1>DataTables</h1>
                                        </div>
                                        <div class="col-sm-6">
                                            <ol class="breadcrumb float-sm-right">
                                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                                <li class="breadcrumb-item active">DataTables</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div><!-- /.container-fluid -->
                            </section>

                            <!-- Main content -->
                            <section class="content">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title">DataTable with minimal features & hover style
                                                    </h3>
                                                </div>
                                                <!-- /.card-header -->
                                                <div class="card-body">
                                                    <table id="example2" class="table table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Rendering engine</th>
                                                                <th>Browser</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Trident</td>
                                                                <td>Internet
                                                                    Explorer 4.0
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>Trident</td>
                                                                <td>Internet
                                                                    Explorer 5.0
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>Trident</td>
                                                                <td>Internet
                                                                    Explorer 5.5
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>Trident</td>
                                                                <td>Internet
                                                                    Explorer 6
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>Trident</td>
                                                                <td>Internet Explorer 7</td>

                                                            </tr>
                                                            <tr>
                                                                <td>Trident</td>
                                                                <td>AOL browser (AOL desktop)</td>

                                                            </tr>
                                                            <tr>
                                                                <td>Gecko</td>
                                                                <td>Firefox 1.0</td>

                                                            </tr>
                                                            <tr>
                                                                <td>Gecko</td>
                                                                <td>Firefox 1.5</td>

                                                            </tr>
                                                            <tr>
                                                                <td>Gecko</td>
                                                                <td>Firefox 2.0</td>

                                                            </tr>
                                                            <tr>
                                                                <td>Gecko</td>
                                                                <td>Firefox 3.0</td>
                                                                <td>Win 2k+ / OSX.3+</td>
                                                                <td>1.9</td>
                                                                <td>A</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Gecko</td>
                                                                <td>Camino 1.0</td>
                                                                <td>OSX.2+</td>
                                                                <td>1.8</td>
                                                                <td>A</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Gecko</td>
                                                                <td>Camino 1.5</td>

                                                            </tr>
                                                            <tr>
                                                                <td>Gecko</td>
                                                                <td>Netscape 7.2</td>

                                                            </tr>
                                                            <tr>
                                                                <td>Gecko</td>
                                                                <td>Netscape Browser 8</td>

                                                            </tr>
                                                            <tr>
                                                                <td>Gecko</td>
                                                                <td>Netscape Navigator 9</td>

                                                            </tr>
                                                            <tr>
                                                                <td>Gecko</td>
                                                                <td>Mozilla 1.0</td>

                                                            </tr>
                                                            <tr>
                                                                <td>Gecko</td>
                                                                <td>Mozilla 1.1</td>

                                                            </tr>
                                                            <tr>
                                                                <td>Gecko</td>
                                                                <td>Mozilla 1.2</td>

                                                            </tr>
                                                            <tr>
                                                                <td>Gecko</td>
                                                                <td>Mozilla 1.3</td>

                                                            </tr>
                                                            <tr>
                                                                <td>Gecko</td>
                                                                <td>Mozilla 1.4</td>

                                                            </tr>
                                                            <tr>
                                                                <td>Gecko</td>
                                                                <td>Mozilla 1.5</td>

                                                            </tr>
                                                            <tr>
                                                                <td>Gecko</td>
                                                                <td>Mozilla 1.6</td>

                                                            </tr>
                                                            <tr>
                                                                <td>Gecko</td>
                                                                <td>Mozilla 1.7</td>

                                                            </tr>
                                                            <tr>
                                                                <td>Gecko</td>
                                                                <td>Mozilla 1.8</td>

                                                            </tr>
                                                            <tr>
                                                                <td>Gecko</td>
                                                                <td>Seamonkey 1.1</td>

                                                            </tr>
                                                            <tr>
                                                                <td>Gecko</td>
                                                                <td>Epiphany 2.20</td>

                                                            </tr>
                                                            <tr>
                                                                <td>Webkit</td>
                                                                <td>Safari 1.2</td>

                                                            </tr>
                                                            <tr>
                                                                <td>Webkit</td>
                                                                <td>Safari 1.3</td>

                                                            </tr>
                                                            <tr>
                                                                <td>Webkit</td>
                                                                <td>Safari 2.0</td>

                                                            </tr>
                                                            <tr>
                                                                <td>Webkit</td>
                                                                <td>Safari 3.0</td>

                                                            </tr>
                                                            <tr>
                                                                <td>Webkit</td>
                                                                <td>OmniWeb 5.5</td>

                                                            </tr>
                                                            <tr>
                                                                <td>Webkit</td>
                                                                <td>iPod Touch / iPhone</td>


                                                            </tr>
                                                            <tr>
                                                                <td>Webkit</td>
                                                                <td>S60</td>

                                                            </tr>
                                                            <tr>
                                                                <td>Presto</td>
                                                                <td>Opera 7.0</td>

                                                            </tr>
                                                            <tr>
                                                                <td>Presto</td>
                                                                <td>Opera 7.5</td>

                                                            </tr>
                                                            <tr>
                                                                <td>Presto</td>
                                                                <td>Opera 8.0</td>

                                                            </tr>
                                                            <tr>
                                                                <td>Presto</td>
                                                                <td>Opera 8.5</td>
                                                                <td>Win 95+ / OSX.2+</td>
                                                                <td>-</td>
                                                                <td>A</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Presto</td>
                                                                <td>Opera 9.0</td>
                                                                <td>Win 95+ / OSX.3+</td>
                                                                <td>-</td>
                                                                <td>A</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Presto</td>
                                                                <td>Opera 9.2</td>
                                                                <td>Win 88+ / OSX.3+</td>
                                                                <td>-</td>
                                                                <td>A</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Presto</td>
                                                                <td>Opera 9.5</td>
                                                                <td>Win 88+ / OSX.3+</td>
                                                                <td>-</td>
                                                                <td>A</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Presto</td>
                                                                <td>Opera for Wii</td>
                                                                <td>Wii</td>
                                                                <td>-</td>
                                                                <td>A</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Presto</td>
                                                                <td>Nokia N800</td>
                                                                <td>N800</td>
                                                                <td>-</td>
                                                                <td>A</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Presto</td>
                                                                <td>Nintendo DS browser</td>
                                                                <td>Nintendo DS</td>
                                                                <td>8.5</td>
                                                                <td>C/A<sup>1</sup></td>
                                                            </tr>
                                                            <tr>
                                                                <td>KHTML</td>
                                                                <td>Konqureror 3.1</td>

                                                            </tr>
                                                            <tr>
                                                                <td>KHTML</td>
                                                                <td>Konqureror 3.3</td>

                                                            </tr>
                                                            <tr>
                                                                <td>KHTML</td>
                                                                <td>Konqureror 3.5</td>

                                                            </tr>
                                                            <tr>
                                                                <td>Tasman</td>
                                                                <td>Internet Explorer 4.5</td>

                                                            </tr>
                                                            <tr>
                                                                <td>Tasman</td>
                                                                <td>Internet Explorer 5.1</td>

                                                            </tr>
                                                            <tr>
                                                                <td>Tasman</td>
                                                                <td>Internet Explorer 5.2</td>

                                                            </tr>
                                                            <tr>
                                                                <td>Misc</td>
                                                                <td>NetFront 3.1</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Misc</td>
                                                                <td>NetFront 3.4</td>

                                                            </tr>
                                                            <tr>
                                                                <td>Misc</td>
                                                                <td>Dillo 0.8</td>

                                                            </tr>
                                                            <tr>
                                                                <td>Misc</td>
                                                                <td>Links</td>

                                                            </tr>
                                                            <tr>
                                                                <td>Misc</td>
                                                                <td>Lynx</td>

                                                            </tr>
                                                            <tr>
                                                                <td>Misc</td>
                                                                <td>IE Mobile</td>

                                                            </tr>
                                                            <tr>
                                                                <td>Misc</td>
                                                                <td>PSP browser</td>

                                                            </tr>
                                                            <tr>
                                                                <td>Other browsers</td>
                                                                <td>All others</td>

                                                            </tr>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th>Rendering engine</th>
                                                                <th>Browser</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                            <!-- /.card -->


                                            <!-- /.card -->
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!-- /.row -->
                                </div>
                                <!-- /.container-fluid -->
                            </section>
                            <!-- /.content -->


                        </div>



                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
