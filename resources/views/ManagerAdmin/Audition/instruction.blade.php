@extends('Layouts.ManagerAdmin.master')

@push('title')
Manager Admin
@endpush

@section('content')
<style>
    .auditionDes {
  background-color: #1b1b1b;
}

.titleInstruction {
  color: #cc8a00;
  font-size: 25px;
}

.bottomLineGold {
  border-bottom: 1px solid black;
}

.audiHeadTitle {
  color: #efc100;
  font-weight: 800 !important;
}

.startDiv {
  background-color: #2a5587;
  border-radius: 10px;
}

.endDiv {
  background-color: #8d7a16;
  border-radius: 10px;
}

@media only screen and (max-width: 600px) {
  .mediaQueryDiv {
    display: flex !important;
    flex-direction: column !important;
  }
}
</style>
<div class="auditionDes">
    <div class="p-3">
      <p class="titleInstruction">Audition Instruction</p>
    </div>
    <div class="bottomLineGold"></div>
    <div class="p-3">
      <h2 class="fw-bold text-center audiHeadTitle mb-3">
        Guitar Audition Description
      </h2>
      <p class="text-light">
        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ab atque
        aperiam incidunt voluptate porro odit voluptas earum repellat eius
        eaque voluptatum asperiores ex nihil perspiciatis quis esse recusandae
        ratione aliquid ullam laudantium, eveniet et perferendis ipsa?
        Provident perspiciatis omnis rem!
      </p>
    </div>
    <div class="bottomLineGold"></div>

    <div class="p-3">
      <h2 class="fw-bold text-center audiHeadTitle my-3">
        Guitar Audition Instructions
      </h2>

      <div class="d-flex px-2 my-1">
        <img height="35px" src={auditionDescriptionIcon} alt="" />
        <p class="text-muted mx-2 descriptionPara">
          Your updated video must be upto 480P
        </p>
      </div>
      <div class="d-flex px-2 my-1">
        <img height="35px" src={auditionDescriptionIcon} alt="" />
        <p class="text-muted mx-2 descriptionPara">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda
          esse est reiciendis accusamus voluptas temporibus libero natus
          itaque aut quod?
        </p>
      </div>
      <div class="d-flex px-2 my-1">
        <img height="35px" src={auditionDescriptionIcon} alt="" />
        <p class="text-muted mx-2 descriptionPara">
          Lorem, ipsum dolor sit amet consectetur adipisicing elit. Laboriosam
          sit itaque quibusdam doloribus in quaerat.
        </p>
      </div>
      <div class="d-flex px-2 my-1">
        <img height="35px" src={auditionDescriptionIcon} alt="" />
        <p class="text-muted mx-2 descriptionPara">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Quibusdam,
          tempora.
        </p>
      </div>
      <div class="d-flex px-2 my-1">
        <img height="35px" src={auditionDescriptionIcon} alt="" />
        <p class="text-muted mx-2 descriptionPara">
          Lorem, ipsum dolor sit amet consectetur adipisicing elit. Provident?
        </p>
      </div>
      <div class="d-flex px-2 my-1">
        <img height="35px" src={auditionDescriptionIcon} alt="" />
        <p class="text-muted mx-2 descriptionPara">
          Lorem, ipsum dolor sit amet consectetur adipisicing elit.
        </p>
      </div>
    </div>
    <div class="bottomLineGold"></div>

    <div class="p-3 d-flex justify-content-center">
      <video width="520" controls class="img-fluid">
        <source src="https://www.youtube.com/watch?v=3WfVm-ih4BA&ab_channel=NotoutNoman" type="video/mp4">
      </video>
    </div>

    <div class="d-flex justify-content-between mediaQueryDiv p-3">
      <div class="startDiv d-flex p-2 my-2">
        <img height="40px" src={flag} alt="" />
        <div class="px-2">
          <span class="text-light">Starts</span>
          <h3 class="text-light fw-bold">2 April 2022</h3>
        </div>
      </div>
      <div class="endDiv d-flex p-2 my-2">
        <img height="40px" src={ends} alt="" />
        <div class="px-2">
          <span class="text-light">Ends</span>
          <h3 class="text-light fw-bold">16 April 2022</h3>
        </div>
      </div>
      <div class="startDiv d-flex p-2 my-2">
        <img height="40px" src={youtube} alt="" />
        <div class="px-2">
          <span class="text-light">User upload slot</span>
          <h3 class="text-light fw-bold">4 Video</h3>
        </div>
      </div>
    </div>
  </div>

  @endsection