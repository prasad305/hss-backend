<form id="create-form" >
    @csrf
      <div class="form-group row">
        <div class="col-md-12">
          <label for="acquired_instruction">Instruction</label>
          <textarea id="acquired_instruction" name="acquired_instruction" class="summernote form-control" >
        
          </textarea>
        </div>
    </div>

    <button type="submit" id="addTerms" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Add Instructions</button>
  </form>

  <script>
    $(document).on('click','#addTerms',function (event) {
        event.preventDefault();
       
        let formData = new FormData();
        formData.append('acquired_instruction',acquired_instruction)
        // let acquired_instruction = $('#acquired_instruction').val();
        
        // Set header if need any otherwise remove setup part
        // console.log('formdata',instruction);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: "{{route('superAdmin.auctionTerms.store')}}", // your request url
            data: {
                formData,
                "_token": '{{ csrf_token() }}',
            },
            processData: false,
            contentType: false,
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

 <script>
    $('.summernote').summernote({
      placeholder: 'Enter Instruction',
      height: 200
    });
  </script>

