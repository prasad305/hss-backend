<form id="create-form">
    @csrf
    <input type="hidden" name="country_code" value="{{$code}}">
    <div class="row form-group">
        <div class="col-md-12">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title">
            <span class="text-danger" id="title_error"></span>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-12">
            <label for="description">Description</label>
            <textarea id="summernote" name="description" id="description"></textarea>
            <span class="text-danger" id="description_error"></span>
        </div>
    </div>

    <button type="submit" class="btn btn-primary" id="createMessage"><i class="fa fa-save"></i>&nbsp; Message Send </button>

</form>

<script>
    $(document).on('click','#createMessage',function (event) {
        event.preventDefault();
        $('#title_error').text('');
        $('#description_error').text('');
        var form = $('#create-form')[0];
        var formData = new FormData(form);

        // Set header if need any otherwise remove setup part
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
            }
        });
        $.ajax({
            url: "{{route('superAdmin.countryusernotify')}}",// your request url
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

<script>
    $('#summernote').summernote({
        placeholder: '',
        height: 200
    });
</script>
