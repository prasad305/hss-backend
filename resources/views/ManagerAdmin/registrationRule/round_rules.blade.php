<form action="{{route('managerAdmin.audition.registration.round.update',$round->id)}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="audition__rules__final__time d-flex flex-row justify-content-center my-4">
        <img src="{{asset('assets/manager-admin/table.png')}}" class="img-fluid" alt="calender">
        <p class="text-capitalize" >{{ date('d M Y',strtotime($round->start_date)) }} To {{ date('d M Y',strtotime($round->end_date)) }}</p>
    </div>

    <div class="audition__rule__time d-flex flex-column">
        <p>Post Requirement Before Started Rounds</p>
        <div class="audition__rule__time__item d-flex flex-row my-1 justify-content-between">
            <div class="d-flex flex-row">
                
                <p class="audition__rule__time__item__user">Uploaded Videos Time Duration</p>
            </div>
            <div class="d-flex flex-row mr-4">
                <input type="text" class="form-control"  name="video_duration" value="{{$round->video_duration}}">
            </div>
        </div>

        <div class="audition__rule__time__item d-flex flex-row my-1 justify-content-between">
            <div class="d-flex flex-row">
                
                <p class="audition__rule__time__item__user">Jury Video checking and marking Time Period</p>
            </div>
            <div class="d-flex flex-row mr-4">
                <input type="date" 
                    value="{{$round->jury_marking_start_date != null ? date('Y-m-d',strtotime($round->jury_marking_start_date)) : ''}}"
                    name="jury_marking_start_date" className='form-control'
                    min="{{\Carbon\Carbon::parse($round->start_date)->format('Y-m-d')}}"
                    max="{{\Carbon\Carbon::parse($round->end_date)->format('Y-m-d')}}">
                <span>To</span>
                <input type="date" 
                    value="{{$round->jury_marking_end_date != null ? date('Y-m-d',strtotime($round->jury_marking_end_date)) : ''}}"
                    name="jury_marking_end_date" className='form-control'
                    min="{{\Carbon\Carbon::parse($round->start_date)->format('Y-m-d')}}"
                    max="{{\Carbon\Carbon::parse($round->end_date)->format('Y-m-d')}}">
            </div>
        </div>

        <div class="audition__rule__time__item d-flex flex-row my-1 justify-content-between">
            <div class="d-flex flex-row">
                <p class="audition__rule__time__item__user">Star/Judge Marking Time Period</p>
            </div>
            <div class="d-flex flex-row mr-4">
                <input type="date" 
                    value="{{$round->judge_marking_start_date != null ? date('Y-m-d',strtotime($round->judge_marking_start_date)) : ''}}"
                    name="judge_marking_start_date" className='form-control'
                    min="{{\Carbon\Carbon::parse($round->start_date)->format('Y-m-d')}}"
                    max="{{\Carbon\Carbon::parse($round->end_date)->format('Y-m-d')}}">
                <span>To</span>
                <input type="date" 
                    value="{{$round->judge_marking_end_date != null ? date('Y-m-d',strtotime($round->judge_marking_end_date)) : ''}}"
                    name="judge_marking_end_date" className='form-control'
                    min="{{\Carbon\Carbon::parse($round->start_date)->format('Y-m-d')}}"
                    max="{{\Carbon\Carbon::parse($round->end_date)->format('Y-m-d')}}">
            </div>
        </div>

        <div class="audition__rule__time__item d-flex flex-row my-1 justify-content-between">
            <div class="d-flex flex-row">
                
                <p class="audition__rule__time__item__user">Applied Video Time Duration</p>
            </div>
            <div class="d-flex flex-row mr-4">
                <input type="date" 
                    value="{{$round->appeal_start_date != null ? date('Y-m-d',strtotime($round->appeal_start_date)) : ''}}"
                    name="appeal_start_date" className='form-control'
                    min="{{\Carbon\Carbon::parse($round->start_date)->format('Y-m-d')}}"
                    max="{{\Carbon\Carbon::parse($round->end_date)->format('Y-m-d')}}">
                <span>To</span>
                <input type="date" 
                    value="{{$round->appeal_end_date != null ? date('Y-m-d',strtotime($round->appeal_end_date)) : ''}}"
                    name="appeal_end_date" className='form-control'
                    min="{{\Carbon\Carbon::parse($round->start_date)->format('Y-m-d')}}"
                    max="{{\Carbon\Carbon::parse($round->end_date)->format('Y-m-d')}}">
            </div>
        </div>

        <div class="audition__rule__time__item d-flex flex-row my-1 justify-content-between">
            <div class="d-flex flex-row">
                
                <p class="audition__rule__time__item__user">Result Publish Date</p>
            </div>
            <div class="d-flex flex-row mr-4">
                <input type="date" 
                    value="{{$round->result_published_date != null ? date('Y-m-d',strtotime($round->result_published_date)) : ''}}"
                    name="result_published_date" className='form-control'
                    min="{{\Carbon\Carbon::parse($round->start_date)->format('Y-m-d')}}"
                    max="{{\Carbon\Carbon::parse($round->end_date)->format('Y-m-d')}}">
            </div>
        </div>

        <div class="audition__rule__time__item d-flex flex-row my-1 justify-content-between">
            <div class="d-flex flex-row">
                
                <p class="audition__rule__time__item__user">Applied Video Result Publish Date</p>
            </div>
            <div class="d-flex flex-row mr-4">
                <input type="date" 
                    value="{{$round->appeal_result_date != null ? date('Y-m-d',strtotime($round->appeal_result_date)) : ''}}"
                    name="appeal_result_date" className='form-control'
                    min="{{\Carbon\Carbon::parse($round->start_date)->format('Y-m-d')}}"
                    max="{{\Carbon\Carbon::parse($round->end_date)->format('Y-m-d')}}">
            </div>
        </div>

        <div class="my-4 text-right mr-4">
            <button class="btn bg-info px-5" id="SubmitRules">Update</button>
        </div>
    </div>
</form>