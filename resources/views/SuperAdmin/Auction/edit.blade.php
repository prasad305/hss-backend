<form id="edit-form" enctype="multipart/form-data">
    @csrf

    <div class="col-md-12">
        <label for="acquired_instruction">Acquired Instruction</label>
        <textarea name="acquired_instruction" class="summernote" id="acquired_instruction">
            {{$instruction->acquired_instruction}}
        </textarea>
        <span class="text-danger" id="acquired_instruction_error"></span>
    </div>
    <br>
    <button type="submit" class="btn btn-success" id="btnSave"><i class="fa fa-save"></i>&nbsp; Update </button>

</form>


<script>
    $('.textarea').summernote()

    $(document).on('click', '#btnSave', function(e) {
        e.preventDefault();
        let acquired_instruction = $('#acquired_instruction').val();
        $.ajax({
            url: "{{ route('superAdmin.auctionTerms.update',$instruction->id) }}",
            type: "PUT",
            data: {
                "_token": "{{ csrf_token() }}",
                acquired_instruction: acquired_instruction,
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
                // console.log(response);
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
