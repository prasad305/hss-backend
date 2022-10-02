<form id="edit-form" enctype="multipart/form-data">
    @csrf


    <div class="form-group">
        <label for="title">FAQ Question</label>
        <input type="text" class="form-control" id="title" name="title" value="{{$data->title}}">
        <span class="text-danger" id="title_error"></span>
  
      </div>
      <div class="col-md-12">
        <label for="details">FAQ Answar</label>
        <textarea name="details" class="summernote" id="details">
            {{$data->details}}
        </textarea>
        <span class="text-danger" id="details_error"></span>
    </div>
    
    <br>
    <div class="form-group row">
     
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="status" id="inlineRadio1" {{ $data->status == 1 ? 'checked' : '' }} value="1">
          <label class="form-check-label" for="inlineRadio1">Active</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="status" id="inlineRadio2" {{ $data->status == 0 ? 'checked' : '' }} value="0">
          <label class="form-check-label" for="inlineRadio2">InActive</label>
        </div>
       
  </div>
  <br>
    
    <button type="submit" class="btn btn-primary" id="btnUpdateData"><i class="fa fa-save"></i>&nbsp; Update </button>

</form>


<script>
    $('.textarea').summernote()

        $(document).on('click','#btnUpdateData',function (event) {
        event.preventDefault();
        $('#title_error').text('');
        $('#details_error').text('');
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
            url: "{{ route('superAdmin.faq.update',$data->id) }}",
            data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (data) {
            Swal.fire(
                    'Success!',
                    'Data has been Added. ' + data.message,
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
                
            }
        });
    });


</script>
<script>
    $('.summernote').summernote({
      placeholder: '',
      height: 200
    });
  </script>
