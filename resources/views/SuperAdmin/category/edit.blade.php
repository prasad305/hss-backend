<form id="edit-form" enctype="multipart/form-data">
    @csrf
    {{-- @method('PUT') --}}
    <div class="form-group">
      <label for="name">Name</label>
      <input type="text" class="form-control" id="name" name="name" placeholder="Enter Category Name" value="{{ $category->name }}">
    </div>

    <span class="col-md-12 row">

        <div class="form-group col-md-6">
            <label for="image">Image</label>
            <br><img id="image1" src="{{ asset($category->image) }}" onchange="validateMultipleImage('image1')" alt="image" src="" height="200px" width="200px" onerror="this.onerror=null;this.src='{{ asset(get_static_option('no_image')) }}';"/>
            <br><br><input type="file" class="mt-2" id="image" name="image" onchange="document.getElementById('image1').src = window.URL.createObjectURL(this.files[0]); show(this)" accept=".jfif,.jpg,.jpeg,.png,.gif">
        </div>

        <div class="form-group col-md-6">
            <label for="icon">Icon</label>
            <br><img id="icon1" src="{{ asset($category->icon) }}" onchange="validateMultipleImage('icon1')" alt="image" src="" height="200px" width="200px" onerror="this.onerror=null;this.src='{{ asset(get_static_option('no_image')) }}';"/>
            <br><br><input type="file" class="mt-2" id="icon" name="icon" onchange="document.getElementById('icon1').src = window.URL.createObjectURL(this.files[0]); show(this)" accept=".jfif,.jpg,.jpeg,.png,.gif">
        </div>


    </span>

    <button type="submit" id="updateCategoryBtn" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Update Category</button>
</form>

<script>
    $(document).on('click','#updateCategoryBtn',function (event) {
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
        url: "{{ route('superAdmin.category.update',$category->id) }}",// your request url
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

