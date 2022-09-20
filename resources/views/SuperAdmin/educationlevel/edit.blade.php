<form  id="edit-form" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="_method" value="PUT">
    <div class="row form-group">
       
         <div class="col-md-6">
              <label for="name"> Name</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="Enter Audition Admin Last Name" value="{{$educationlevel->name}}">
              <small id="name_error" class="form-text text-danger"></small>
        </div>
    </div>
    
    <div class="form-group row">
     
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="status" id="inlineRadio1" {{ $educationlevel->status == 1 ? 'checked' : '' }} value="1">
            <label class="form-check-label" for="inlineRadio1">Active</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="status" id="inlineRadio2" {{ $educationlevel->status == 0 ? 'checked' : '' }} value="0">
            <label class="form-check-label" for="inlineRadio2">InActive</label>
          </div>
         
    </div>

    <button type="submit" class="btn btn-primary" id="btnUpdateData"><i class="fa fa-save"></i>&nbsp; Update Educationlevel </button>

</form>


<script>
   $(document).on('click','#btnUpdateData',function (event) {
    event.preventDefault();
    $('#name_error').text('');
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
        url: "{{ route('superAdmin.educationlevel.update',$educationlevel->id) }}",// your request url
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
            var errorMessage = '<div class="card bg-danger">\n' +
                        '<div class="card-body text-center p-5">\n' +
                        '<span class="text-white">';
                    $.each(data.responseJSON.errors, function(key, value) {
                        errorMessage += ('' + value + '<br>');
                        $("#" + key + "_error").text(value[0]);
                    });
                    errorMessage += '</span>\n' +
                        '</div>\n' +
                        '</div>';
                    // Swal.fire({
                    //     icon: 'error',
                    //     title: 'Oops...',
                    //     footer: errorMessage
                    // })
        }
    });

});
</script>
