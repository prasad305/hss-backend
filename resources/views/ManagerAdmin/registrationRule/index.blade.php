@extends('Layouts.ManagerAdmin.master')

@push('title')
    Audition rules
@endpush

@section('content')

    <div class="row">
        <div class="col-md-12 mt-3">
            @if (isset($auditions[0]))
            @foreach ($auditions as $key => $audition)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-primary">
                      Audition Admin : <h4>{{ $audition->admin ? $audition->auditionAdmin->first_name.' '.$audition->auditionAdmin->last_name : ''}}</h4>  
                    </div>
                    <div class="card-body">
                        <h1>{{$audition->title}}</h1>
                        <p>{{$audition->description}} </p>
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-success text-light" href="{{route('managerAdmin.audition.registration.rules.create',$audition->id)}}">Create new rules</a>
                        <a class="btn btn-warning text-light" href="{{route('managerAdmin.audition.registration.rules.edit',$audition->id)}}">edit rules</a>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
    
@endsection
