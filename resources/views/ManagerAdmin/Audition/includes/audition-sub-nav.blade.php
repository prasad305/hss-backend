
    <!-- /.content-header -->
    <ul class="nav nav-tabs m-4" role="tablist">
        <li class="nav-item custom-nav-item m-2 TextBH ">
            <a class="nav-link border-warning cart-backg" href="#">
                <center>
                    <div class='displaySide '>
                        <img src="{{ asset('assets/manager-admin/instagram-live.png') }}" class="ARRimg py-4" alt="">
                        <div class='fontBold cart-button'>
                       
                              {{$live}}
                          
                        </div>
                    </div>

                </center>
                <a class="btn border-warning nav-link text-light  @if ($live)
                active
            @endif  "  href="#" >Live Audition</a>
            </a>

        </li>
        <li class="nav-item custom-nav-item m-2 ">
            <a class="nav-link border-warning cart-backg" href="#">
                <center>
                    <div class='displaySide'>
                        <img src="{{ asset('assets/manager-admin/Group1176.png') }}" class="ARRimg py-4" alt="">
                        <div class='fontBold cart-button'>
                            
                            {{$request_approval_pending}}
                       
                    </div>
                    </div>
                </center>
                <a class="btn border-warning nav-link text-light @if ($request_approval_pending)
                active
            @endif " href="#">Request for Approval</a>
            </a>
        </li>
        <li class="nav-item custom-nav-item m-2 ">
            <a class="nav-link border-warning cart-backg" href="#">
                <center class="displaySide">
                    <img src="{{ asset('assets/manager-admin/pending-audition.png') }}" class="ARRimg py-4" alt="">
                    <div class='fontBold cart-button'>
                     
                        {{$pending}}
                    
                    </div>
                </center>
                <a class="btn border-warning nav-link text-light  @if ($pending)
                active
            @endif " href="#">Pending Audition</a>
            </a>
        </li>

    </ul><!-- Tab panes -->
