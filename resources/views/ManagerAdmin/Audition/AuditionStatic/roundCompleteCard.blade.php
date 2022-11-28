@extends('Layouts.ManagerAdmin.master');


@section('content')
    <!-- Main content -->

    <section class="content">
        <div class="container-fluid">

            <body>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body">


                                <section>
                                    <div>
                                        <h5 class="text-muted">Submitted Account</h5>
                                    </div>

                                    <div class="underLineWhite"></div>



                                    <div class="divClass my-3">
                                        <img class='w-100 img-fluid'
                                            src="{{ asset('/assets/manager-admin/auditionBanner.png') }}" alt="">
                                    </div>
                                </section>

                                <section class='borderWarning'>
                                    <div class="my-3 d-flex justify-content-center">
                                        <img class='img-fluid'
                                            src="{{ asset('/assets/manager-admin/roundComplete.png') }}" alt="">
                                    </div>
                                    <div class=" d-flex justify-content-center round align-items-center completeRoundMsg">
                                        <h1 class="roundOneText">Round 01 Complete</h1>
                                    </div>
                                    <div class="my-5 d-flex justify-content-center">
                                        <button class="w-50 btn bgWarning">
                                            Go To The Next Round
                                        </button>
                                    </div>
                                </section>


                            </div>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>

            </body>

            <!-- /.col -->
        </div>


        <!-- /.row -->
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
