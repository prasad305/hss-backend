<form  id="create-form" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Category Name">
        <span class="text-danger" id="name_error"></span>
    </div>

    <div class="form-group">
        <label for="name">Parent Category</label>
        <select name="category_id" id="category_id" class="form-control select2">
            @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        <span class="text-danger" id="category_id_error"></span>
    </div>

    <span class="row">
        <div class="form-group col-md-6">
            <label for="icon">Icon</label>
            <br><img id="icon1" onchange="validateMultipleImage('icon1')" alt="image" src="" height="180px" width="180px" onerror="this.onerror=null;this.src='{{ asset(get_static_option('no_image')) }}';" required />
            <br><br><input type="file" class="mt-2" id="icon" name="icon" onchange="document.getElementById('icon1').src = window.URL.createObjectURL(this.files[0]); show(this)" accept=".jfif,.jpg,.jpeg,.png,.gif" required>
        </div>
        <div class="form-group col-md-6">
            <label for="image">Image</label>
            <br><img id="image1" onchange="validateMultipleImage('image1')" alt="icon" src="" height="180px" width="180px" onerror="this.onerror=null;this.src='{{ asset(get_static_option('no_image')) }}';" required />
            <br><br><input type="file" class="mt-2" id="image" name="image" onchange="document.getElementById('image1').src = window.URL.createObjectURL(this.files[0]); show(this)" accept=".jfif,.jpg,.jpeg,.png,.gif" required>
        </div>
    </span>
    <button type="submit" id="addSubCategoryBtn" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Add Sub Category</button>

</form>


<script>
    $(document).on('click','#addSubCategoryBtn',function (event) {
        event.preventDefault();
        $('#name_error').text('');
        $('#category_id_error').text('');
        var form = $('#create-form')[0];
        var formData = new FormData(form);
        
        // Set header if need any otherwise remove setup part
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
            }
        });
        $.ajax({
            url: "{{route('superAdmin.subCategory.store')}}",// your request url
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

