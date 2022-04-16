@extends('Layouts.SuperAdmin.master')

@push('title')
Super Admin
@endpush

@section('content')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<style>
    .container {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 22px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default radio button */
.container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}

/* Create a custom radio button */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: white;
  border-radius: 50%;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the radio button is checked, add a blue background */
.container input:checked ~ .checkmark {
  background-color: #dfa431;
}

/* Create the indicator (the dot/circle - hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the indicator (dot/circle) when checked */
.container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the indicator (dot/circle) */
.container .checkmark:after {
 	top: 9px;
	left: 9px;
	width: 8px;
	height: 8px;
	border-radius: 50%;
	background: white;
}
</style>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Create Audition Rules</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Create New Audition Rules</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<style>
    .AddC {
        border-color: 1px solid gold !important;
    }
</style>
<div class="content">
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                {{-- <h3 class="card-title">Create New Audition Rules</h3> --}}
                {{-- <a class="btn btn-success btn-sm" style="float: right;"
                        onclick="Show('New Audition','{{ route('superAdmin.events.create') }}')"><i
                    class=" fa fa-plus"></i>&nbsp;New Audition</a> --}}
            </div>
            <form id="create-form" >
                @csrf
            <!-- /.card-header -->
            <div class="card-body d-flex justify-content-between mx-2">

                <div class=" WidhtEvent pys-3">
                    <div class="divS mt-3">
                        <center>
                            <img src="{{ asset('assets/super-admin/images/Category.png') }}" class="mb-1" width="35"
                                height="35" alt="">
                            <p><b class="fw-bold pt-4" style="color:#F8EE00;font-size: 20px;">Select Category</b></p>
                        </center>
                    </div>

                    <div class=" border-warning mx-5 mt-3 mb-5">
                        @if (isset($categories[0]))
                            @foreach ($categories as $key => $category)
                                <label class="container"><span style="color:#F8EE00">{{ $category->name }}</span>
                                    <input type="radio" name="category_id" id="category_id" value="{{ $category->id }}"{{ $key == 0 ? 'checked' : '' }} onchange="resetAll()">
                                    <span class="checkmark"></span>
                                </label>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class=" WidhtEvent " style="position: relative">
                    <div class="divS mt-2">
                        <center>
                            <img src="{{ asset('assets/super-admin/images/select.png') }}" class="mb-1" width="35"
                                height="35" alt="">
                            <p><b class="fw-bold pt-4" style="color:#F8EE00;font-size: 20px;">Select Rounds</b></p>
                        </center>
                    </div>

                    <div class=" border-warning mx-5 mt-2 mb-3">
                        <div class="centeredSX">
                            <span data-decrease class="minus NumAdd">-</span>
                            <input data-value id="round" class="Number text-center fw-bold p-3 mx-2 " type="text" value="0" min="0"
                                disabled />
                            <span class="minus NumAdd" data-increase>+</span>
                        </div>

                        <div class="centeredSXS text-center">
                            <b class="text-danger">#Note:</b><br>
                            <small>You can’t create more than 6 rounds</small>
                        </div>
                    </div>
                </div>

                <div class=" WidhtEvent " style="position: relative">
                    <div class="divS mt-2">
                        <center>
                            <img src="{{ asset('assets/super-admin/images/star.png') }}" class="mb-1" width="35"
                                height="35" alt="">
                            <p><b class="fw-bold pt-4" style="color:#F8EE00;font-size: 20px;">Select SuperStar</b></p>
                        </center>
                    </div>

                    <div class=" border-warning mx-5 mt-2 mb-3">
                        <div class="centeredSX">
                            <span data-decrease class="minus NumAdd">-</span>
                            <input data-value id="superstar" class="Number text-center fw-bold  p-3 mx-2 " type="text" value="0" />
                            <span class="minus NumAdd" data-increase>+</span>
                        </div>
                        <div class="centeredSXS text-center">
                            <b class="text-danger">#Note:</b><br>
                            <small> You can’t create more than 4 superstars</small>
                        </div>
                    </div>
                </div>

                <div class=" WidhtEvent " style="position: relative">
                    <div class="divS mt-2">
                        <center>
                            <img src="{{ asset('assets/super-admin/images/jury.png') }}" class="mb-1" width="35"
                                height="35" alt="">
                            <p><b class="fw-bold pt-4" style="color:#F8EE00;font-size: 20px;">Select Jurys</b></p>
                        </center>
                    </div>

                    <div class=" border-warning mx-5 mt-2 mb-3">
                        <div class="centeredSX">
                            <span data-decrease class="minus NumAdd">-</span>
                            <input data-value id="jury" class="Number text-center fw-bold  p-3 mx-2 " type="text" value="0" />
                            <span class="minus NumAdd" data-increase>+</span>
                        </div>
                        <div class="centeredSXS text-center">
                            <b class="text-danger">#Note:</b><br>
                            <small>You can’t create more than 8 jurys</small>
                        </div>
                    </div>
                </div>

                <div class=" WidhtEvent" style="position: relative">
                    <div class="divS mt-2">
                        <center>
                            <img src="{{ asset('assets/super-admin/images/table.png') }}" class="mb-1" width="35"
                                height="35" alt="">
                            <p><b class="fw-bold pt-4" style="color:#F8EE00;font-size: 20px;">Select Time</b></p>
                        </center>
                    </div>
                    <center><small>Select Time : </small></center>

                    <div class=" border-warning mx-5 mt-5 mb-3">

                        <div class="sds">
                            <div class="row justify-content-around mb-2">
                                <span class="d-flex ms-2 NumAdd" onclick="increment3()">+</span>
                                <span class="d-flex ms-2 NumAdd" onclick="increment4()">+</span>
                            </div>
                            <div class="bg-dark card mb-2 py-1">
                                <div class="row justify-content-around py-2">
                                    <b class="d-flex ms-2  px-3 ">Month</b>
                                    <b class="d-flex ms-2  px-3 ">Day</b>
                                </div>

                                <div class="row justify-content-around pb-2">
                                    <b class="d-flex ms-2 selects px-3 " id="root3">0</b>
                                    <b class="d-flex ms-2 selects px-3 " id="root4">0</b>
                                </div>
                            </div>

                            <div class="row justify-content-around mt-2">
                                <span class="d-flex ms-2 NumAdd" onclick="decrement3()">-</span>
                                <span class="d-flex ms-2 NumAdd" onclick="decrement4()">-</span>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <!-- /.card-body -->

            <center>
                <div class="Footerbtn">
                    {{-- <a href="{{ route('superAdmin.events.edit',1) }}"> <li class="breadcrumb-item active">Events
                        List</li></a> --}}
                    <a href="{{ route('superAdmin.audition-rules.index') }}"><button class="btn Back">Back</button></a>
                    <button class="btn Confirm" id="submitAuditionRules" >Confirm</button>
                    {{-- <button class="btn Confirm" data-toggle="modal" id="submitAuditionRules" data-target="#exampleModalCenter">Confirm</button> --}}
                </div>
            </center>

            </form>
        </div>

        <!-- Button trigger modal -->

        {{-- <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="background: #151515;
                border: 1px solid #FFD910;
                box-sizing: border-box;
                border-radius: 10px;">
                    <center>
                        <img src="{{ asset('assets/super-admin/images/modal.png') }}" width="150" class="p-3" alt="">
                        <div>
                            <h5 class="text-warning">Event Create</h5>
                            <h4 class="text-warning"> <b> Succesfully Done!!</b></h4>
                        </div>

                        <button type="button" class="btn  px-3 m-4" data-dismiss="modal" style="
                        background: #ADF1E7;color:black;
                        border-radius: 10px;">Done</button>
                    </center>
                </div>
            </div>
        </div> --}}

    </div> <!-- container -->
</div> <!-- content -->

<script>
    function resetAll() {
       $("#round").val("0");
       $("#superstar").val("0");
       $("#jury").val("0");
       $("#root3").text("0");
       $("#root4").text("0");
    }
    $(document).on('click','#submitAuditionRules',function (event) {
                event.preventDefault();
                var form = $('#create-form')[0];

                var category_id = $("#category_id").val();
                var round_num = $("#round").val();
                var judge_num = $("#superstar").val();
                var jury_num = $("#jury").val();
                var month = $("#root3").text();
                var day = $("#root4").text();

                // console.log('submitted data month: ',month+" day: "+day);
                var formData = new FormData(form);
                formData.append('category_id',category_id);
                formData.append('round_num',round_num);
                formData.append('judge_num',judge_num);
                formData.append('jury_num',jury_num);
                formData.append('month',month);
                formData.append('day',day);

                // Set header if need any otherwise remove setup part
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
                    }
                });
                $.ajax({
                    url: "{{route('superAdmin.audition-rules.store')}}",// your request url
                    data: formData,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    success: function (data) {
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
                        // console.log('success')
                    },
                    error: function (data) {
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
        });

  
</script>
@endsection
