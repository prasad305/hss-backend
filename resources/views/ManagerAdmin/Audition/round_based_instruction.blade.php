<form action="{{route('managerAdmin.audition.roundInstruction.published',$round_instruction->id)}}" method="post">
   @csrf
<div class="col-md-10 offset-md-1">
      <div class="row">
         @if ($round_instruction->image != null)
         <img src="{{ asset($round_instruction->image) }}" style="width: 100%" class="banner-image" />
         @endif
      </div>
      
      <div class="row">
         <video controls>
            <source src="{{asset($round_instruction->video)}}" />
         </video>
      </div>
      
      
      <div class="row py-5">
         <div class="col-md-8 ">
            <div class="row card p-5">
               <u>Instruction</u>
               <p>
                  {!! $round_instruction->instruction !!}
               </p>
            </div>
      
      
         </div>
      </div>
   </div>
   @if ($round_instruction->send_to_user == 0)
   <button  class="btn btn-success">Publish Round Instruction</button>
   @else
   <a class="btn btn-warning text-light">Already Published This Round</a>
   @endif


</form>