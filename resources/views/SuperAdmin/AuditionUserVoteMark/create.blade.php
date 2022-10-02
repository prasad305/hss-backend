<form id="create-form" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="name">Audition</label>
        <select name="audition_id" id="audition_id" class="form-control select2">
            <option value="">Select One</option>
            @if (isset($auditions[0]))
                @foreach ($auditions as $data)
                    <option value="{{ $data->id }}">{{ $data->title }}</option>
                @endforeach
            @endif
        </select>
        <span id="audition_id_error" class="text-danger"></span>
    </div>

    <div class="form-group">
        <label for="total_react">Total React</label>
        <input type="text" class="form-control" id="total_react" name="total_react" placeholder="Enter Group Name">
        <span id="total_react_error" class="text-danger"></span>
    </div>
    <div class="form-group">
        <label for="user_mark">Vote Mark</label>
        <input type="text" class="form-control" id="user_mark" name="user_mark" placeholder="Enter Group Name">
        <span id="user_mark_error" class="text-danger"></span>
    </div>

    {{-- <div class="form-group">
        <label for="name">Marking Type</label>
        <input type="radio" id="live_mark" name="live_mark" value="1">
        <span>Live</span>
        <input type="radio" id="offline_mark" name="offline_mark" value="0">
        <span>Offline</span>
        <span id="name_error" class="text-danger"></span>
    </div> --}}


    <button type="submit" id="addSubCategoryBtn" class="btn btn-primary"><i class="fa fa-save"></i>Save
    </button>

</form>


<script>
    $(document).on('click', '#addSubCategoryBtn', function(event) {
        event.preventDefault();
        $('#audition_id_error').text('');
        $('#total_react_error').text('');
        $('#user_mark_error').text('');
        
        var form = $('#create-form')[0];
        var formData = new FormData(form);

        // Set header if need any otherwise remove setup part
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
            }
        });
        $.ajax({
            url: "{{ route('superAdmin.userVoteMark.store') }}", // your request url
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
