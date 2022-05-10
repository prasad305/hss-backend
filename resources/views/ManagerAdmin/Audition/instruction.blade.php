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
        {{ $audition->title }}
      </h2>
      <p class="text-light">
       {{$instruction->title}}
      </p>
    </div>
    <div class="bottomLineGold"></div>

    <div class="p-3">
      <h2 class="fw-bold text-center audiHeadTitle my-3">
        {{ $audition->title }} Instructions
      </h2>

      <div class="d-flex px-2 my-1">
        <img height="35px" src={auditionDescriptionIcon} alt="" />
        <p class="text-muted mx-2 descriptionPara">
         {!! $instruction->description !!}
        </p>
      </div>
      
    </div>
    <div class="bottomLineGold"></div>

    <div class="p-3 d-flex justify-content-center">
      <video width="520" controls class="img-fluid">
        <source src="{{ asset($instruction->video) }}" type="video/mp4">
      </video>
    </div>

    <div class="d-flex justify-content-between mediaQueryDiv p-3">
      <div class="startDiv d-flex p-2 my-2">
        <img height="40px" src={flag} alt="" />
        <div class="px-2">
          <span class="text-light">Starts</span>
          <h3 class="text-light fw-bold">{{ date('d F Y',strtotime($audition->start_time)) }}</h3>
        </div>
      </div>
      <div class="endDiv d-flex p-2 my-2">
        <img height="40px" src={ends} alt="" />
        <div class="px-2">
          <span class="text-light">Ends</span>
          <h3 class="text-light fw-bold">{{ date('d F Y',strtotime($audition->end_time)) }}</h3>
        </div>
      </div>
      <div class="bg-dark d-flex p-2 my-2">
        <img height="40px" src={youtube} alt="" />
        <div class="px-2">
          <span class="text-light">User upload slot</span>
          <h3 class="text-light fw-bold">{{ $instruction->num_of_videos }} Video</h3>
        </div>
      </div>

      <div class="startDiv d-flex p-2 my-2">
        <div class="px-2">
          <span class="text-light">Uploade Last Date</span>
          <h3 class="text-light fw-bold">{{ date('d F Y',strtotime($instruction->uploade_date))  }}</h3>
        </div>
      </div>

     
    </div>
    <div class="col-md-4 offset-md-4 mt-5">
      @if ($instruction->status == 2)
       <a href="" class="btn btn-danger">Already Send to Participant</a>
      @endif
      @if ($instruction->status == 1)
      <a href="{{ route('managerAdmin.audition.sendInstruction',$audition->id) }}" class="btn btn-success">Send To All Participant Of This Audition</a>
      @endif
    </div>
  </div>

  @endsection