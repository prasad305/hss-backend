@extends('Layouts.ManagerAdmin.master')

@push('title')
Admin
@endpush

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Admin</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Admin List</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="content">

    <div class="container-fluid">




    </div> <!-- container -->
</div> <!-- content -->

<div class="content">

    <div class="container-fluid">

        <div class="row float-right">

        </div>





    </div>
    <hr>
    <h4 class="mb-2">Schedule List</h4>
    <form action="{{route('managerAdmin.schedule.update_all',$admin->id)}}" method="post">
        @csrf
        <div class="row mb-3">

            <div class="col-md-2 offset-md-4">
                <input type="text" id="set_reminder" name="set_reminder" class="form-control float-left" placeholder="set all reminder by day">
                @error('set_reminder')
                <span class="text-danger">{{$message}}</span>
                @enderror
                   
            </div>
            <div class="col-md-4">
                <button class="btn btn-md btn-success">Set</button>
            </div>
        </div>
    </form>
    <div class="row">
        @foreach ($schedulesOrderByDate as $key => $schedules)
        <div class="col-md-3">
            <div class="sticky-top mb-3">


                <div class="card">
                    <div class="card-header bg-primary">
                        <h4 class="card-title">{{ $key }}</h4>
                    </div>
                    <div class="card-body">
                        <!-- the events -->
                        @foreach ($schedules as $schedule)
                        <div id="external-events">
                            <div class="external-event {{$schedule->event_type == 'livechat' ?  'bg-success' : ''}} {{$schedule->event_type == 'learning' ?  'bg-danger': ''}} {{$schedule->event_type == 'meetup' ?  'bg-info': ''}} ">
                                {{strtoupper($schedule->event_type)}} <span class="text-warning">{{date('h:i
                                    A',strtotime($schedule->form)).'-'.date('h :i
                                    A',strtotime($schedule->to))}}</span>&nbsp;&nbsp;&nbsp;

                                @if ($schedule->remainder_date == null)
                                <a style="cursor: pointer;" onclick="Show('Set Reminder','{{ route('managerAdmin.schedule.edit',$schedule->id) }}')">
                                    <i class="fas fa-edit"></i>reminder
                                </a>
                                @else
                                remainder date : {{Carbon\Carbon::parse($schedule->remainder_date)->format('Y d,M')}}
                                @endif
                            </div>
                        </div>
                        @endforeach

                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->



            </div>
        </div>
        @endforeach
        <!-- /.col -->
        <!-- /.col -->
    </div>



</div> <!-- container -->
</div> <!-- content -->

<script>

</script>

<style>
    .AdminImg {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;

    }

    .AdminName {
        color: black;
        font-size: 1rem;
    }

    .AdminMusic {
        color: #638BC9 !important:
    }

    .AtifAdmin {
        color: #FF602E;
    }


    @media only screen and (min-width: 1100px) and (max-width: 1400px) {

        .AdminName {
            white-space: nowrap;
            width: 8vw;
            overflow: hidden;
        }
    }

</style>
@endsection
