<form id="edit-form" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label for="title">FAQ Question</label>
        <input type="text" class="form-control" id="title" name="title" placeholder="Enter Question">
        <span class="text-danger" id="title_error"></span>
  
      </div>
    <div class="col-md-12">
        <label for="details">FAQ Answar</label>
        <textarea name="details" class="summernote" id="details"></textarea>
        <span class="text-danger" id="details_error"></span>
    </div>
    <br>
    <button type="submit" class="btn btn-success" id="btnSave"><i class="fa fa-save"></i>&nbsp; Save</button>

</form>


<script>
    $('.textarea').summernote()

    $(document).on('click', '#btnSave', function(e) {
        e.preventDefault();
        $('#title_error').text('');
        $('#details_error').text('');
        let title = $('#title').val();
        let details = $('#details').val();
        $.ajax({
            url: "{{ route('superAdmin.faq.store') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                title:title,
                details:details,
            },
            success: function(response) {
                Swal.fire(
                    'Success!',
                    response.message,
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
