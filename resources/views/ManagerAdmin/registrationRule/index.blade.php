@extends('Layouts.ManagerAdmin.master')

@push('title')
    Audition rules
@endpush

@section('content')
    <div class="row">
            @if (isset($auditions[0]))
                @foreach ($auditions as $key => $audition)
                    <div class="col-md-6 ">
                        <div class="card m-3">
                            <div class="card-header bg-primary">
                                Audition Admin :
                                @if ($audition->auditionAdmin)
                                    <h4>{{ $audition->auditionAdmin->first_name ?? ('' . ' ' . $audition->auditionAdmin->last_name ?? '') }}
                                    </h4>
                                @endif
                            </div>
                            <div class="card-body">
                                <h1>{{ $audition->title }}</h1>
                                <p>{!! $audition->description !!} </p>
                            </div>
                            <div class="card-footer">
                                <a class="btn  create-rules-btn" href="{{ route('managerAdmin.audition.registration.rules.create',$audition->id) }}">Create new rules</a>
                                <a class="btn  rules-edit" href="{{ route('managerAdmin.audition.registration.rules.edit',$audition->id) }}">edit rules</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
    </div>
@endsection
