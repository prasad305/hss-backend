
    <!-- /.content-header -->
    <ul class="nav nav-tabs m-4" role="tablist">
        <li class="nav-item custom-nav-item m-2 TextBH">
            <a class="nav-link border-warning " href="#">
                <center>
                    <div class='displaySide'>
                        <img src="{{ asset('assets/manager-admin/instagram-live.png') }}" class="ARRimg pt-2" alt="">
                        <div class='fontBold'>00</div>
                    </div>

                </center>
                <a class="btn border-warning nav-link active "  href="#" >Live Audition</a>
            </a>

        </li>
        <li class="nav-item custom-nav-item m-2 ">
            <a class="nav-link border-warning" href="#">
                <center>
                    <div class='displaySide'>
                        <img src="{{ asset('assets/manager-admin/Group1176.png') }}" class="ARRimg pt-2" alt="">
                        <div class='fontBold'>{{ $pending_instructions->count() }}</div>
                    </div>
                </center>
                <a class="btn border-warning nav-link " href="#">Request for Approval</a>
            </a>
        </li>
        <li class="nav-item custom-nav-item m-2 ">
            <a class="nav-link border-warning" href="#">
                <center class="displaySide">
                    <img src="{{ asset('assets/manager-admin/pending-audition.png') }}" class="ARRimg pt-2" alt="">
                    <div class='fontBold'>00</div>
                </center>
                <a class="btn border-warning nav-link " href="#">Pending Audition</a>
            </a>
        </li>

    </ul><!-- Tab panes -->
