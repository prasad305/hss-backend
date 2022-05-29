@extends('Layouts.ManagerAdmin.master')

@push('title')
    Greeting Request
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12 mx-2 mt-3">
            <h4>Greeting Requests</h4>
            <div style="border-bottom: 2px solid white;"></div>
        </div>
    </div>

    <div class="row">
        @foreach ($greetings as $key => $greeting)
            <div class="col-md-4">
                <div class="card" style="width: 100%; margin: 10px; border:2px solid #FFCE00; padding: 10px;">
                    <img class="card-img-top" height="250px"
                        src="{{ asset($greeting->banner ?? get_static_option('no_image')) }}" alt="Greeting Banner">
                    <div class="card-body">
                        <h5 class="text-center">{{ $greeting->title }}</h5>
                        <p class="card-text text-center">Cost : {{ $greeting->cost }} BDT</p>
                        <div class="text-center">
                            <a href="{{ route('managerAdmin.greeting.show', $greeting->id) }}" class="btn"
                                style="background: #FFCE00; border-radius: 8px; font-weight: bold;">View <i
                                    class="fas fa-eye"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
