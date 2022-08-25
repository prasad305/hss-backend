<form id="edit-form" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="name">Audition</label>
        <select name="audition_id" id="audition_id" class="form-control select2">
            <option value="">Select One</option>
            @if (isset($auditions[0]))
                @foreach ($auditions as $data)
                    <option {{ $data->id == $voteMark->audition_id ? 'selected' : '' }} value="{{ $data->id }}">
                        {{ $data->title }}</option>
                @endforeach
            @endif
        </select>
        <span id="category_error" class="text-danger"></span>
    </div>

    <div class="form-group">
        <label for="total_react">Total React</label>
        <input type="text" class="form-control" id="total_react" name="total_react"
            value="{{ $voteMark->total_react }}" placeholder="Enter Group Name">
        <span id="total_react_error" class="text-danger"></span>
    </div>
    <div class="form-group">
        <label for="user_mark">Vote Mark</label>
        <input type="text" class="form-control" id="user_mark" name="user_mark" value="{{ $voteMark->user_mark }}"
            placeholder="Enter Group Name">
        <span id="user_mark_error" class="text-danger"></span>
    </div>
    <button type="submit" id="updateJuryGroupBtn" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;
        Update </button>
</form>


<script>
    $(document).on('click', '#updateJuryGroupBtn', function(event) {
        event.preventDefault();
        ErrorMessageClear();
        var form = $('#edit-form')[0];
        var formData = new FormData(form);
        formData.append('_method', 'PUT');
        // Set header if need any otherwise remove setup part
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
            }
        });

        $.ajax({
            url: "{{ route('superAdmin.userVoteMark.update', $voteMark->id) }}", // your request url
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
                console.log(data);
            },
            error: function(data) {

                $.each(data.responseJSON.errors, function(key, value) {
                    ErrorMessage(key, value);
                });

            }
        });

    });
</script>
