{{-- <form id="create-form" enctype="multipart/form-data">
    @csrf
    <div class="row form-group">
        <div class="col-md-12">
            <label for="first_name">Select Sub Category</label>
            <select name="sub_category_id" id="sub_category_id" class="form-control">
                <option value="">Select One</option>
                @if (isset($sub_categories[0]))
                    @foreach ($sub_categories as $key => $subCategory)
                        <option value="{{$subCategory->id}}">{{$subCategory->name}}</option>
                    @endforeach
                @endif
            </select>
             <span class="text-danger" id="sub_category_error"></span>
       </div>
        <div class="col-md-6">
              <label for="first_name">First Name</label>
              <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter Audition Admin First Name">
              <span class="text-danger" id="first_name_error"></span>

         </div>
         <div class="col-md-6">
              <label for="last_name">Last Name</label>
              <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Audition Admin Last Name">
              <span class="text-danger" id="last_name_error"></span>
        </div>
     </div>

    <div class="form-group row">
        <div class="col-md-6">
          <label for="phone">Phone</label>
          <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Audition Admin Phone">
          <span class="text-danger" id="phone_error"></span>

        </div>
        <div class="col-md-6">
             <label for="email">Email</label>
             <input type="email" class="form-control" id="email" name="email" placeholder="Enter Audition Admin Email">
            <span class="text-danger" id="email_error"></span>
        </div>
    </div>
    <span class="row">
        <div class="form-group col-md-6">
            <label for="icon">image</label>
            <br><img id="icon1" onchange="validateMultipleImage('icon1')" alt="image" src="" height="180px" width="180px" onerror="this.onerror=null;this.src='{{ asset(get_static_option('no_image')) }}';" required/>

            <br><br>

            <input type="file" class="mt-2" id="image" name="image" onchange="document.getElementById('icon1').src = window.URL.createObjectURL(this.files[0]); show(this)" accept=".jfif,.jpg,.jpeg,.png,.gif" required>
           <span class="text-danger" id="image_error"></span>

          </div>
          <div class="form-group col-md-6">
              <label for="image">Cover</label>
              <br><img id="image1" onchange="validateMultipleImage('image1')" alt="icon" src="" height="180px" width="180px" onerror="this.onerror=null;this.src='{{ asset(get_static_option('no_image')) }}';" required/>

              <br><br>

              <input type="file" class="mt-2" id="cover" name="cover" onchange="document.getElementById('image1').src = window.URL.createObjectURL(this.files[0]); show(this)" accept=".jfif,.jpg,.jpeg,.png,.gif" required>
             <span class="text-danger" id="cover_error"></span>

        </div>
    </span>

    <button type="submit"  class="btn btn-success" id="btnSendData"><i class="fa fa-save"></i>&nbsp; Save Audition Admin</button>

</form>

<script>
   $(document).on('click','#btnSendData',function (event) {
    event.preventDefault();
    ErrorMessageClear();
    var form = $('#create-form')[0];
    var formData = new FormData(form);

    // Set header if need any otherwise remove setup part
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
        }
    });
    $.ajax({
        url: "{{route('managerAdmin.auditionAdmin.store')}}",// your request url
        data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (data) {
            Swal.fire(
                    'Success!',
                    'Audition Admin has been Added. ' + data.message,
                    'success'
                )
                setTimeout(function() {
                    location.reload();
                }, 1000);
        },
        error: function (data) {
            $.each(data.responseJSON.errors, function(key, value) {
                ErrorMessage(key,value);
            });
        }
    });

});
</script> --}}














@extends('Layouts.ManagerAdmin.master')

@push('title')
    Audition Create
