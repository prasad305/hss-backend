@extends('Layouts.ManagerAdmin.master')

@push('title')
    Manager Admin
@endpush


@section('content')
    <style>
        .banner-image {
            height: 300px;
            object-fit: cover;
        }

        .round-nmbr {
            background-color: #A9BA9D;
            height: 40px;
            width: 40px;
            border-radius: 50%;
        }
    </style>



    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Audition</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Audition Round Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                @foreach ($event->info->auditionRounds as $key => $round)
                    <div>
                        <ul class="nav nav-tabs" role="tablist" onclick="getRoundBasedResult('{{ $round->id }}')">
                            <li class="nav-item custom-nav-item m-2 TextBH">
                                <a class="nav-link border-warning text-warning font-weight-bold" data-toggle="tab"
                                    href="" role="tab">
                                    <center class="mb-2">
                                        <h4>Round</h4>
                                        <span class=" p-1 btn round-nmbr font-weight-bold "> {{ $round->round_num }} </span>
                                    </center>
                                    <a class="btn border-warning nav-link font-weight-bold text-light" data-toggle="tab"
                                        href="" role="tab">Show</a>
                                </a>
                            </li>
                        </ul>
                    </div>
                @endforeach

            </div>



            {{-- Round Details Derectory --}}
            <div class="row">
                <div class="col-md-12" id="round_result_show">

                </div>
            </div>
            {{-- Round Details Derectory End --}}

        </div>
    </div>


    @if (session()->has('success'))
        <script type="text/javascript">
            $(document).ready(function() {
                // notify('{{ session()->get('success') }}','success');
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: '{{ Session::get('success') }}',
                    showConfirmButton: false,
                    timer: 1500
                })
            });
        </script>
    @endif

    <script>
        function getRoundBasedResult(round_info_id) {
            $('#round_result_show').html("")
            var audition_id = '{{ $event->id }}';
            var url = "{{ url('manager-admin/audition/round-result/') }}";
            var type = 'appeal';
            $.ajax({
                url: url + "/" + audition_id + "/" + round_info_id + "/" + type, // your request url
                type: 'GET',
                success: function(data) {
                    $('#round_result_show').append(data);

                },
                error: function(data) {

                }
            });
        }
    </script>
@endsection
