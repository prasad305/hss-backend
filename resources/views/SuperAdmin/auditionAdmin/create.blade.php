<form id="create-form" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Audition Name">
    </div>
    <div class="form-group">
        <label for="category">categories</label>
        <select name="category" class="custom-select rounded-0" id="category">
            <option selected disabled>select category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach

        </select>
    </div>


    <button type="submit" id="addAuditionBtn" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Add
        Audition</button>
</form>

<script>
    $(document).on('click', '#addAuditionBtn', function(event) {
        event.preventDefault();
        var form = $('#create-form')[0];
        var formData = new FormData(form);

        // Set header if need any otherwise remove setup part
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
            }
        });
        $.ajax({
            url: "{{ route('superAdmin.audition.store') }}", // your request url
            data: formData,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function(data) {
                console.log(data)
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
