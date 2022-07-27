<form id="edit-form" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="name">Category</label>
        <select name="category_id" id="category_id" class="form-control select2">
            <option value="">Select One</option>
            @if(isset($categories[0]))
            @foreach($categories as $data)
                <option {{ $data->id == $group->category_id ? 'selected' : '' }} value="{{ $data->id }}">{{ $data->name }}</option>
            @endforeach
            @endif
        </select>
        <span id="category_error" class="text-danger"></span>
    </div>
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Group Name"
            value="{{ $group->name }}">
            <span id="name_error" class="text-danger"></span>
    </div>

    <div class="form-group">
        <label for="name">Is Primary Group</label>
        <input type="radio"  id="is_primary" {{$group->is_primary == 1 ? 'checked' : ''}} name="is_primary" value="1">
        <span>Yes</span>
        <input type="radio" id="is_primary" {{$group->is_primary == 0 ? 'checked' : ''}} name="is_primary" value="0">
        <span>No</span>
        <span id="name_error" class="text-danger"></span>
    </div>


    <button type="submit" id="updateJuryGroupBtn" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Update Jury Group</button>
</form>


<script>
    $(document).on('click','#updateJuryGroupBtn',function (event) {
    event.preventDefault();
    ErrorMessageClear();
    var form = $('#edit-form')[0];
    var formData = new FormData(form);
    formData.append('_method','PUT');
    // Set header if need any otherwise remove setup part
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
        }
    });

    $.ajax({
        url: "{{ route('superAdmin.jury_groups.update',$group->id) }}",// your request url
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
            console.log(data);
        },
        error: function (data) {
           
            $.each(data.responseJSON.errors, function(key, value) {
                ErrorMessage(key, value);
            });
                  
        }
    });

 });
</script>