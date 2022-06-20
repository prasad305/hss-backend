<form id="create-form" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="name">Category</label>
        <select name="category_id" id="category_id" class="form-control select2">
            <option value="">Select One</option>
            @if(isset($categories[0]))
            @foreach($categories as $data)
                <option value="{{ $data->id }}">{{ $data->name }}</option>
            @endforeach
            @endif
        </select>
        <span id="category_error" class="text-danger"></span>
    </div>

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Group Name">
        <span id="name_error" class="text-danger"></span>
    </div>

    <button type="submit" id="addSubCategoryBtn" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Add Group
        Name</button>

</form>


<script>
    $(document).on('click','#addSubCategoryBtn',function (event) {
        event.preventDefault();
        ErrorMessageClear();
        var form = $('#create-form')[0];
        var formData = new FormData(form);
        
        // Set header if need any otherwise remove setup part
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
            }
        });
        $.ajax({
            url: "{{route('superAdmin.jury_groups.store')}}",// your request url
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
                $.each(data.responseJSON.errors, function(key, value) {
                    ErrorMessage(key, value);
                });
            }
        });
    
    });
</script>