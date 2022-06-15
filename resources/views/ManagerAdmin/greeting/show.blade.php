@extends('Layouts.ManagerAdmin.master')

@push('title')
    Greeting Details
@endpush

@section('content')
    <style>
        .BannerAGN {
            border: 3px solid rgb(255, 174, 0);
            object-fit: cover;
            max-height: 330px;
        }


        .NotifyTable {
            color: white;
        }

        .LeftGNA {
            background-color: #252525;
            padding-left: 5px;
            border-radius: 5px;
            padding-right: 10px;
            margin-right: 20px !important;
        }

        .letfNotRe {
            border-radius: 10px 0px 0px 10px;
        }

        .rightNotRe {
            border-radius: 0px 10px 10px 0px;
        }

        .btnRecNot {
            background-color: #7A7A7A !important;
            color: white !important;
        }

        /* .active{
                        background-color: goldenrod !important;
                        color: white !important;
                    } */

        .clockNOte {
            background-color: rgb(29, 29, 29);
            font-size: 15px;
            font-weight: 100;

        }

        .NotifyTabletdRec {
            border-radius: 5px !important;
        }

        .datNotify {
            background-color: grey;
        }

        .Notifytdx {
            background-color: #3A3A3A;
        }

        .lNTS {
            border-radius: 10px 0px 0px 10px;
        }

        .rNTS {
            border-radius: 0px 10px 10px 0;
        }

        /* .Notifytdx:hover, .lNTS:hover, .rNTS:hover{
                     background-color: rgb(255, 153, 0);
                    } */



        .NotifyTabletd {
            padding: 8px;

        }

        .NotifyOver {
            overflow-x: auto;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
        }

        th,
        td {
            text-align: left;
            padding: 5px;
            padding-left: 10px;
        }

        .NotifyAimg {
            width: 40px;
            border-radius: 50%;
            -webkit-border-radius: 50%;
            -moz-border-radius: 50%;
            -ms-border-radius: 50%;
            -o-border-radius: 50%;
            margin-right: 5px;
        }



        .rightGNA {
            background-color: #252525 !important;
            margin-right: 10px;
            border-radius: 10px;
            width: 90%;
            -webkit-border-radius: 10px;
            -moz-border-radius: 10px;
            -ms-border-radius: 10px;
            -o-border-radius: 10px;
        }

        .ReactNAv {
            border: 2px solid rgb(255, 187, 0);
            border-radius: 10px;
            -webkit-border-radius: 10px;
            -moz-border-radius: 10px;
            -ms-border-radius: 10px;
            -o-border-radius: 10px;
        }

        .SpBannera {
            width: 100%;
        }

        .NotifyTp {

            font-family: Arial;
            margin-top: 15px;
            font-style: normal;
            font-weight: 600;
            font-size: 20px;
            line-height: 26px;
            color: #FFFFFF;
        }

        .NotifyTpx {
            color: white;
            font-family: Arial;
            font-weight: 500;
        }

        .PriceTage {
            width: 35px;
        }

        .buTon-a {
            background-color: rgb(85, 83, 81);
            border-radius: 5px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            -ms-border-radius: 5px;
            -o-border-radius: 5px;
        }

        .buTon-a:hover {
            background-color: goldenrod;
        }

        .buTon-ab {
            font-size: 18px;
            padding: 10px;
        }

        .buTon-abc {
            font-size: 16px;
            padding: 10px;
        }

        .NotifyBtn {
            background-color: rgb(131, 130, 130) !important;
            color: black;
            width: 100px;
        }

        .NotifyBtn:hover {
            background-color: rgb(247, 211, 6) !important;
            color: white !important;
        }

        .CostWith {
            width: 170px !important;
        }


        @media only screen and (max-width: 600px) {
            .LeftGNA {
                flex: 0 0 auto;
                width: 90% !important;
            }

            .rightGNA {
                flex: 0 0 auto;
                width: 90% !important;
            }
        }
    </style>
    <div class="row">
        <div class="col-md-12 mx-2 mt-3">
            <h4>Greeting Details</h4>
            <div style="border-bottom: 2px solid white;"></div>
        </div>
    </div>
    <div class="m-3">
        <div class="card ">
            <img src={{ asset($greeting->banner ?? get_static_option('no_image')) }} alt="" class="BannerAGN" />
        </div>

        <div class="mt-3 row">
            <div class="col-md-8 ">
                <div class="card bg-dark px-3 py-4">
                    <h4 class="text-light">{{ $greeting->title }}</h4>
                    <p class="text-light pt-1">
                        {!! $greeting->instruction !!}
                    </p>
                </div>
                <div class="row">
                    <div class=" col-md-6 bg-dark ">
                        <div class="px-5 py-3 my-auto">
                            <span>
                                <img src={{ asset('assets/manager-admin/tagPrice.PNG') }} alt="" class="PriceTage" />
                            </span>
                            <div class=" mx-2 ">
                                <span class="text-light buTon-ab ">Cost</span>
                                <br>
                                <span class="text-light buTon-abc">
                                    {{ $greeting->cost }} BDT
                                </span>
                            </div>
                        </div>
                        <div class="px-5 py-3 my-auto">
                            <span>
                                <img src={{ asset('assets/manager-admin/tagPrice.PNG') }} alt="" class="PriceTage" />
                            </span>
                            <div class=" mx-2 ">
                                <span class="text-light buTon-ab ">Minimum apply before</span>
                                <br>
                                <span class="text-light buTon-abc">
                                    {{ $greeting->user_required_day }} Day
                                </span>
                            </div>
                        </div>
                        {{-- <div class="text-center">
                            @if ($greeting->status === 1)
                                <button  value="{{ route('managerAdmin.greeting.publish', $greeting->id) }}" onclick="publish(this)" class="btn"
                                    style="background: #FFCE00; border-radius: 8px; font-weight: bold;">Publish Now <i
                                        class="fas fa-eye"></i></button>
                            @else
                                <button disabled  class="btn"
                                    style="background: #FFCE00; border-radius: 8px; font-weight: bold;">Published  <i
                                        class="fas fa-eye"></i></button>
                            @endif
                        </div> --}}
                    </div>
                    <div class="col-md-6">
                        <div class="card px-5 py-3">
                            <div class="row">
                                <div class="col-xs-6 content-center">
                                    <img src="{{ asset($greeting->star->image ?? get_static_option('no_image')) }}"
                                        style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray" />
                                </div>
                                <div class="col-xs-6">
                                    Star
                                    <h3>{{ $greeting->star->first_name ?? '' }} {{ $greeting->star->last_name ?? '' }}
                                    </h3>
                                </div>
                            </div>
                            <div class="row py-3">
                                <div class="col-xs-6 content-center">
                                    <img src="{{ asset($greeting->admin->image ?? get_static_option('no_image')) }}"
                                        style="height: 80px; width: 80px; border-radius: 50%; border: 2px solid gray" />
                                </div>
                                <div class="col-xs-6">
                                    Admin
                                    <h3>{{ $greeting->admin->first_name ?? '' }}
                                        {{ $greeting->admin->last_name ?? '' }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-4 mt-4">

                <video width="100%" controls class="img-fluid">
                    <source src="{{ asset($greeting->video) }}" type="video/mp4">
                </video>
                <div>
                </div>
            </div>

            <div class="col-md-4">

            </div>
        </div>

        <div class="container row mt-5">
            <div class="text-center">
                @if ($greeting->status == 1)
                    <button value="{{ route('managerAdmin.greeting.publish', $greeting->id) }}" onclick="publish(this)"
                        class="btn" style="background: #FFCE00; border-radius: 8px; font-weight: bold;">Publish
                        Now <i class="fas fa-eye"></i></button>
                    <a type="button" class="btn btn-outline-warning px-5"
                        onclick="Show('Edit Post','{{ route('managerAdmin.greeting.edit', $greeting->id) }}')">Edit</a>
                @else
                    <button disabled class="btn"
                        style="background: #FFCE00; border-radius: 8px; font-weight: bold;">Published <i
                            class="fas fa-eye"></i></button>
                    <button type="button" disabled class="btn btn-outline-warning px-5">Edit</button>
                @endif

            </div>

        </div>
    </div>

    <script>
        function publish(objButton) {
            var url = objButton.value;
            // alert(objButton.value)
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Publish !'
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        method: 'POST',
                        url: url,
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        },
                        success: function(data) {
                            if (data.type == 'success') {
                                Swal.fire(
                                    'Published !',
                                    'This greeting has been published. ' + data.message,
                                    'success'
                                )
                                setTimeout(function() {
                                    location.reload();
                                }, 800);
                            } else {
                                Swal.fire(
                                    'Wrong !',
                                    'Something going wrong. ' + data.message,
                                    'warning'
                                )
                            }
                        },
                    })
                }
            })
        }
    </script>
@endsection
