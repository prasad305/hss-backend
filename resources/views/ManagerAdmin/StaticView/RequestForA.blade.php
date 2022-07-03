
<div class="content">
    <div class="card-header">
        <h3 class="card-title">Request For Approval </h3>
      </div> <br>

    <div class="col-md-3 maxWi">
        <div class="card borderNaC">
            <div class="py-4 d-flex divNav text-center px-3 w-100 justify-content-center align-item-center">
                <div><img src={{ asset('assets/manager-admin/pending.png') }} alt="" width="80"></div>
                <div><h4 class="Penq ">02</h4></div>
            </div>
            <button class="nAvFooter">Pending Audition</button>
        </div>
    </div>
    <br>

    @include('ManagerAdmin.StaticView.NavRound')

    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card p-2"><h5>Round Status</h5> </div>
            </div>
          </div>
        </div>
      </section>

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card p-2">
                <div class="dlfex">
                    <img src={{ asset('assets/manager-admin/Group1176.png') }} width="15" alt="">
                    <b>Request For Approval</b>
                </div>
                <div class="p-3">
                    <h1 class="text-center text-warning " >Audition Title name here</h1>

                    <div class="divClassX my-3">
                        <img class='w-100 img-fluid Mimg' src="{{ asset('/assets/manager-admin/football.png') }}"
                            alt="">

                            <h4 class='boldOverlayX'>1st round time duration JUNE 25 - july 30</h4>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>



</div>
