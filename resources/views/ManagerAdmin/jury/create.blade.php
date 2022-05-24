<form id="create-form" enctype="multipart/form-data">
    @csrf
    <div class="col-md-12">
        <label for="first_name">Select Sub Category</label>
        <select name="sub_category_id" id="sub_category_id" class="form-control">
            <option value="">Select One</option>
            @if(isset($sub_categories[0]))
                @foreach ($sub_categories as $key => $subCategory)
                    <option value="{{$subCategory->id}}">{{$subCategory->name}}</option>
                @endforeach
            @endif
        </select>
        <span class="text-danger" id="sub_category_error"></span>
   </div>
    <div class="row form-group">
        <div class="col-md-6">
              <label for="first_name">First Name</label>
              <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter Jury Admin First Name">
              <span class="text-danger" id="first_name_error"></span>
         </div>
         <div class="col-md-6">
              <label for="last_name">Last Name</label>
              <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Jury Admin Last Name">
              <span class="text-danger" id="last_name_error"></span>
        </div>
    </div>

    <div class="row form-group">
        <div class="col-md-12">
              <label for="terms_and_condition">Terms and Condition</label>
            <textarea name="terms_and_condition" class="form-control" id="summernote"></textarea>
            <span class="text-danger" id="terms_error"></span>
         </div>
    </div>

    {{-- <div class="form-group row">
        <div class="col-md-6">
          <label for="profile_file1">Jury Profile File 1</label>
          <input type="file" class="form-control" id="profile_file1" name="profile_file1">
        </div>
        <div class="col-md-6">
            <label for="profile_file2">Jury Profile File 2</label>
            <input type="file" class="form-control" id="profile_file2" name="profile_file2">
          </div>
    </div> --}}


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

    <button type="submit"  class="btn btn-primary" id="btnSendData"><i class="fa fa-save"></i>&nbsp; Save Jury</button>

</form>

<script>
    $('#summernote').summernote({
        height: 300,
        focus: true
    });

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
        url: "{{route('managerAdmin.jury.store')}}",// your request url
        data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (data) {
            Swal.fire(
                    'Success!',
                    'Jury Admin has been Added. ' + data.message,
                    'success'
                )
                setTimeout(function() {
                    location.reload();
                }, 1000);
            console.log('Success Jury Save',data);
        },
        error: function (data) {
            $.each(data.responseJSON.errors, function(key, value) {
                ErrorMessage(key,value); //this function on master page for showing error message
            });
        }
    });

});

</script>
