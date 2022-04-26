@extends('Layouts.SuperAdmin.master')

@push('title')
Super Admin
@endpush

@section('content')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<!-- Content Header (Page header) -->
<div class="content-header BorderRpo">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-sm-6">
                <h1 class="m-0">Audition List</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{-- <a href="{{ route('superAdmin.events.edit',1) }}"> <li class="breadcrumb-item active">Events
                        List</li></a> --}}
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active"> Audition List</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<!-- /.content-header -->
<ul class="nav nav-tabs m-4" role="tablist">

    @foreach ($rules_categories as $key => $rules)
    <li class="nav-item custom-nav-item m-2 TextBH {{ $key == 0 ? 'active' : '' }}" onclick="selectedCategory('{{ $rules->id }}')">
        <a class="nav-link border-warning " data-toggle="tab" href="#tabs-{{ $rules->category ? $rules->category->id : '' }}" role="tab">
            <center>
                <img src="{{ asset($rules->category ? $rules->category->icon : '') }}" class="ARRimg pt-2" alt={{ $rules->category ? $rules->category->name : '' }} icon>
            </center>
            <a class="btn border-warning nav-link  {{ $key == 0 ? 'active' : '' }}"  data-toggle="tab" href="#tabs-{{ $rules->category->id ?? '' }}" role="tab">{{ $rules->category ? $rules->category->name : '' }}</a>
        </a>
    </li>
    @endforeach
</ul>

<div class="tab-content m-4">
    <h3>Audition List Edit</h3>
    <hr>
</div>

<div class="tab-content m-4" id="tab-content">

</div>

<div class="m-4" id="show-rules" style="display:none">
    <div class="tab-pane " id="tabs-90" role="tabpanel">
        <div class="container">

            <form id="create-form">
                @csrf

            <div class="row">

                <div class="d-flex  justify-content-between BorderInSA p-2 m-1 col-md-12">
                    <div class="text-light mt-1">
                        <div class="custom-control">
                            <input type="checkbox" id="checkbox1" class=" mt-3"/>
                            <label class="" for="jury"><span class="px-3">User Vote Mark</span></label>
                        </div>
                    </div>
                    <div class="text-light">
                        <input type="number" min="0" max="100" id="textbox1"  class="Chexka form-control" placeholder="0"/>
                    </div>
                </div>

                <div class="d-flex  justify-content-between BorderInSA p-2 m-1 col-md-12">
                    <div class="text-light mt-1">
                        <div class="custom-control">
                            <input type="checkbox" id="checkbox2" class=" mt-3"/>
                            <label class="" for="jury"><span class="px-3">Jury Mark</span></label>
                        </div>
                    </div>
                    <div class="text-light">
                        <input type="number" min="0" max="100" id="textbox2"  class="Chexka form-control" placeholder="0" />
                    </div>
                </div>

                <div class="d-flex  justify-content-between BorderInSA p-2 m-1 col-md-12">
                    <div class="text-light mt-1">
                        <div class="custom-control">
                            <input type="checkbox" id="checkbox3" class=" mt-3" />
                            <label class="" for="jury"><span class="px-3">Judge Mark</span></label>
                        </div>
                    </div>
                    <div class="text-light">
                        <input type="number" min="0" max="100" id="textbox3"  class="Chexka form-control" placeholder="0"/>
                    </div>
                </div>

                <div class="d-flex col-md-12 justify-content-center mt-4 mb-4">
                    <button class="btn bg-warning px-3 BTNdone" id="SubmitRules">Done</button>
                </div>

            </div>
            </form>
        </div>
    </div>

</div>


