<form id="create-form" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
      <label for="name">Educationlevel Name</label>
      <input type="text" class="form-control" id="name" name="name" placeholder="Enter Educationlevel Name">
      <small id="name_error" class="form-text text-danger"></small>
    </div>

    
    

    <button type="submit" id="addCategoryBtn" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Add Educationlevel</button>
  </form>

  <script>
    $(document).on('click','#addCategoryBtn',function (event) {
        event.preventDefault();
        $('#name_error').text('');
        var form = $('#create-form')[0];
        var formData = new FormData(form);
        
        // Set header if need any otherwise remove setup part
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
            }
        });
        $.ajax({
            url: "{{route('superAdmin.educationlevel.store')}}",// your request url
            data: formData,
            processData: false,
            contentType: false,
            type: 'POST',
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
                    $("#" + key + "_error").text(value[0]);
                });
                errorMessage += '</span>\n' +
                    '</div>\n' +
                    '</div>';
                // Swal.fire({
                //     icon: 'error',
                //     title: 'Oops...',
                //     footer: errorMessage
                // });
            }
        });
    
    });


    
    
  
 </script>
