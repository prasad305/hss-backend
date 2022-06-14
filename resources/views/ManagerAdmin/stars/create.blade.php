<form id="create-form" enctype="multipart/form-data">
    @csrf
    
    <div class="row form-group">
        <div class="col-md-6">
              <label for="first_name">First Name</label>
              <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter Star First Name">
              <span class="text-danger" id="first_name_error"></span>
         </div>
         <div class="col-md-6">
              <label for="last_name">Last Name</label>
              <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Star Last Name">
              <span class="text-danger" id="last_name_error"></span>
        </div>
     </div>

    <div class="form-group row">
        <div class="col-md-6">
          <label for="dob">DOB</label>
          <input type="date" class="form-control" id="dob" name="dob" placeholder="Enter Date Of Birth">
          <span class="text-danger" id="dob_error"></span>
        </div>
        <div class="col-md-6">
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
    </div>

    <div class="col-md-12">
        <label for="dob">Address</label>
        <textarea name="address" class="form-control textarea" id="" cols="30" rows="10"></textarea>
    </div>

    <div class="col-md-12">
        <label for="dob">Details</label>
        <textarea name="details" class="form-control" id="summernote" rows="15" style="height: 500px!important"></textarea>
    </div>
    <button type="submit"  class="btn btn-success" id="btnSendData"><i class="fa fa-save"></i>&nbsp; Save Super Star</button>

</form>

<script>
    $('.textarea').summernote()

    $('#summernote').summernote({
  height: 300,
  focus: true
});

   $(document).on('click','#btnSendData',function (event) {
    event.preventDefault();
    ErrorMessageClear(); //this function on master page for clear error message 
    var form = $('#create-form')[0];
    var formData = new FormData(form);

    // Set header if need any otherwise remove setup part
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
        }
    });
    $.ajax({
        url: "{{route('managerAdmin.star.store')}}",// your request url
        data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (data) {
            Swal.fire(
                'Success!',
                data.message,
                'success'
            )
            setTimeout(function() {
                location.reload();
            }, 1000);
        },
        error: function (data) {
            $.each(data.responseJSON.errors, function(key, value) {
                ErrorMessage(key,value); //this function on master page for showing error message
            });
        }
    });
});
</script>
