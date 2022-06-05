@extends('Layouts.ManagerAdmin.master')

@push('title')
    Audition rules
@endpush

@section('content')
    <a href="{{route('managerAdmin.audition.registration.rules.create')}}">Create new rules</a>
    <a href="{{route('managerAdmin.audition.registration.rules.edit')}}">edit rules</a>
@endsection
