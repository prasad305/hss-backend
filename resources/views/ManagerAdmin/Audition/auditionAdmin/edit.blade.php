<div class="container">
    <form id="edit-form" enctype="multipart/form-data">
        @csrf
        <div class="row form-group">
            <label for="first_name">First Name</label>
            <input type="text" class="form-control" id="first_name" required name="first_name"
                value="{{ $auditionAdmin->first_name }}">
        </div>
        <div class="row form-group">
            <label for="last_name">Last Name</label>
            <input type="text" class="form-control" id="last_name" required name="last_name"
            value="{{ $auditionAdmin->last_name }}">
        </div>
        <div class="row form-group">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" id="phone" required name="phone"
            value="{{ $auditionAdmin->phone }}">
        </div>
        <div class="row form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" required name="email"
            value="{{ $auditionAdmin->email }}">
        </div>
        <div class="row form-group">
            <label for="category">Select Category</label>
            <select name="category" id="category" class="form-control">
                <option value="" disabled selected >select One</option>
                @foreach ($categories as $category)
                    <option @if($category->id == $auditionAdmin->category_id) selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <span class="row">
            <div class="form-group col-md-6">
                <label for="icon">image</label>
                <br><img id="icon1" onchange="validateMultipleImage('icon1')" alt="image" src="" height="180px"
                    width="180px" onerror="this.onerror=null;this.src='{{ asset($auditionAdmin->image ?? get_static_option('no_image')) }}';"
                    required />

                <br><br>

                <input type="file" class="mt-2" id="image" name="image"
                    onchange="document.getElementById('icon1').src = window.URL.createObjectURL(this.files[0]); show(this)"
                    accept=".jfif,.jpg,.jpeg,.png,.gif" required>

            </div>
            <div class="form-group col-md-6">
                <label for="image">Cover</label>
                <br><img id="image1" onchange="validateMultipleImage('image1')" alt="icon" src="" height="180px"
                    width="180px" onerror="this.onerror=null;this.src='{{ asset($auditionAdmin->cover_photo ?? get_static_option('no_image')) }}';"
                    required />
                <br><br>
                <input type="file" class="mt-2" id="cover_photo" name="cover_photo"
                    onchange="document.getElementById('image1').src = window.URL.createObjectURL(this.files[0]); show(this)"
                    accept=".jfif,.jpg,.jpeg,.png,.gif" required>
            </div>
        </span>
      <div class="row float-right">
        <button style="padding: 10px 20px; background: #3A8FF2; border-radius: 5px;" type="submit" class="btn btn-primary mr-4 align-right" id="btnSendData">Submit</button>
      </div>
    </form>
</div>

<script>
    $(document).on('click', '#btnSendData', function(event) {
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
            url: "{{ route('managerAdmin.audition.auditionAdmin.update', $auditionAdmin->id) }}", // your request url
            data: formData,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function(data) {
                Swal.fire(
                    'Success!',
                    'Audition Admin has been Updated. ' + data.message,
                    'success'
                )
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
                })
            }
        });
    });
</script>
