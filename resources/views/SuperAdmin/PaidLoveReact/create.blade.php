<form id="create-form" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label for="gradeName">Grade Name</label>
        <input type="text" class="form-control" id="gradeName" name="gradeName" placeholder="Enter Group Name">
        <span id="gradeName_error" class="text-danger"></span>
    </div>
    <div class="form-group">
        <label for="loveReact">Total React</label>
        <input type="text" class="form-control" id="loveReact" name="loveReact" placeholder="Enter Group Name">
        <span id="loveReact_error" class="text-danger"></span>
    </div>
    <div class="form-group">
        <label for="fee">Price</label>
        <input type="text" class="form-control" id="fee" name="fee" placeholder="Enter Group Name">
        <span id="fee_error" class="text-danger"></span>
    </div>


    <button type="submit" id="addBtn" class="btn btn-primary"><i class="fa fa-save"></i>Save
    </button>

</form>


<script>
    $(document).on('click', '#addBtn', function(event) {
        event.preventDefault();

        $('#loveReact_error').text('');
        $('#gradeName_error').text('');
        $('#fee_error').text('');

        var form = $('#create-form')[0];
        var formData = new FormData(form);

        // Set header if need any otherwise remove setup part
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
            }
        });
        $.ajax({
            url: "{{ route('superAdmin.loveReactPrice.store') }}", // your request url
            data: formData,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function(data) {
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
            error: function(data) {
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