<script>
    function selectedCategory(rules_id){


        // var rules_id = $('.selectedCategory').text();
        console.log('category', rules_id);
        var url = "{{ url('super-admin/audition-round-rules/') }}";


            $.ajax({
                url: url + "/" + rules_id, // your request url
                type: 'GET',
                success: function(data) {
                    console.log('get data', data);
                    $('#tab-content').html("");

                    var single_round = "";

                    data.round_rules.forEach((round,index) => {
                        single_round+='<li class="nav-item custom-nav-item m-2 TextBH" onclick="showRules('+round.id+')">'+
                                '<a class="nav-link border-warning text-warning font-weight-bold" data-toggle="tab" href="" role="tab">'+
                                        '<center class="mb-2">'+
                                            '<h4>Round</h4>'+
                                            '<span class="bg-gray p-1 btn " >'+`${index+1}`+'</span>'+
                                        '</center>'+
                                        '<a class="btn border-warning nav-link " data-toggle="tab" href="" role="tab">Rolls</a>'+
                                    '</a>'+
                                '</li>';
                    });

                    $('#tab-content').append(
                        '<div>'+
                            '<ul class="nav nav-tabs" role="tablist">'+single_round+'</ul>'+
                        '</div>'
                    );

                },
                error: function(data) {
                    var errorMessage = '<div class="card bg-danger">\n' +
                        '<div class="card-body text-center p-5">\n' +
                        '<span class="text-white">';
                    $.each(data.responseJSON.errors, function(key, value) {
                        errorMessage += ('' + value + '<br>');
                    });
                    errorMessage += '</span>\n' +
                        '</div>\n' +
                        '</div>';
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        footer: errorMessage
                    });

                    console.log(data);
                }
            });

    };

    function showRules(round_id){

        var url = "{{ url('super-admin/audition-round-rules/mark/') }}";


            $.ajax({
                url: url + "/" + round_id, // your request url
                type: 'GET',
                success: function(data) {
                    console.log('get data', data);

                    if (data.mark.user_vote_mark > 0) {
                        $('#checkbox1').attr('checked', 'checked');
                        $('#textbox1').attr("style", "display:block");
                        $('#textbox1').val(data.mark.user_vote_mark);
                    }else{
                        $('#checkbox1').attr('checked', false);
                        $('#textbox1').attr("style", "display:none");
                        $('#textbox1').val(0);
                    }

                    if (data.mark.jury_mark > 0) {
                        $('#checkbox2').attr('checked', 'checked');
                        $('#textbox2').attr("style", "display:block");
                        $('#textbox2').val(data.mark.jury_mark);
                    }else{
                        $('#checkbox2').attr('checked', false);
                        $('#textbox2').attr("style", "display:none");
                        $('#textbox2').val(0);
                    }

                    if (data.mark.judge_mark > 0) {
                        $('#checkbox3').attr('checked', 'checked');
                        $('#textbox3').attr("style", "display:block");
                        $('#textbox3').val(data.mark.judge_mark);
                    }else{
                        $('#checkbox3').attr('checked', false);
                        $('#textbox3').attr("style", "display:none");
                        $('#textbox3').val(0);
                    }


                },
                error: function(data) {
                    var errorMessage = '<div class="card bg-danger">\n' +
                        '<div class="card-body text-center p-5">\n' +
                        '<span class="text-white">';
                    $.each(data.responseJSON.errors, function(key, value) {
                        errorMessage += ('' + value + '<br>');
                    });
                    errorMessage += '</span>\n' +
                        '</div>\n' +
                        '</div>';
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        footer: errorMessage
                    });

                    console.log(data);
                }
            });



        $('#show-rules').attr("style", "display:block");

        $(document).on('click', '#SubmitRules', function(event) {
            event.preventDefault();

            var v1 = parseInt($('#textbox1').val()) > 0 ? parseInt($('#textbox1').val()) : 0 ;
            var v2 = parseInt($('#textbox2').val()) > 0 ? parseInt($('#textbox2').val()) : 0;
            var v3 = parseInt($('#textbox3').val()) > 0 ? parseInt($('#textbox3').val()) : 0 ;
           var total = v1+v2+v3;

    if (total > 100) {
        Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Total Mark Will Not Be More Than 100',
                        showConfirmButton: true,
                        // timer: 1500
                    })
        // alert('Total Mark Will Not Be More Than 100');
    }else{
        var form = $('#create-form')[0];

            var formData = new FormData(form);
            formData.append('round_id', round_id);
            formData.append('user_vote_mark', v1);
            formData.append('jury_mark', v2);
            formData.append('judge_mark', v3);

            // Set header if need any otherwise remove setup part
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
                }
            });

            $.ajax({
                url: "{{ route('superAdmin.audition-round-rules.store') }}", // your request url
                data: formData,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function(data) {
                    Swal.fire({
                        position: 'top-end',
                        icon: data.type,
                        title: data.message,
                        showConfirmButton: false,
                        // timer: 1500
                    })
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                    console.log('success')
                },
                error: function(data) {
                    var errorMessage = '<div class="card bg-danger">\n' +
                        '<div class="card-body text-center p-5">\n' +
                        '<span class="text-white">';
                    $.each(data.responseJSON.errors, function(key, value) {
                        errorMessage += ('' + value + '<br>');
                    });
                    errorMessage += '</span>\n' +
                        '</div>\n' +
                        '</div>';
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        footer: errorMessage
                    });

                    console.log(data);
                }
            });
    }


        });


    }
$(document).ready(function () {
    // $('#textbox1').val($(this).is(':checked'));

     $('#textbox1').attr("style", "display:none");
     $('#textbox2').attr("style", "display:none");
     $('#textbox3').attr("style", "display:none");

    $('#checkbox1').change(function() {
        if($(this).is(":checked")) {
            $('#textbox1').attr("style", "display:block");
        }else{
            $('#textbox1').attr("style", "display:none");
        }
    });
    $('#checkbox2').change(function() {
        if($(this).is(":checked")) {
            $('#textbox2').attr("style", "display:block");
        }else{
            $('#textbox2').attr("style", "display:none");
        }
    });
    $('#checkbox3').change(function() {
        if($(this).is(":checked")) {
            $('#textbox3').attr("style", "display:block");
        }else{
            $('#textbox3').attr("style", "display:none");
        }
    });

    // var v1 = $('#textbox1').val();
    // var v2 = $('#textbox2').val();
    // var v3 = $('#textbox3').val();

    // var total = v1 + v2 + v3;

    // if (total > 100) {
    //     alert('Total Mark Will Not Be More Than 100');
    // }
});

</script>

@endsection
