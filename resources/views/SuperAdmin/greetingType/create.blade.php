<form id="create-form" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
      <label for="greeting_type">Greetings Type</label>
      <input type="text" class="form-control" id="greeting_type" name="greeting_type" placeholder="Enter Greeting Type">
      <span class="text-danger" id="greeting_type_error"></span>
    </div>

    <button type="submit" id="addCategoryBtn" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Add Greeting Type</button>
  </form>

  <script>
    $(document).on('click','#addCategoryBtn',function (event) {
        event.preventDefault();
        $('#greeting_type_error').text('');
        var form = $('#create-form')[0];
        var formData = new FormData(form);
        
        // Set header if need any otherwise remove setup part
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
            }
        });
        $.ajax({
            url: "{{route('superAdmin.greeting-type.store')}}",// your request url
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
                
            }
        });
    
    });
 </script>
