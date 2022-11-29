@extends('Layouts.ManagerAdmin.master');


@section('content')
    <!-- Main content -->

    <section class="content">
        <div class="container-fluid">

            <body>
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-body">


                                <section>
                                    <div class="title">
                                        <div class="text-light p-2 my-3">
                                            <h4 class="roundTitle">Round Status</h4>
                                        </div>
                                    </div>

                                    <div>
                                        <h5 class="text-muted">Submitted Account</h5>
                                    </div>

                                    <div class="underLineWhite"></div>


                                    <div class="divClass my-3">
                                        <img class='w-100 img-fluid'
                                            src="{{ asset('/assets/manager-admin/auditionBanner.png') }}" alt="">

                                        <div class='banner__overlay'>
                                            <h4 class='boldOverlay'>1st round time duration JUNE 25 - july 30</h4>
                                        </div>
                                    </div>
                                </section>


                                <section>
                                    <div class="owl-carousel owl-theme home-demo">
                                        <div class="item">
                                            <video width="300" controls>
                                                <source src="mov_bbb.mp4" type="video/mp4">
                                                <source src="mov_bbb.ogg" type="video/ogg">
                                                Your browser does not support HTML video.
                                            </video>
                                        </div>
                                        <div class="item">
                                            <video width="300" controls>
                                                <source src="mov_bbb.mp4" type="video/mp4">
                                                <source src="mov_bbb.ogg" type="video/ogg">
                                                Your browser does not support HTML video.
                                            </video>
                                        </div>
                                        <div class="item">
                                            <video width="300" controls>
                                                <source src="mov_bbb.mp4" type="video/mp4">
                                                <source src="mov_bbb.ogg" type="video/ogg">
                                                Your browser does not support HTML video.
                                            </video>
                                        </div>
                                        <div class="item">
                                            <video width="300" controls>
                                                <source src="mov_bbb.mp4" type="video/mp4">
                                                <source src="mov_bbb.ogg" type="video/ogg">
                                                Your browser does not support HTML video.
                                            </video>
                                        </div>
                                        <div class="item">
                                            <video width="300" controls>
                                                <source src="mov_bbb.mp4" type="video/mp4">
                                                <source src="mov_bbb.ogg" type="video/ogg">
                                                Your browser does not support HTML video.
                                            </video>
                                        </div>
                                        <div class="item">
                                            <video width="300" controls>
                                                <source src="mov_bbb.mp4" type="video/mp4">
                                                <source src="mov_bbb.ogg" type="video/ogg">
                                                Your browser does not support HTML video.
                                            </video>
                                        </div>
                                        <div class="item">
                                            <video width="300" controls>
                                                <source src="mov_bbb.mp4" type="video/mp4">
                                                <source src="mov_bbb.ogg" type="video/ogg">
                                                Your browser does not support HTML video.
                                            </video>
                                        </div>
                                        <div class="item">
                                            <video width="300" controls>
                                                <source src="mov_bbb.mp4" type="video/mp4">
                                                <source src="mov_bbb.ogg" type="video/ogg">
                                                Your browser does not support HTML video.
                                            </video>
                                        </div>
                                        <div class="item">
                                            <video width="300" controls>
                                                <source src="mov_bbb.mp4" type="video/mp4">
                                                <source src="mov_bbb.ogg" type="video/ogg">
                                                Your browser does not support HTML video.
                                            </video>
                                        </div>
                                        <div class="item">
                                            <video width="300" controls>
                                                <source src="mov_bbb.mp4" type="video/mp4">
                                                <source src="mov_bbb.ogg" type="video/ogg">
                                                Your browser does not support HTML video.
                                            </video>
                                        </div>
                                        <div class="item">
                                            <video width="300" controls>
                                                <source src="mov_bbb.mp4" type="video/mp4">
                                                <source src="mov_bbb.ogg" type="video/ogg">
                                                Your browser does not support HTML video.
                                            </video>
                                        </div>
                                    </div>
                                </section>

                                <section>
                                    <div class="title">
                                        <div class="text-light d-flex align-item-center p-2 my-3">
                                            <h4 class='roundTitle'>Round Status</h4>
                                        </div>
                                    </div>


                                    <div class="row my-2">
                                        <div class="col-md-4 d-flex justify-content-center">
                                            <div class="cardT">
                                                <div class="card__title">30<br /> Videos</div>
                                                <div class="card__footer">selected user from jury result</div>
                                            </div>

                                        </div>
                                        <div class="col-md-4 d-flex justify-content-center">
                                            <div class="cardT">
                                                <div class="card__title">30<br /> Videos</div>
                                                <div class="card__footer">selected user from jury result</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 d-flex justify-content-center">
                                            <div class="cardT">
                                                <div class="card__title">30<br /> Videos</div>
                                                <div class="card__footer">selected user from jury result</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row my-2">
                                        <div class="col-md-4 d-flex justify-content-center">

                                        </div>
                                        <div class="col-md-4 d-flex justify-content-center">
                                            <div class="comment">
                                                <p>Comment: Congratulations you are selected for the next round</p>
                                                <span class="comment__icon"><i class="fa-solid fa-edit"></i></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 d-flex justify-content-center">
                                            <div class="comment">
                                                <p>Comment: Congratulations you are selected for the next round</p>
                                                <span class="omment__icon"><i class="fa-solid fa-edit"></i></span>
                                            </div>
                                        </div>
                                    </div>



                                </section>

                                <section>
                                    <div class="d-flex justify-content-center my-4">
                                        <button class="btn btnGradient w-50">
                                            Publish fro web
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
        integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
        $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 5
                }
            }
        })
    </script>
@endsection