@endpush
@push('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/manager-admin/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/manager-admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/manager-admin/dist/css/adminlte.min.css') }}">
@endpush
@section('content')
    <style>
        .completedMeetupBlack {
            background-color: #151515 !important;
            border-radius: 10px;
        }

        .BGa {
            border: 1px solid rgb(255, 217, 0);
        }

        .BGaB {
            border: 1px solid rgb(0, 204, 255);
        }

        .GoldBtn {
            background: linear-gradient(90deg, #FFCE00 0%, #DFA434 100%) !important;
            border-radius: 25px;
        }

        .GoldBtn:hover {
            background: rgb(16, 20, 29) !important;
            color: white;
            border: 1px solid #FFCE00 !important;
        }

        .BlueBtn {
            background: linear-gradient(90deg, #22AADD 0%, #3A8FF2 100%);
            border-radius: 25px;
        }

        .BlueBtn:hover {
            background: rgb(16, 20, 29) !important;
            color: white;
            border: 1px solid rgb(0, 183, 255) !important;
        }

        .bottomBlackLine {
            border-bottom: 2px solid white;
        }

        .displaySide {
            display: flex;
            justify-content: center
        }

        .fontBold {
            font-size: 40px;
            font-weight: 800;
        }
    </style>

    <!-- Content Header (Page header) -->
    <div class="content-header BorderRpo">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-sm-6">
                    <h1 class="m-0">Create</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        {{-- <a href="{{ route('superAdmin.events.edit',1) }}"> <li class="breadcrumb-item active">Events
                        List</li></a> --}}
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"> Create</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    @include('ManagerAdmin.Audition.includes.audition-sub-nav')

    <div class="row">
        <div class="col-md-12 mx-2 mt-3">
            <div class="row">
                <h4>Create Audition</h4>
                <a class="btn btn-success btn-sm mr-4 " style="margin-bottom: 10px; margin-left: auto;"
                    href="{{ route('managerAdmin.audition.events') }}">
                    <i class=" fa fa-list"></i>&nbsp;Audition list
                </a>
            </div>
            <div class='bottomBlackLine'></div>
        </div>
    </div>

    <div class="container">
        <form action="{{ route('managerAdmin.audition.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-2">
                        <label>Title</label>
                    </div>
                    <div class="col-10">
                        <input type="hidden" name="audition_rule_id" value="{{ $auditionRule->id ?? '' }}">
                        <textarea name="title" class="form-control" rows="3">{{ old('title') }}</textarea>
                        @error('title')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-2">
                        <label>Description</label>
                    </div>
                    <div class="col-10">
                        <textarea name="description" class="form-control" rows="6">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>


                <div class="form-group row">
                    <div class="col-2">
                    </div>
                    <div class="col-10">
                        <h6 class="text-warning">The audition will have to complete within
                            {{ $auditionRule->event_period ?? 0 }} day(s)</h6>
                    </div>
                    <hr>
                </div>


                <div class="form-group row">
                    <div class="col-2">
                        <label>Event Start</label>
                    </div>
                    <div class="col-4">
                        <input type="date" onchange="setEndDate()" name="start_date" id="start_date"
                            class="form-control">
                        @error('start_date')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-2">
                        <label>Event End</label>
                    </div>
                    <div class="col-4">
                        <input type="text" readonly name="end_date" id="end_date" class="form-control">
                        @error('end_date')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class=" float-right">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
    <style>
        .dark-mode .card {
            /* background-color: #343a40; */
            color: #fff;
        }

        .paddingWidget {
            padding: 20px !important;
        }

        .AdminCover {
            background-repeat: none !important;
            background-size: cover !important;
            /* object-fit: cover !important; */
            height: 350px !important;
            margin-bottom: 20px;
            border: 2px solid #ff0;
            border-radius: 15px;
        }

        .ImGAdmin {
            width: 180px !important;
            height: 180px !important;
            margin-top: 50px;
            border: 8px solid white;
        }

        .nav-tabs {
            border-bottom: none;
        }

        .centeredImg {
            position: absolute;
            top: 350px;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .Cardnew {
            background-color: #2d2d2d !important;
        }

        .nameAdmin {
            color: #ff0;
            font-weight: 700;
            fontSize: 25px;
            margin-top: 10px;
        }

        .adminAssignPadding {
            background-color: #000000;
        }

        .widgetUserPadding {
            border: 2px solid gray;
            border-radius: 10px;
        }

        .auditionTitle {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 600;
            font-size: 32px;
            line-height: 48px;
            color: #3A8FF2;
            text-align: left;
        }

        .auditionDescription {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 500;
            font-size: 20px;
            line-height: 30px;
            color: #D2C3C3;
            text-align: left;
        }

        .bannerImage {
            border: 2px solid gold;
            border-radius: 20px;
        }

        .videoDiv {
            margin: 20px 0;
        }

        .bannerVideo {
            border: 2px solid gold;
            border-radius: 20px;
        }
    </style>
@endsection


@push('js')
    <script>
        function setEndDate() {
            var date = document.getElementById('start_date').value;
            var number = '{{ $auditionRule->event_period ?? 0 }}';
            const newDate = new Date(date);

            var end_date = new Date(newDate.setDate(newDate.getDate() + parseInt(number)));

            let day, month, year;

            day = end_date.getDate();
            month = end_date.getMonth() + 1;
            year = end_date.getFullYear();

            var final_date = month + '/' + day + '/' + year;


            document.getElementById('end_date').value = final_date;
        }
    </script>
    <!-- Select2 -->
    <script src="{{ asset('assets/manager-admin/plugins/select2/js/select2.full.min.js') }}"></script>


    <script>
        //Initialize Select2 Elements
        $('.select2').select2();

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });
    </script>
@endpush
