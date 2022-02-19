<form id="edit-form" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <input type="hidden" name="id" value="" id="id" />
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Category Name" value="{{ $subCategory->name }}">
    </div>

    <div class="form-group">
        <label for="name">Parent Category</label>
        <select name="category_id" id="edit_category_name" class="form-control select2">
            @foreach($categories as $category)
            <option @if($subCategory->category_id == $category->id ) selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <span class="row">
        <div class="form-group col-md-6">
            <label for="icon">Icon</label>
            <br><img id="icon2" onchange="validateMultipleImage('icon2')" alt="image" src="{{ asset($subCategory->icon) }}" height="180px" width="180px" onerror="this.onerror=null; this.src='{{ asset(get_static_option('no_image')) }}';" />
            <br><br><input id="edit_icon2" type="file" class="mt-2" name="icon" onchange="document.getElementById('icon2').src = window.URL.createObjectURL(this.files[0]); show(this)" accept=".jfif,.jpg,.jpeg,.png,.gif" />
        </div>
        <div class="form-group col-md-6">
            <label for="image">Image</label>
            <br><img id="image2" onchange="validateMultipleImage('image2')" alt="icon" src="{{ asset($subCategory->image) }}" height="180px" width="180px" onerror="this.onerror=null; this.src='{{ asset(get_static_option('no_image')) }}';" />
            <br><br><input id="edit_image2" type="file" class="mt-2" name="image" onchange="document.getElementById('image2').src = window.URL.createObjectURL(this.files[0]); show(this)" accept=".jfif,.jpg,.jpeg,.png,.gif" />
        </div>
    </span>

    <button type="submit" id="updateSubCategoryBtn" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Update Sub Category</button>
</form>


<script>
    $(document).on('click','#updateSubCategoryBtn',function (event) {
    event.preventDefault();
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
        url: "{{ route('superAdmin.subCategory.update',$subCategory->id) }}",// your request url
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
            console.log(data);
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
                    })
        }
    });

 });
</script>
