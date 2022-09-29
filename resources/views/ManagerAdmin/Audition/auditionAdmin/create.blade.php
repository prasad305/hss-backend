<div class="container">
    <form id="create-form" enctype="multipart/form-data">
        @csrf
        <div class="row form-group">
            <label for="first_name">First Name</label>
            <input type="text" class="form-control" id="first_name" required name="first_name"
                placeholder="Enter Audition Admin First Name">
                <span class="text-danger" id="first_name_error"></span>
        </div>
        <div class="row form-group">
            <label for="last_name">Last Name</label>
            <input type="text" class="form-control" id="last_name" required name="last_name"
                placeholder="Enter Audition Admin Last Name">
                <span class="text-danger" id="last_name_error"></span>
        </div>
        <div class="row form-group">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" id="phone" required name="phone"
                placeholder="Enter Audition Admin Phone">
                <span class="text-danger" id="phone_error"></span>
        </div>
        <div class="row form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" required name="email"
                placeholder="Enter Audition Admin Email">
                <span class="text-danger" id="email_error"></span>
        </div>
        {{-- <div class="row form-group">
            <label for="category">Select Category</label>
            <select name="category" id="category" class="form-control">
                <option value="" disabled selected >select One</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div> --}}
        <span class="row">
            <div class="form-group col-md-6">
                <label for="icon">image</label>
                <br><img id="icon1" onchange="validateMultipleImage('icon1')" alt="image" src="" height="180px"
                    width="180px" onerror="this.onerror=null;this.src='{{ asset(get_static_option('no_image')) }}';"
                    required />
                    

                <br><br>

                <input type="file" class="mt-2" id="image" name="image"
                    onchange="document.getElementById('icon1').src = window.URL.createObjectURL(this.files[0]); show(this)"
                    accept=".jfif,.jpg,.jpeg,.png,.gif">

            </div>
            <div class="form-group col-md-6">
                <label for="image">Cover</label>
                <br><img id="image1" onchange="validateMultipleImage('image1')" alt="icon" src="" height="180px"
                    width="180px" onerror="this.onerror=null;this.src='{{ asset(get_static_option('no_image')) }}';"
                    required />
                <br><br>
                <input type="file" class="mt-2" id="cover_photo" name="cover_photo"
                    onchange="document.getElementById('image1').src = window.URL.createObjectURL(this.files[0]); show(this)"
                    accept=".jfif,.jpg,.jpeg,.png,.gif">
            </div>
        </span>
      <div class="row float-right">
        <button style="padding: 10px 20px; background: #3A8FF2; border-radius: 5px;" type="submit" class="btn btn-primary mr-4 align-right" id="btnSendData">Submit</button>
      </div>
    </form>
</div>

<script>
    $(document).on('click','#btnSendData',function (event) {
    event.preventDefault();
    ErrorMessageClear(); // clear previous error message
    var form = $('#create-form')[0];
    var formData = new FormData(form);

    // Set header if need any otherwise remove setup part
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
        }
    });
    $.ajax({
        url: "{{route('managerAdmin.audition.auditionAdmin.store')}}",// your request url
        data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (res) {
                setTimeout(function() {
                    location.reload();
                }, 100);
            if (res.type === 'error') {
                Swal.fire(
                    'Error!',
                    res.message,
                    'error'
                )
            }
            
        },
        error: function (data) {
            $.each(data.responseJSON.errors, function(key, value) {
                ErrorMessage(key,value); // validation message show
            });
        }
    });
});

</script>
