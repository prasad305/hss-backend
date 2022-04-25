@extends('Layouts.ManagerAdmin.master')

@push('title')
    Admin
@endpush

@section('content')
    <div>
        <div class="d-flex justify-content-between marginTopAdminList">
            <div>
                <p class='AdminListText'>Audition Admin List</p>
            </div>
            <div class="d-flex">

                <div class="search-container mx-2">
                    <form action="/search" method="get">
                        <input class="search expandright" id="searchright" type="search" name="q" placeholder="Search">
                        <label class="button searchbutton" for="searchright"><span
                                class="mglass">&#9906;</span></label>
                    </form>
                </div>

                <br>

                <div>
                    <button data-toggle="dropdown" class='btn filterBtn'><i class="fa-solid fa-arrow-down-short-wide"></i>
                        Filter</button>
                    <div class="dropdown-menu" style="background-color: #3c506f;">
                        <a class="dropdown-item" href="{{ route('managerAdmin.audition.auditionAdmin.assinged') }}">Show assigned audition
                            admins</a>
                        <a class="dropdown-item" href="{{ route('managerAdmin.audition.auditionAdmin.notAssinged') }}">Show available
                            audition admins</a>
                        <a class="dropdown-item" href="{{ route('managerAdmin.audition.auditionAdmin.index') }}">All Admins</a>
                    </div>
                </div>
                <div class='mx-2'>
                    <a class='btn filterBtn'
                        onclick="Show('New Audition Admin','{{ route('managerAdmin.audition.auditionAdmin.create') }}')"><i
                            class="fa-solid fa-circle-plus"></i> New</a>
                </div>
            </div>
        </div>

        <div class='borderBottom'>
        </div>

        <div class="row">
            @foreach ($auditionAdmins as $auditionAdmin)
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box bg-dark shadow-none pt-4 pb-4 m-3">
                        <img src="{{ asset($auditionAdmin->image ?? get_static_option('user')) }}" alt="Admin Admin image"
                            class="img-fluid AdminImg mr-3 mt-4">
                        <div class="px-2 mt-3" style="border-left: 1px solid gray">
                            <a href="{{ route('managerAdmin.audition.auditionAdmin.show', $auditionAdmin->id) }}">
                                <span class="info-box-text AdminName">
                                    <h5 class="text-light">{{ $auditionAdmin->first_name }}
                                        {{ $auditionAdmin->last_name }}</h5>
                                </span>
                                <b class="AdminMusic">{{ $auditionAdmin->auditionCategory->name }}</b> <br />
                                <p class="{{ $auditionAdmin->status == 0 ? 'text-danger' : 'text-success' }}">
                                    {{ $auditionAdmin->status == 0 ? 'Pending For Approval' : 'Approved' }}</p>
                            </a>
                            @if ($auditionAdmin->assignedAudition)
                                <span class="right badge bg-danger my-2">Assigned</span>
                            @else
                                <span class="right badge bg-success my-2">Free now</span>
                            @endif
                            <i class="fa-solid fa-bahai px-2 text-danger"></i><br>



                            <a class="btn btn-sm btn-info"
                                onclick="Show('Edit Audition Admin','{{ route('managerAdmin.audition.auditionAdmin.edit', $auditionAdmin->id) }}')"><i
                                    class="fa fa-edit text-white"></i></a>

                            <button class="btn btn-sm btn-warning" onclick="delete_function(this)"
                                value="{{ route('managerAdmin.auditionAdmin.destroy', $auditionAdmin->id) }}"><i
                                    class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <style>
        .marginTopAdminList {
            margin-top: 4rem;
        }

        .borderBottom {
            border: 1px solid gray;
        }

        .AdminListText {
            font-size: 30px;
            margin-left: 2rem
        }

        .filterBtn {
            margin-top: 2px;
            background-color: #3c506f;
            width: 150px;
            height: 50px;
            border-radius: 10px;
            color: #ffffff;
            border: 1px solid gray;
        }

        .button {
            display: inline-block;
            margin: 4px 2px;
            background-color: #3c506f;
            font-size: 14px;
            padding-left: 32px;
            padding-right: 0px;
            height: 50px;
            border: 1px solid gray;
            border-radius: 10px;
            line-height: 50px;
            text-align: center;
            color: white;
            text-decoration: none;
            cursor: pointer;
            -moz-user-select: none;
            -khtml-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .button:hover {
            transition-duration: 0.4s;
            -moz-transition-duration: 0.4s;
            -webkit-transition-duration: 0.4s;
            -o-transition-duration: 0.4s;
            background-color: white;
            color: black;
        }

        .search-container {
            position: relative;
            display: inline-block;
            margin: 4px 2px;
            height: 50px;
            width: 50px;
            vertical-align: bottom;
        }

        .mglass {
            display: inline-block;
            pointer-events: none;
            -webkit-transform: rotate(-45deg);
            -moz-transform: rotate(-45deg);
            -o-transform: rotate(-45deg);
            -ms-transform: rotate(-45deg);
        }

        .searchbutton {
            position: absolute;
            font-size: 22px;
            width: 100%;
            margin: 0;
            padding: 0;
        }

        .search:focus+.searchbutton {
            transition-duration: 0.4s;
            -moz-transition-duration: 0.4s;
            -webkit-transition-duration: 0.4s;
            -o-transition-duration: 0.4s;
            background-color: white;
            color: black;
        }

        .search {
            position: absolute;
            left: 49px;
            background-color: white;
            outline: none;
            border: none;
            padding: 0;
            width: 0;
            height: 100%;
            z-index: 10;
            transition-duration: 0.4s;
            -moz-transition-duration: 0.4s;
            -webkit-transition-duration: 0.4s;
            -o-transition-duration: 0.4s;
        }

        .search:focus {
            width: 363px;
            padding: 0 16px 0 0;
        }

        .expandright {
            left: auto;
            right: 49px;
        }

        .expandright:focus {
            padding: 0 0 0 16px;
        }

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

        @media only screen and (max-width: 600px) {
            .AdminListText {
                font-size: 15px;
            }
        }

    </style>
@endsection
