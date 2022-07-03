@extends('Layouts.ManagerAdmin.master')

@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h6>Post making Instraction Approval</h6>
            <hr class="bg-light">
          </div>
        </div>
      </div>

    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body card-border">


                <h6 class="audition-txt d-flex  justify-content-center  ">AUDITION TITLE NAME HERE</h6>

               <div class="ImBanner">
                <img class="img-fluid banner-1" src="{{ asset('assets/manager-admin/frame1/guiter.png') }}" alt="description of myimage">
                <h4 class="crnye">Registration Date JUNE 25 - july 30 </h4>
               </div>

                <div class="d-flex justify-content-center align-items-center  mt-3  three-star">
                    <div>  <img class="img-fluid py-3" src="{{ asset('assets/manager-admin/frame1/nobel.png') }}" alt=""></div>

                    <div> <img class="img-fluid py-3" src="{{ asset('assets/manager-admin/frame1/momtaz.png') }}" alt=""></div>

                    <div> <img class="img-fluid py-3" src="{{ asset('assets/manager-admin/frame1/protik.png') }}" alt=""></div>
                </div>

                <h4 class="mt-4 text-warning">Audition Post Discription</h4>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum fuga modi voluptates necessitatibus quam eum sunt inventore ea itaque vitae? Similique, voluptatibus hic obcaecati reprehenderit voluptatem cum debitis veniam quae sed itaque quod, libero porro nisi. Facilis ex ad minima iure atque asperiores in est quo aliquid doloribus sit cumque aspernatur officia recusandae exercitationem, deserunt blanditiis, eligendi officiis consectetur inventore? Accusantium sint repudiandae asperiores doloremque deserunt quasi voluptatum molestiae atque magnam suscipit culpa officia velit modi reprehenderit, nihil, neque eos quisquam eius earum in labore rerum. Eligendi consectetur, atque corporis debitis assumenda velit, dignissimos ab cumque culpa quisquam laboriosam doloribus!</p>

                <div class="d-flex justify-content-between mt-4">
                    <h4 class="text-warning">Audition Registration Fees</h4>
                    <h2 class="font-weight-bold">$250</h2>
                </div>

                <div class="d-flex justify-content-center mt-5  ">
                    <button type="button" class="btn text-light btn-1 font-weight-bold px-5 ">Edit</button>
                    <button type="button" class="btn mx-5  text-light font-weight-bold   btn-1" data-toggle="modal" data-target="#myModal">Publish For Web</button>




                    {{-- <div class="modal fade center" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">

                                <div class="d-flex justify-content-center"><p class="loader "></p></div>
                                
                                <h2 class="text-warning text-center">Post Conter For User SuccesfullyPublish!!</h2>

                                
                            </div>
                            <div class="modal-footer">
                              
                              <button type="button" class="btn btn-primary">OK</button>
                            </div>
                          </div>
                        </div>
                      </div>

                   
                   
                </div> --}}



                <div class="modal fade" id="myModal">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                      
                        <!-- Modal Header -->
                        <div class="modal-header">
                          
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="d-flex justify-content-center"><p class="loader "></p></div>
                                
                            <h2 class="text-warning text-center">Post Conter For User SuccesfullyPublish!!</h2>
                        </div>
                        
                        <!-- Modal footer -->
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
                        </div>
                        
                      </div>
                    </div>
                  </div>
                  
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



