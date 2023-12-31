<div class="col-12">
    <div class="card">
        <div class="card-body">
            <section>
                <div class="card card-bg head-line mt-4 mb-2 mt-4 mb-2">
                    <div class="text-light d-flex p-2">
                        <h4 class="mx-3 text-white p-2 feed-name">Round Status</h4>
                    </div>
                </div>
                <div>
                    <h5 class="text-muted mt-3">Audition Result</h5>
                </div>
                <div class="underLineWhite"></div>
                <div class="divClass my-3">
                    <img class='w-100 img-fluid' style="max-height: 400px;" src="{{ asset($audition->banner) }}"
                        alt="">
                    <div class='banner__overlay'>
                        <h4 class='boldOverlay'>{{ $round_result->round_num }} round time duration
                            {{ date('d F Y', strtotime($round_result->round_start_date)) }} -
                            {{ date('d F Y', strtotime($round_result->round_end_date)) }}</h4>
                    </div>
                </div>
            </section>

            <section>
                <div class="owl-carousel owl-theme home-demo">
                    @foreach ($round_result->videos as $video)
                        <div class="item">
                            <video width="300" controls>
                                <source src="{{ asset($video->video) }}" type="video/mp4">
                            </video>
                        </div>
                    @endforeach
                </div>
            </section>

            <form action="{{ route('managerAdmin.audition.roundResultPublish') }}" method="POST">
                @csrf
                <input type="hidden" name="audition_id" value="{{ $audition->id }}">
                <input type="hidden" name="round_info_id" value="{{ $round_result->id }}">
                <input type="hidden" name="type" value="{{ $type }}">
                <section>

                    <div class="card card-bg head-line mt-4 mb-2 mt-4 mb-2">
                        <div class="text-light d-flex p-2">
                            <h4 class="mx-3 text-white p-2 feed-name">Round Result</h4>
                        </div>
                    </div>

                    {{-- <div class="row my-2">
                        <div class="col-md-4 d-flex justify-content-center">
                            <div class="cardT">
                                <div class="card__title">{{ count($wining_users) }}<br /> Users</div>
                                <div class="card__footer">selected user result</div>
                            </div>

                        </div>
                        <div class="col-md-4 d-flex justify-content-center">
                            <div class="cardT">
                                <div class="card__title">{{ count($failed_users) }}<br /> Users</div>
                                <div class="card__footer">Unselected user result</div>
                            </div>
                        </div>
                    </div> --}}

                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <div class="card card-bg-event head-line my-2 mt-4 row justify-content-between mx-0">
                                <h3 class="select-name text-center mt-2">selected user result</h3>
                                <h4 class="text-warning text-center">Users</h4>
                                <p class="text-light fw-bold ">
                                <h4 class="text-center"> {{ count($wining_users) }}</h4>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4  ">
                            <div class="card card-bg-event head-line my-2 mt-4 row justify-content-between mx-0">
                                <h3 class="unselect-name text-center mt-2">uselected user result</h3>
                                <h4 class="text-warning text-center "> Users</h4>
                                <p class="text-light fw-bold ">
                                <h4 class="text-center"> {{ count($failed_users) }}</h4>
                                </p>
                            </div>
                        </div>


                    </div>

                    @if ($type == 'general' ? $round_result->manager_status < 2 : $round_result->appeal_manager_status < 2)
                        <div class="row my-2 justify-content-center">
                            <div class="col-md-4 d-flex justify-content-center">
                                <div class="comment">
                                    <textarea name="selected_comments" id="" cols="60" rows="10"></textarea>
                                    <span class="comment__icon"><i class="fa-solid fa-edit"></i></span>
                                </div>
                            </div>
                            <div class="col-md-4 d-flex justify-content-center">
                                <div class="comment">
                                    <textarea name="rejected_comments" id="" cols="60" rows="10"></textarea>
                                    <span class="comment__icon"><i class="fa-solid fa-edit"></i></span>
                                </div>
                            </div>
                        </div>
                    @endif
                </section>

                <section>
                    <div class="d-flex justify-content-center my-4">
                        <button class="btn btnPublish waves-effect fw-bold waves-light mb-2"
                            {{ ($type == 'general' ? $round_result->manager_status >= 2 : $round_result->appeal_manager_status >= 2) ? 'disabled' : '' }}
                            type="submit">
                            {{ ($type == 'general' ? $round_result->manager_status >= 2 : $round_result->appeal_manager_status >= 2) ? 'Already Published' : 'Publish For User' }}
                        </button>
                    </div>
                </section>
            </form>
            {{-- <button class="btn btnGradient w-50">
                {{ $type }}
            </button> --}}
        </div>
    </div>
</div>


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
