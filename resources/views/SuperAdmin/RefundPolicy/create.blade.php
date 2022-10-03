<form id="edit-form" enctype="multipart/form-data">
    @csrf

    <div class="col-md-12">
        <label for="title">Refund Policy Title</label>
        <input type="text" name="title" class="form-control" id="title">
        <span class="text-danger" id="title_error"></span>
    </div>
    <div class="col-md-12">
        <label for="details">Refund Policy Description</label>
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
        let title = $('#title').val();
        let details = $('#details').val();
        $.ajax({
            url: "{{ route('superAdmin.refundpolicy.store') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                title: title,
                details: details,
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
            error: function(response) {
                $.each(response.responseJSON.errors, function(key, value) {
                    ErrorMessage(key, value);
                });
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