<form  id="edit-form" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="_method" value="PUT">
    <div class="row form-group">
        <div class="col-md-6">
              <label for="first_name">First Name</label>
              <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $star->first_name }}">
              <span class="text-danger" id="first_name_error"></span>
         </div>
         <div class="col-md-6">
              <label for="last_name">Last Name</label>
              <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $star->last_name }}">
              <span class="text-danger" id="last_name_error"></span>
        </div>
     </div>

    <div class="form-group row">
        <div class="col-md-6">
          <label for="phone">DOB</label>
          <input type="date" class="form-control" id="dob" name="dob" value="{{$star->dob}}">
          <span class="text-danger" id="dob_error"></span>
        </div>
        <div class="col-md-6">
            <label for="first_name">Select Sub Category</label>
            <select name="sub_category_id" id="sub_category_id" class="form-control">
                <option value="">Select One</option>
                @if(isset($sub_categories[0]))
                    @foreach ($sub_categories as $key => $subCategory)
                        <option {{$subCategory->id == $star->sub_category_id ? 'selected' : ''}} value="{{$subCategory->id}}">{{$subCategory->name}}</option>
                    @endforeach
                @endif
            </select>
            <span class="text-danger" id="sub_category_error"></span>
       </div>
    </div>

    <div class="col-md-12">
        <label for="dob">Address</label>
        <textarea name="address" class="form-control textarea" id="" cols="30" rows="10">{{$star->address}}</textarea>
    </div>

    <div class="col-md-12">
        <label for="dob">Details</label>
        <textarea name="details" class="form-control " id="summernote" cols="30" rows="10">{{$star->details}}</textarea>
    </div>

    <button type="submit" class="btn btn-success" id="btnUpdateData"><i class="fa fa-save"></i>&nbsp; Update Star</button>

</form>


<script>
    $('.textarea').summernote();
    $('#summernote').summernote({
  height: 300,
  focus: true
});
   $(document).on('click','#btnUpdateData',function (event) {
    event.preventDefault();
    ErrorMessageClear()
    var form = $('#edit-form')[0];
    var formData = new FormData(form);
    formData.append('_method','PUT');
    // Set header if need any otherwise remove setup part
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
        }
    });

    $.ajax({
        url: "{{ route('managerAdmin.star.update',$star->id) }}",// your request url
        data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (data) {
            Swal.fire(
                    'Success!',
                    'Star has been Added. ' + data.message,
                    'success'
                )
                setTimeout(function() {
                    location.reload();
                }, 1000);
            console.log(data);
        },
        error: function (data) {
            $.each(data.responseJSON.errors, function(key, value) {
                ErrorMessage(key,value); //this function on master page for showing error message
            });
        }
    });

});
</script>
