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
                <ul class="nav nav-tabs" role="tablist" onclick="getRoundBasedInstruction('{{$round->id}}')"> 
                <li class="nav-item custom-nav-item m-2 TextBH" >
                    <a class="nav-link border-warning text-warning font-weight-bold" data-toggle="tab" href="" role="tab">
                        <center class="mb-2"> 
                            <h4>Round</h4> 
                            <span class="bg-gray p-1 btn " > 1 </span> 
                        </center> 
                        <a class="btn border-warning nav-link " data-toggle="tab" href="" role="tab">Rolls</a> 
                    </a> 
                    </li>
                </ul>
            </div>
           @endforeach
           
        </div>
        <div class="row">
            <div id="round_instruction_show">

            </div>
           </div>
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
    function getRoundBasedInstruction(round_info_id) {
        $('#round_instruction_show').html("")
        var audition_id = '{{$event->id}}';
        var url = "{{ url('manager-admin/audition/round-instruction/') }}";
        $.ajax({
            url: url + "/" + audition_id+ "/" + round_info_id, // your request url
            type: 'GET',
            success: function(data) {
                $('#round_instruction_show').append(data); 

            },
            error: function(data) {
               
            }
        });
    }
</script>

@endsection

