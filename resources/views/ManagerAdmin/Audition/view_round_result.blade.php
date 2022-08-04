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
                    <img class='w-100 img-fluid' src="{{ asset($audition->banner) }}" alt="">
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
                <section>
                    <div class="title">
                        <div class="text-light d-flex align-item-center p-2 my-3">
                            <h4 class='roundTitle'>Round Result</h4>
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-md-4 d-flex justify-content-center">
                            <div class="cardT">
                                <div class="card__title">{{ count($wining_users) }}<br /> Users</div>
                                <div class="card__footer">selected user from jury result</div>
                            </div>

                        </div>
                        <div class="col-md-4 d-flex justify-content-center">
                            <div class="cardT">
                                <div class="card__title">{{ count($failed_users) }}<br /> Users</div>
                                <div class="card__footer">Unselected user from jury result</div>
                            </div>
                        </div>
                    </div>

                    @if ($round_result->manager_status < 2)
                        <div class="row my-2">
                            <div class="col-md-4 d-flex justify-content-center">
                                <div class="comment">
                                    <textarea name="selected_comments" id="" cols="50" rows="10"></textarea>
                                    <span class="comment__icon"><i class="fa-solid fa-edit"></i></span>
                                </div>
                            </div>
                            <div class="col-md-4 d-flex justify-content-center">
                                <div class="comment">
                                    <textarea name="rejected_comments" id="" cols="50" rows="10"></textarea>
                                    <span class="omment__icon"><i class="fa-solid fa-edit"></i></span>
                                </div>
                            </div>
                        </div>
                    @endif
                </section>

                <section>
                    <div class="d-flex justify-content-center my-4">
                        <button class="btn btnGradient w-50" {{ $round_result->manager_status >= 2 ? 'disabled' : '' }}
                            type="submit">
                            {{ $round_result->manager_status >= 2 ? 'Already Published' : 'Publish For User' }}
                        </button>
                    </div>
                </section>
            </form>
            <button class="btn btnGradient w-50">
                {{ $type }}
            </button>
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
